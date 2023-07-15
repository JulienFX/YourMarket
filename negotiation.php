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
        require_once("connexionDB.php");
        global $conn;

        // Récupérer l'username de l'utilisateur connecté
        $username = $_SESSION["username"];

        // Récupérer les offres en attente pour l'utilisateur connecté
        $pendingOffersQuery = "SELECT o.offerId, o.itemId,i.nameItem, o.offerAmount, o.offerTime, i.price AS initialPrice ,r.username as itemOwner
                            FROM offers AS o
                            INNER JOIN items AS i ON o.itemId = i.id
                            INNER JOIN make AS m ON o.offerId = m.offerId
                            inner join sell as r on r.idItem = i.id
                            WHERE m.username = '$username'";
        $pendingOffersResult = $conn->query($pendingOffersQuery);

        if ($pendingOffersResult->num_rows > 0) {
            echo "<h3>Pending Offers:</h3>";
            echo "<table>";
            echo "<tr><th>Item Name</th><th>Offered Price</th><th>Initial Price</th><th>Item Owner</th><th>Status</th></tr>";

            while ($row = $pendingOffersResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nameItem"] . "</td>";
                echo "<td>£" . $row["offerAmount"] . "</td>";
                echo "<td>£" . $row["initialPrice"] . "</td>";
                echo "<td>" . $row["itemOwner"] . "</td>";
                echo "<td>Pending</td>";
            }

            echo "</table>";
        } else {
            echo "<p>No pending offers.</p>";
        }

        // Récupérer les offres proposées par l'utilisateur connecté
        $proposedOffersQuery = "SELECT o.offerId, o.itemId,i.nameItem, o.offerAmount, o.offerTime, i.price AS initialPrice ,r.username as itemOwner
                                FROM offers AS o
                                INNER JOIN items AS i ON o.itemId = i.id
                                INNER JOIN make AS m ON o.offerId = m.offerId
                                inner join sell as r on r.idItem = i.id
                                WHERE m.towardUsername = '$username'";
        $proposedOffersResult = $conn->query($proposedOffersQuery);

        if ($proposedOffersResult->num_rows > 0) {
            echo "<h3>Proposed Offers:</h3>";
            echo "<table>";
            echo "<tr><th>Item Name</th><th>Offered Price</th><th>Initial Price</th><th>Item Owner</th><th>Status</th><th>Action</th></tr>";

            while ($row = $proposedOffersResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nameItem"] . "</td>";
                echo "<td>£" . $row["offerAmount"] . "</td>";
                echo "<td>£" . $row["initialPrice"] . "</td>";
                echo "<td>" . $row["itemOwner"] . "</td>";
                echo "<td>Pending</td>";
                echo "<td>
                        <form method='post'>
                            <input type='hidden' name='acceptOfferId' value='" . $row["offerId"] . "'>
                            <button type='submit' name='acceptOffer'>Accept</button>
                        </form>
                    </td>";
                echo "</tr>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No proposed offers.</p>";
        }

        // Vérifier si le formulaire d'acceptation d'offre a été soumis
        if (isset($_POST['acceptOffer'])) {
            $offerId = $_POST['acceptOfferId'];
            
            // Mettre à jour le statut de l'offre dans la base de données
            $updateOfferQuery = "UPDATE offers SET validate = 1 WHERE offerId = $offerId";
            $conn->query($updateOfferQuery);
            
            // Recharger la page pour afficher les changements
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
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
