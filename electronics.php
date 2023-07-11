<!DOCTYPE html>
<html>
<head>
    <title>Available Items</title>
    <style>
        .column {
            float: left;
            width: 33.33%;
            padding: 10px;
            box-sizing: border-box;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .item {
            background-color: #f2f2f2;
            padding: 20px;
            margin-bottom: 20px;
        }

        .item img {
            width: 150px;
            height: 150px;
            margin-bottom: 10px;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="Constant/styles.css">
</head>
<body>
    <head>
        <?php
        session_start();
        include('Constant/head.php');
        ?>
    </head>
    <div class="page">
        <nav>
            <?php include('Constant/navbar.php'); ?>
        </nav>
        <div class="content">
            <div class="row">
                <?php
                require_once('connexionDB.php');
                global $conn;

                $currentDatetime = date("Y-m-d H:i:s");

                // Fetch items from the table
                $sql = "SELECT i.id,nameItem,descriptions,price,categories,quantity,sellType,idLink,link,endDate FROM items as i inner join have as h on i.id = h.idItem inner join picturesvideos as pv on h.idLink=pv.id where categories=2 and quantity>0 ";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="column">';
                        echo '<div class="item">';
                        echo '<h2>' . $row["nameItem"] . '</h2>';
                        echo '<img src='. $row["link"] . '>';
                        echo '<p>Descriptions : ' . $row["descriptions"] . '</p>';
                        if($row["sellType"]==1){
                            echo '<p>Price for buy : £' . $row["price"] . '</p>';
                            echo '<button class="add-to-cart">Add to Cart</button><br>';
                            echo '<button onclick="openPayment();">Buy Now</button><br>';
                            echo '<button >Negociate the price</button>';
                        }else{
                            if ($currentDatetime >= $row["endDate"]) {
                                // Le timer est expiré, effectuer les actions nécessaires
                                echo "Le timer a expiré.";
                            } else {
                                $expiryTime = new DateTime($row["endDate"]);
                                $currentDatetimeObj = new DateTime($currentDatetime);
                                $interval = $currentDatetimeObj->diff($expiryTime);
                                $remainingTime = $interval->format('%y années, %m mois, %d jours, %H heures, %I minutes et %S secondes');
                                // Affichage du temps restant
                                echo "Remaining time : " . $remainingTime;
                            }
                            echo '<p>Starting price for bids : £' . $row["price"] . '</p>';
                            echo '<a href="javascript:void(0);" onclick="confirmBid('.$row['id'].', '.$row['price'].');">auction now</a> <br>';
                            // echo '<input type="text" id="bidInput_'.$row["id"].'" name="'.$row["id"].'">';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }
                // Close the database connection
                // if(isset($_GET["itemId"]) && isset($_GET["bidValue"])){
                //     $id = $_GET["itemId"];
                //     $price = $_POST["bidValue"];
                //     $sql = "SELECT count(*) from bids where id='$id'";
                //     $conn->query($sql);
                //     $row = $result->fetch_assoc();
                //     $count = $row['count'];
                //     if($count==0){
                //         $sql = "INSERT INTO bids (itemId VALUES ($id,"
                //     }
                // }
                if (isset($_GET['itemId']) && isset($_GET['bidValue'])) {
                    $itemId = $_GET['itemId'];
                    $bidValue = $_GET['bidValue'];
                
                    $sql = "SELECT * FROM bids WHERE itemId = '$itemId'";
                    $result = $conn->query($sql);
                
                    if ($result->num_rows > 0) {
                        // Une ligne existe déjà, effectuer une mise à jour
                        $sql = "UPDATE bids SET price = '$bidValue' WHERE itemId = '$itemId'";
                
                        if ($conn->query($sql) === TRUE) {
                            echo "Mise à jour réussie";
                        } else {
                            echo "Erreur lors de la mise à jour : " . $conn->error;
                        }
                    } else {
                        // Aucune ligne existante, effectuer une insertion
                        // Vérifier si le prix est de type entier
                        if (is_numeric($bidValue)) {
                            $username = $_SESSION["username"];
                
                            // Vérifier si l'utilisateur connecté a déjà fait une enchère pour l'ID spécifié
                            $sql = "SELECT * FROM place WHERE bidId IN (SELECT id FROM bids WHERE itemId = '$itemId') AND username = '$username'";
                            $result = $conn->query($sql);
                
                            if ($result->num_rows > 0) {
                                echo "Vous avez déjà fait une enchère pour cet article";
                            } else {
                                // Insérer une nouvelle ligne dans la table bids
                                $sql = "INSERT INTO bids (itemId, price) VALUES ('$itemId', '$bidValue')";
                
                                if ($conn->query($sql) === TRUE) {
                                    // Récupérer le bidId de la nouvelle ligne insérée dans la table bids
                                    $bidId = $conn->insert_id;
                
                                    // Insérer une nouvelle ligne dans la table place
                                    $sql = "INSERT INTO place (bidId, username) VALUES ('$bidId', '$username')";
                
                                    if ($conn->query($sql) === TRUE) {
                                        echo "Enchère et emplacement insérés avec succès";
                                    } else {
                                        echo "Erreur lors de l'insertion dans la table place : " . $conn->error;
                                    }
                                } else {
                                    echo "Erreur lors de l'insertion dans la table bids : " . $conn->error;
                                }
                            }
                        } else {
                            echo "Le prix doit être un nombre entier";
                        }
                    }
                } else {
                    // echo "Les variables itemId et bidValue doivent être spécifiées dans l'URL";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <script>
        function openPayment() {
            window.open("payment.php", "_blank");
        }

        function confirmBid(itemId, startingPrice) {
            var bidValue = prompt("Enter your bid price:");

            if (bidValue !== null) {
                var url = "electronics.php?itemId=" + itemId + "&bidValue=" + encodeURIComponent(bidValue);
                window.location.href = url;
            }
        }
    </script>
</body>
</html>
