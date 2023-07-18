<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<style>

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

  </style>
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
        <h1>Auction action</h1>
      <?php
        require_once('connexionDB.php');
        global $conn;
        if (isset($_GET['decline'])) {
            $itemId = $_GET['decline'];

            // Mise à jour du champ "available" dans la table items
            $updateItemQuery = "DELETE FROM items WHERE id = $itemId";
            $conn->query($updateItemQuery);

            // Suppression des offres associées dans la table bids
            $deleteBidsQuery = "DELETE FROM bids WHERE itemId = $itemId";
            $conn->query($deleteBidsQuery);
        }
        if (isset($_GET['validate'])) {
            $itemId = $_GET['validate'];

            // Récupérer la quantité initiale de l'item dans la table items
            $quantityQuery = "SELECT quantity FROM items WHERE id = $itemId";
            $quantityResult = $conn->query($quantityQuery);
            $quantityRow = $quantityResult->fetch_assoc();
            $quantity = $quantityRow['quantity'];

            // Insérer dans la table orders avec l'ID et la quantité correspondants
            $insertOrderQuery = "INSERT INTO orders (itemId, quantity) VALUES ($itemId, $quantity)";
            $conn->query($insertOrderQuery);

            // Insérer dans la table hold avec l'ID de l'utilisateur et l'ID de la commande
            $username = $_SESSION['username'];
            $orderId = $conn->insert_id; // Récupérer l'ID généré de la commande
            $insertHoldQuery = "INSERT INTO hold (username, orderId) VALUES ('$username', $orderId)";
            $conn->query($insertHoldQuery);

            // Décrémenter la quantité dans la table items
            $decrementQuantityQuery = "UPDATE items SET quantity = quantity - $quantity WHERE id = $itemId";
            $conn->query($decrementQuantityQuery);

        }

        // Requête SQL pour récupérer les items correspondant aux critères spécifiés
        $itemQuery = "SELECT id, nameItem, descriptions, price AS initialPrice, endDate, username AS usernameOwner
                    FROM items as i inner join sell as s on i.id=s.idItem 
                    WHERE sellType = 2 AND endDate < NOW() and quantity>0
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
                    echo'<td><a href="auctionVerified.php?validate='.$itemRow['id'].'">Validate</a><br><a href="auctionVerified.php?decline='.$itemRow['id'].'">Decline</a></td>';
                }else{
                    echo "<td>NO</td>";
                    echo "<td>NO</td>";
                    echo'<td><a href="auctionVerified.php?decline='.$itemRow['id'].'">Decline</a>';
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
