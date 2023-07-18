<!DOCTYPE html>
<html>
<head>
<title>Available Items</title>
    <style>
    body {
        font-smooth: antialiased;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .item {
        background-color: #f2f2f2;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        font-family: "Arial", sans-serif;
    }

    .item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .item h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .item p {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .item p.price {
        font-weight: bold;
    }

    .item img {
        width: 150px;
        height: 150px;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .item a {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .item a:hover {
        background-color: #45a049;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .column {
        flex: 0 0 33.33%;
        padding: 10px;
        box-sizing: border-box;
    }
    </style>
    <link rel="stylesheet" type="text/css" href="Constant/styles.css">
</head>
<body>
    <head>
        <?php
        ob_start();
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
                $sql = "SELECT i.id,nameItem,descriptions,price,categories,quantity,sellType,idLink,link,endDate,username FROM items as i inner join have as h on i.id = h.idItem inner join picturesvideos as pv on h.idLink=pv.id inner join sell as s on i.id=s.idItem  where categories=2 and quantity>0";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="column">';
                        echo '<div class="item">';
                        echo '<h2>' . $row["nameItem"] . '</h2>';
                        echo '<img src='. $row["link"] . '>';
                        echo '<p>owner : '.$row["username"].'</p>';
                        echo '<p>Descriptions : ' . $row["descriptions"] . '</p>';
                        if($row["sellType"]==1){
                            echo '<p>' . $row["price"] . '£</p>';
                            echo '<p>Quantity: ' . $row["quantity"] . '</p>';
                            echo '<a href="electronics.php?addTocart=' . $row['id'] . '" >Add to cart </a><br><br>';
                            echo '<a href="payment.php?buy=' . $row['id'] . '" >Buy Now </a><br><br>';
                            echo '<a href="#" onclick="negotiatePrice('.$row['id'].', '.$row['price'].');">Negotiate the price</a>';
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

                            // Requête pour récupérer le prix actuel dans la table bids
                            $bidPriceSql = "SELECT price FROM bids WHERE itemId = " . $row["id"];
                            $bidPriceResult = $conn->query($bidPriceSql);

                            // Vérifier si une offre existe dans la table bids
                            if ($bidPriceResult->num_rows > 0) {
                                $bidPriceRow = $bidPriceResult->fetch_assoc();
                                $currentPrice = $bidPriceRow['price'];

                                // Requête pour récupérer l'username associé à l'offre dans la table place
                                $usernameSql = "SELECT u.username
                                                FROM users AS u
                                                INNER JOIN place AS p ON u.username = p.username
                                                INNER JOIN bids AS b ON p.bidId = b.id
                                                WHERE b.itemId = " . $row["id"];
                                $usernameResult = $conn->query($usernameSql);

                                // Vérifier si l'username existe dans la table place
                                if ($usernameResult->num_rows > 0) {
                                    $usernameRow = $usernameResult->fetch_assoc();
                                    $username = $usernameRow['username'];

                                    // Afficher le champ "Actual Price" avec le prix actuel et l'username
                                    echo '<p>Actual Price: £' . $currentPrice . ' (Offered by: ' . $username . ')</p>';
                                }
                            }

                            echo '<a href="javascript:void(0);" onclick="confirmBid('.$row['id'].', '.$row['price'].');">auction now</a> <br>';
                            // echo '<input type="text" id="bidInput_'.$row["id"].'" name="'.$row["id"].'">';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }

                if (isset($_GET['itemId']) && isset($_GET['bidValue'])) {
                    $itemId = $_GET['itemId'];
                    $bidValue = $_GET['bidValue'];

                    // Vérifier si le prix renseigné est supérieur au prix de l'item
                    $sql = "SELECT price FROM items WHERE id = '$itemId'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $itemPrice = $row['price'];

                        if ($bidValue <= $itemPrice) {
                            echo "Le prix renseigné doit être supérieur au prix de l'item";
                        } else {
                            // Vérifier si une ligne existe déjà dans la table bids avec l'ID spécifié
                            $sql = "SELECT * FROM bids WHERE itemId = '$itemId'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $currentPrice = $row['price'];

                                // Vérifier si le prix renseigné est plus grand que le prix actuel
                                if ($bidValue <= $currentPrice) {
                                    echo "Le prix renseigné doit être supérieur au prix actuel";
                                } else {
                                    // Vérifier si le prix renseigné est supérieur à la valeur initiale de l'attribut price dans la table items
                                    if ($bidValue > $itemPrice) {
                                        // Mise à jour du prix dans la table bids
                                        $sql = "UPDATE bids SET price = '$bidValue' WHERE itemId = '$itemId'";

                                        if ($conn->query($sql) === TRUE) {
                                            echo "Mise à jour réussie";
                                        } else {
                                            echo "Erreur lors de la mise à jour : " . $conn->error;
                                        }
                                    } else {
                                        echo "Le prix renseigné doit être supérieur à la valeur initiale de l'attribut price dans la table items";
                                    }
                                }
                            } else {
                                // Aucune ligne existante, effectuer une insertion
                                // Vérifier si le prix est de type entier
                                if (is_numeric($bidValue)) {
                                    // Vérifier si l'utilisateur connecté a déjà fait une enchère pour l'ID spécifié
                                    $username = $_SESSION["username"];
                                    $sql = "SELECT * FROM place WHERE bidId IN (SELECT id FROM bids WHERE itemId = '$itemId') AND username = '$username'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        echo "Vous avez déjà fait une enchère pour cet article";
                                    } else {
                                        // Vérifier si le prix renseigné est supérieur à la valeur initiale de l'attribut price dans la table items
                                        if ($bidValue > $itemPrice) {
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
                                        } else {
                                            echo "Le prix renseigné doit être supérieur à la valeur initiale de l'attribut price dans la table items";
                                        }
                                    }
                                } else {
                                    echo "Le prix doit être un nombre entier";
                                }
                            }
                        }
                    } else {
                        echo "Aucun item trouvé avec l'ID spécifié";
                    }
                } else if (isset($_GET['itemId']) && isset($_GET['negotiatePrice'])){
                    $itemId = $_GET['itemId'];
                    $offerAmount = $_GET['negotiatePrice'];
                    $offerTime = date("Y-m-d H:i:s");
                    $username = $_SESSION["username"];

                    // Insérer dans la table offers
                    $insertOfferSql = "INSERT INTO offers (itemId, OfferAmount, offerTime) VALUES ('$itemId', '$offerAmount', '$offerTime')";
                    if ($conn->query($insertOfferSql) === TRUE) {
                        $offerId = $conn->insert_id;

                        // Insérer dans la table make
                        $queryTowardUsername = "SELECT username from sell where idItem='$itemId'";
                        $result = $conn->query($queryTowardUsername);
                        $row = $result->fetch_assoc();
                        $towardUsername = $row["username"];
                        $makeSql = "INSERT INTO make (offerId, username, towardUsername) VALUES ('$offerId', '$username', '$towardUsername')";
                        if ($conn->query($makeSql) === TRUE) {
                            echo "Offre et enregistrement effectués avec succès";
                        } else {
                            echo "Erreur lors de l'insertion dans la table make : " . $conn->error;
                        }
                    } else {
                        echo "Erreur lors de l'insertion dans la table offers : " . $conn->error;
                    }
                }
                if (isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];
                    if (isset($_GET["addTocart"])) {
                        $value = $_GET['addTocart'];
                        $sql = "SELECT COUNT(*) AS count FROM possess WHERE username = '$username'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $count = $row['count'];
                            if ($count == 0) {
                                $sql = "INSERT INTO shoppingcart (quantity) VALUES (?)";
                                $stmt = $conn->prepare($sql);

                                $stmt->bind_param("i", $quantity);

                                $quantity = 1;

                                if ($stmt->execute()) {
                                    $sql = "SELECT cartId FROM  shoppingcart ORDER BY cartId DESC LIMIT 1";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $cartId = $row['cartId'];
                                        $sql = "INSERT INTO possess (username, cartId) VALUES (?, ?)";
                                        $stmt = $conn->prepare($sql);
                                        // Bind the parameter values
                                        $stmt->bind_param("si", $username, $cartId);

                                        // Execute the statement
                                        $stmt->execute();

                                        // Check if the insertion was successful
                                        if ($stmt->affected_rows > 0) {
                                            $sql = "INSERT INTO contains (cartId, itemId) VALUES (?, ?)";
                                            $stmt = $conn->prepare($sql);
                                            // Bind the parameter values
                                            $stmt->bind_param("si", $cartId, $value);

                                            // Execute the statement
                                            $stmt->execute();

                                            // Check if the insertion was successful
                                            if ($stmt->affected_rows > 0) {
                                                //echo "Record inserted successfully.";
                                            }
                                        }
                                    }
                                }
                            } else {
                                $sql = "SELECT * FROM possess WHERE username = '$username'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $cartId = $row['cartId']; // Assuming the column name for the cart ID is 'cart_id'
                
                                    $sql = "SELECT COUNT(*) AS count FROM contains WHERE cartId = '$cartId' AND itemId = '$value'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $count = $row['count'];
                                        if ($count == 0) {
                                            $sql = "INSERT INTO contains (cartId, itemId) VALUES (?, ?)";
                                            $stmt = $conn->prepare($sql);
                                            // Bind the parameter values
                                            $stmt->bind_param("si", $cartId, $value);

                                            // Execute the statement
                                            $stmt->execute();

                                            // Check if the insertion was successful
                                            if ($stmt->affected_rows > 0) {
                                                $sql = "SELECT * FROM shoppingcart WHERE cartId = '$cartId'";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $quantity = $row['quantity'] + 1;
                                                    $sql = "UPDATE shoppingcart SET quantity = $quantity WHERE cartId = '$cartId'";
                                                    if ($conn->query($sql) === TRUE) {
                                                        //echo "Quantity updated successfully.";
                                                    }
                                                }
                                            }
                                            $stmt->close();
                                        } else {
                                            $sql = "SELECT * FROM contains WHERE cartId = '$cartId' AND itemId = '$value'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $quantity = $row['quantity'] + 1;
                                                $sql = "UPDATE contains SET quantity = $quantity WHERE cartId = '$cartId' AND itemId = '$value'";
                                                if ($conn->query($sql) === TRUE) {
                                                    $sql = "SELECT * FROM shoppingcart WHERE cartId = '$cartId'";
                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        $quantity = $row['quantity'] + 1;
                                                        $sql = "UPDATE shoppingcart SET quantity = $quantity WHERE cartId = '$cartId'";
                                                        if ($conn->query($sql) === TRUE) {
                                                           // echo "Quantity updated successfully.";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        header('Location: electronics.php');
                        ob_end_clean();
                        exit;
                    }
                } else {
                    if (isset($_GET["addTocart"])) {
                        header('Location: UserConnexion/formLoginRegister.php');
                        ob_end_clean();
                        exit;
                    }
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <footer>
        <?php
        include('Constant/footer.php');
        ?>
    </footer>
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

        function negotiatePrice(itemId, maxPrice) {
            var price = prompt("Enter your offer price (less than " + maxPrice + "):");

            if (price !== null) {
                if (price >= maxPrice) {
                    alert("The offer price must be less than the item's price.");
                } else {
                    var url = "electronics.php?itemId=" + itemId + "&negotiatePrice=" + encodeURIComponent(price);
                    window.location.href = url;
                }
            }
        }
    </script>
</body>
</html>
