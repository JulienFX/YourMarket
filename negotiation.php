<?php         ob_start();
session_start(); ?>
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

        // Handle Accepting Offer
        if (isset($_GET['itemId']) && isset($_GET['quantity']) && isset($_GET['owner']) && isset($_GET['proposedBy']) && isset($_GET['offerId'])) {
            $itemId = $_GET['itemId'];
            $quantity = $_GET['quantity'];
            $owner = $_GET['owner'];
            $proposedBy = $_GET['proposedBy'];
            $offerId = $_GET['offerId'];

            // Update the status of the offer to 2 (Accepted) in the "offers" table
            $updateOfferQuery = "UPDATE offers SET validate = 2 WHERE offerId = $offerId";
            $conn->query($updateOfferQuery);

            // Insert the accepted offer into the "order" table
            $insertOrderQuery = "INSERT INTO `orders` (itemId, quantity, purchaseDate) VALUES ($itemId, 1, NOW())";
            $conn->query($insertOrderQuery);

            // Get the orderId (primary key of the "order" table) of the inserted order
            $orderId = $conn->insert_id;

            // Insert the orderId and username into the "hold" table
            $insertHoldQuery = "INSERT INTO hold (orderId, username) VALUES ($orderId, '$proposedBy')";
            $conn->query($insertHoldQuery);

            $newQuantity = $quantity-1;
            $decreaseItem = "UPDATE items set quantity=$newQuantity where id=$itemId";
            $conn->query($decreaseItem);

            // Redirect back to the original page to display the updated information
            ob_end_clean();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        if(isset($_GET["offerIdDecline"])){
            $offerId= $_GET["offerIdDecline"];
            $sql = "UPDATE offers set validate=1 where offerId=$offerId";
            $conn->query($sql);
        }

        // Récupérer les offres en attente pour l'utilisateur connecté
        $pendingOffersQuery = "SELECT o.offerId, o.itemId,i.nameItem, o.offerAmount, o.offerTime, i.price AS initialPrice ,r.username as itemOwner,o.validate
                              FROM offers AS o
                              INNER JOIN items AS i ON o.itemId = i.id
                              INNER JOIN make AS m ON o.offerId = m.offerId
                              inner join sell as r on r.idItem = i.id
                              WHERE m.username = '$username'";
        $pendingOffersResult = $conn->query($pendingOffersQuery);

        if ($pendingOffersResult->num_rows > 0) {
            echo "<h3>Offers made:</h3>";
            echo "<table>";
            echo "<tr><th>Item Name</th><th>Offered Price</th><th>Initial Price</th><th>Item Owner</th><th>Status</th></tr>";

            while ($row = $pendingOffersResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nameItem"] . "</td>";
                echo "<td>£" . $row["offerAmount"] . "</td>";
                echo "<td>£" . $row["initialPrice"] . "</td>";
                echo "<td>" . $row["itemOwner"] . "</td>";
                if($row["validate"]==0){
                    echo "<td>Pending</td>";
                }else if($row["validate"]==1){
                    echo "<td>Refused</td>";
                }else{
                    echo "<td>Validated</td>";
                }
                
            }

            echo "</table>";
        } else {
            echo "<p>No pending offers.</p>";
        }

        // Récupérer les offres proposées par l'utilisateur connecté
        $proposedOffersQuery = "SELECT i.quantity,o.offerId, o.itemId,i.nameItem, o.offerAmount, o.offerTime, i.price AS initialPrice ,r.username as itemOwner,m.username as proposedBy,o.validate
                                FROM offers AS o
                                INNER JOIN items AS i ON o.itemId = i.id
                                INNER JOIN make AS m ON o.offerId = m.offerId
                                inner join sell as r on r.idItem = i.id
                                WHERE m.towardUsername = '$username' and validate=0";
        $proposedOffersResult = $conn->query($proposedOffersQuery);

        if ($proposedOffersResult->num_rows > 0) {
            echo "<h3>Proposed Offers:</h3>";
            echo "<table>";
            echo "<tr><th>Item Name</th><th>Offered Price</th><th>Initial Price</th><th>Item Owner</th><th>Proposed by</th><th>Status</th><th colspan=3>Action</th></tr>";

            while ($row = $proposedOffersResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nameItem"] . "</td>";
                echo "<td>£" . $row["offerAmount"] . "</td>";
                echo "<td>£" . $row["initialPrice"] . "</td>";
                echo "<td>" . $row["itemOwner"] . "</td>";
                echo "<td>" . $row["proposedBy"] . "</td>";
                
                echo "<td>Pending</td>";
                
                
                echo '<td>
                    <a href="' . $_SERVER['PHP_SELF'] . '?itemId='.$row["itemId"].'&quantity='.$row["quantity"].'&owner='.$row["itemOwner"].'&proposedBy='.$row["proposedBy"].'&offerId='.$row["offerId"].'">Accept</a>
                    </td>';
                echo '<td>
                    <a href="' . $_SERVER['PHP_SELF'] . '?offerIdDecline='.$row["offerId"].'">Decline</a>
                    </td>';
                echo "</tr>";
                
            }

            echo "</table>";
        } else {
            echo "<p>No proposed offers.</p>";
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
