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
      <?php
        require_once('connexionDB.php');
        global $conn;

        // Requête SQL pour récupérer les items correspondant aux critères spécifiés
        $itemQuery = "SELECT id, nameItem, descriptions, price AS initialPrice, endDate, username AS usernameOwner
                    FROM items as i inner join sell as s on i.id=s.idItem 
                    WHERE sellType = 2 AND endDate < NOW()
                    ORDER BY endDate ASC";

        $itemResult = $conn->query($itemQuery);

        if ($itemResult->num_rows > 0) {
            echo '<table>
                    <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Prix initial</th>
                        <th>Date de fin</th>
                        <th>Propriétaire</th>
                        <th>Prix final</th>
                        <th>Acheteur</th>
                        <th>Action</th>
                    </tr>';

            while ($itemRow = $itemResult->fetch_assoc()) {
                $itemId = $itemRow['id'];

                // Requête SQL pour récupérer les informations de l'enchère correspondant à l'item
                $bidQuery = "SELECT price AS finalPrice
                            FROM bids
                            WHERE itemId = $itemId";

                $bidResult = $conn->query($bidQuery);
                $bidRow = $bidResult->fetch_assoc();

                // Requête SQL pour récupérer le nom de l'acheteur
                $buyerQuery = "SELECT username
                            FROM place
                            WHERE bidId = (
                                SELECT bidId
                                FROM bids
                                WHERE itemId = $itemId
                                LIMIT 1
                            )";

                $buyerResult = $conn->query($buyerQuery);
                $buyerRow = $buyerResult->fetch_assoc();

                echo '<tr>';
                echo '<td>' . $itemRow['nameItem'] . '</td>';
                echo '<td>' . $itemRow['descriptions'] . '</td>';
                echo '<td>' . $itemRow['initialPrice'] . '</td>';
                echo '<td>' . $itemRow['endDate'] . '</td>';
                echo '<td>' . $itemRow['usernameOwner'] . '</td>';
                if(isset($bidRow['finalPrice']) && isset($buyerRow['username'])){
                    echo '<td>' . $bidRow['finalPrice'] . '</td>';
                    echo '<td>' . $buyerRow['username'] . '</td>';
                }else{
                    echo "<td>NO</td>";
                    echo "<td>NO</td>";
                    echo'<td><a href="">refuse and remove the product</a><br><a href="">accept the offer</a></td>';
                }
                
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'Aucun résultat trouvé.';
        }

        // Fermer la connexion à la base de données
        $conn->close();
        ?>


      </div>
    </div>
  <footer>
    <?php 
    include('Constant/footer.php'); 
    ?>
  </footer>
</body>
</html>
