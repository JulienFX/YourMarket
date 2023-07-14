<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <style>
        .container {
            border-radius: 10px;
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 40px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .cart-item-container {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            flex-grow: 1;
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .cart-item-container:hover {
            background-color: #e9e9e9;
        }

        .item-image {
            width: 100px;
            height: 100px;
            margin-right: 20px;
            object-fit: cover;
        }

        .item-details {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .item-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .item-quantity {
            margin-bottom: 5px;
        }

        .item-date {
            color: #888;
        }

        .paid-banner {
            background-color: #5cb85c;
            color: #fff;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 5px;
        }

        /* Classe pour les éléments du conteneur */
        .item-details > span {
            flex-grow: 1;
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
            <?php
            require_once('connexionDB.php');
            global $conn;
            // Fetch items from the table
            $username = $_SESSION["username"];
            $sql = "SELECT o.purchaseDate, i.nameItem, o.quantity, p.link FROM orders o JOIN items i ON o.itemId = i.Id JOIN hold h ON h.orderId = o.orderId JOIN picturesvideos p ON o.itemId = p.id WHERE h.username = '$username' ORDER BY o.purchaseDate DESC";

            $result = $conn->query($sql);

            // Display the cart items
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $nameItem = $row["nameItem"];
                    $quantity = $row["quantity"];
                    $itemImage = $row["link"];
                    $purchaseDate = $row["purchaseDate"];
                    echo "<div class='cart-item'>";
                    echo "<div class='cart-item-container'>";
                    echo "<img class='item-image' src='$itemImage' alt='Item Image'>";
                    echo "<div class='item-details'>";
                    echo "<span class='item-name'>$nameItem</span>";
                    echo "<span class='item-quantity'>$quantity</span>";
                    echo "<span class='item-date'>$purchaseDate</span>";
                    echo "</div>";
                    echo "<span class='paid-banner'>Paid</span>";
                    echo "</div>";
                    echo "</div>";
                }
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
