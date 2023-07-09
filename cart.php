<!DOCTYPE html>
<html>

<head>
    <title>Your Cart</title>
    <style>
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .item-image {
            width: 100px;
            height: 100px;
            margin-right: 20px;
        }

        .quantity-input {
            width: 50px;
        }

        .edit-link,
        .delete-link {
            margin-left: 10px;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="Constant/styles.css">
</head>

<body>

    <head>
        <?php
        session_start();
        include('Constant/head.php'); ?>
    </head>
    <div class="page">
        <nav>
            <?php include('Constant/navbar.php'); ?>
        </nav>
        <div class="content">
            <?php
            if (isset($_SESSION['username'])) {
                require_once('connexionDB.php');
                global $conn;

                // Replace with the actual username you want to query
                $username = $_SESSION['username'];

                $sql = "SELECT * FROM possess JOIN contains ON possess.cartId = contains.cartId JOIN picturesvideos ON contains.itemId = picturesvideos.id WHERE possess.username = '$username'";

                $result = $conn->query($sql);

                // Display the cart items
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $itemId = $row["itemId"];
                        $sql = "DELETE FROM contains WHERE itemId NOT IN (SELECT id FROM items)";
                        if ($conn->query($sql) === TRUE) {

                        }
                    }
                }

                // SQL query to retrieve cart items
                $sql = "SELECT * FROM possess JOIN contains ON possess.cartId = contains.cartId JOIN picturesvideos ON contains.itemId = picturesvideos.id WHERE possess.username = '$username'";

                $result = $conn->query($sql);

                // Display the cart items
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $itemImage = $row["link"];
                        $quantity = $row["quantity"];
                        $cartId = $row["cartId"];
                        $itemId = $row["itemId"];

                        $sql = "SELECT price, quantity FROM items WHERE id = '$itemId'";
                        $res = $conn->query($sql);

                        // Display the cart items
                        if ($res->num_rows > 0) {
                            while ($r = $res->fetch_assoc()) {
                                $price = $r["price"];
                                $itemQuantity = $r["quantity"];
                                if($quantity>$itemQuantity){
                                    $quantity = $itemQuantity;
                                    $sql = "UPDATE contains SET quantity = $quantity WHERE cartId = '$cartId' AND itemId = '$itemId'";
                                    if ($conn->query($sql) === TRUE) {

                                    }
                                }
                                $price = $price*$quantity;
                            }
                        }
                        echo "<div class='cart-item'>";
                        echo "<img class='item-image' src='$itemImage' alt='Item Image'>";
                        echo "<span>Quantity: <input class='quantity-input' type='number' name='quantity[$cartId]' value='$quantity' min='1'></span>";
                        echo "<span>Price: $price £</span>";
                        echo "<a class='delete-link' href='cart.php?delete=$itemId'>Delete</a>";
                        echo "</div>";
                    }
                }
                if (isset($_GET["delete"])) {
                    $itemId = $_GET["delete"];
                    $sql = "DELETE FROM contains WHERE itemId = '$itemId' AND cartId = '$cartId'";

                    if ($conn->query($sql) === TRUE) {
                        header('Location: cart.php');
                    }
                }
                // Close the connection
                $conn->close();
            } else {
                header('Location: UserConnexion/formLoginRegister.php');
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