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
        .edit-link, .delete-link {
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

                // SQL query to retrieve cart items
                $sql = "SELECT * FROM possess JOIN contains ON possess.cartId = contains.cartId JOIN picturesvideos ON contains.itemId = picturesvideos.id WHERE possess.username = '$username'";

                $result = $conn->query($sql);

                // Display the cart items
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $itemImage = $row["link"];
                        $quantity = $row["quantity"];
                        $cartId = $row["cartId"];

                        echo "<div class='cart-item'>";
                        echo "<img class='item-image' src='$itemImage' alt='Item Image'>";
                        echo "<span>Quantity: <input class='quantity-input' type='number' name='quantity[$cartId]' value='$quantity' min='1'></span>";
                        echo "<a class='edit-link' href='edit_cart.php?cartId=$cartId'>Edit</a>";
                        echo "<a class='delete-link' href='delete_cart.php?cartId=$cartId'>Delete</a>";
                        echo "</div>";
                    }
                } else {
                    echo "No items found in the cart.";
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