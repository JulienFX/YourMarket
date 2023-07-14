<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <style>
        /* Ajoutez ces règles CSS dans votre balise <style> existante */
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .cart-item:hover {
            background-color: #e9e9e9;
        }

        .item-image {
            width: 100px;
            height: 100px;
            margin-right: 20px;
            object-fit: cover;
        }

        .item-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
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

        .banner {
            background-color: #ddd;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 5px;
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
                    echo "<img class='item-image' src='$itemImage' alt='Item Image'>";
                    echo "<div class='item-details'>";
                    echo "<span class='item-name'>$nameItem</span>";
                    echo "<span class='item-quantity'>Quantity: <input class='quantity-input' type='number' name='' value='$quantity' min='1'></span>";
                    echo "<span class='item-date'>$purchaseDate</span>";
                    echo "</div>";
                    echo "<span class='banner'>New!</span>";
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
