<!DOCTYPE html>
<html>

<head>
    <title>Your Cart</title>
    <style>
        body {
            background-color: #f2f2f2;
        }

        table {
            width: 100%;
            background-color: #fff;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #ccc;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .quantity {
            display: inline-block;
            padding: 5px;
            border: 1px solid #ccc;
            width: 60px;
            text-align: center;
            margin: 0 auto;
        }

        .delete-link {
            display: inline-block;
            vertical-align: middle;
            margin-right: 5px;
        }

        .item-image {
            vertical-align: middle;
            max-width: 100px;
            max-height: 100px;
        }

        .price {
            text-align: center;
            padding: 5px;
            width: 80px;
        }

        .price strong {
            font-weight: bold;
        }

        .subtotal-table {
            width: 30%;
            margin-left: auto;
            margin-right: auto; /* Center the table */
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .subtotal-table th,
        .subtotal-table td {
            padding: 5px;
            text-align: center; /* Center the text */
        }

        .subtotal-link {
            display: block;
            width: fit-content;
            margin: 20px auto; /* Center the button */
            padding: 10px 20px;
            text-align: center;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 10px; /* Increase the border radius */
        }
    </style>
    <link rel="stylesheet" type="text/css" href="Constant/styles.css">
</head>

<body>
    <head>
        <?php
        session_start();
        include('Constant/head.php');
        ?>
    </head>
    <div class="page">
        <nav>
            <?php include('Constant/navbar.php'); ?>
        </nav>
        <div class="content">
            <?php
            ob_start();
            if (isset($_SESSION['username'])) {
                require_once('connexionDB.php');
                global $conn;

                $username = $_SESSION['username'];

                $sql = "SELECT * FROM possess JOIN contains ON possess.cartId = contains.cartId JOIN picturesvideos ON contains.itemId = picturesvideos.id WHERE possess.username = '$username'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Product</th>";
                    echo "<th>Price</th>";
                    echo "<th>Quantity</th>";
                    echo "</tr>";

                    $row_count = 0;
                    while ($row = $result->fetch_assoc()) {
                        $itemId = $row["itemId"];
                        $sql = "DELETE FROM contains WHERE itemId NOT IN (SELECT id FROM items)";
                        if ($conn->query($sql) === TRUE) {

                        }

                        $row_count++;
                        $itemImage = $row["link"];
                        $quantity = $row["quantity"];
                        $cartId = $row["cartId"];
                        $itemId = $row["itemId"];

                        $sql = "SELECT price, quantity FROM items WHERE id = '$itemId'";
                        $res = $conn->query($sql);

                        if ($res->num_rows > 0) {
                            while ($r = $res->fetch_assoc()) {
                                $price = $r["price"];
                                $itemQuantity = $r["quantity"];
                                if ($quantity > $itemQuantity) {
                                    $quantity = $itemQuantity;
                                    $sql = "UPDATE contains SET quantity = $quantity WHERE cartId = '$cartId' AND itemId = '$itemId'";
                                    if ($conn->query($sql) === TRUE) {

                                    }
                                }
                                $price = $price * $quantity;
                            }
                        }

                        echo "<tr>";
                        echo "<td>";
                        echo "<a class='delete-link' href='cart.php?delete=$itemId'>";
                        echo "<img src='Photos/delete-icon.png' alt='Delete Icon'>";
                        echo "</a>";
                        echo "<img class='item-image' src='$itemImage' alt='Item Image'>";
                        echo "</td>";
                        echo "<td class='price'><strong>$price £</strong></td>";
                        echo "<td><div class='quantity'>$quantity</div></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<p>Your cart is empty.</p>"; // Display a message when the cart is empty
                }
                echo "</table>";

                $sql = "SELECT SUM(items.price * contains.quantity) AS subtotal FROM possess JOIN contains ON possess.cartId = contains.cartId JOIN items ON contains.itemId = items.id WHERE possess.username = '$username'";
                $subtotal_result = $conn->query($sql);
                $subtotal = 0;
                if ($subtotal_result->num_rows > 0) {
                    $subtotal_row = $subtotal_result->fetch_assoc();
                    $subtotal = $subtotal_row["subtotal"];
                }

                if ($result->num_rows > 0) {
                    echo "<table class='subtotal-table'>";
                    echo "<tr>";
                    echo "<th>Subtotal</th>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td><strong>$subtotal £</strong></td>";
                    echo "</tr>";
                    echo "</table>";

                    echo "<a class='subtotal-link' href='payment.php?cartId=0'>Checkout</a>";
                }

                if (isset($_GET["delete"])) {
                    $itemId = $_GET["delete"];
                    $sql = "DELETE FROM contains WHERE itemId = '$itemId' AND cartId = '$cartId'";

                    if ($conn->query($sql) === TRUE) {
                        ob_end_clean();
                        header('Location: cart.php');
                        exit;
                    }
                }

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
