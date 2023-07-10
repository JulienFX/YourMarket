<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="Constant/styles.css">
</head>
<body>
    <head>
        <?php include('Constant/head.php'); ?>
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
                $sql = "SELECT i.id,nameItem,descriptions,price,categories,quantity,sellType,idLink,link,endDate FROM items as i inner join have as h on i.id = h.idItem inner join picturesvideos as pv on h.idLink=pv.id where quantity>0 ";
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
                            echo '<a href="findItems.php?delId='.$row["id"].'">Delete Item</a><br>';
                            
                            
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
                            echo '<a href="findItems.php?delId='.$row["id"].'">Delete Item</a><br>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }
                if(isset($_GET["delId"])){
                    $idToDelete=$_GET["delId"];
                    $query = "DELETE FROM items where id ='$idToDelete'";
                    if($conn->query($query)===true){
                        header("Location:findItems.php");
                    }else{
                        echo "non";
                    }
                }
                // Close the database connection
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
</body>
</html>
