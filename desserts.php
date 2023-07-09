<!DOCTYPE html>
<html>

<head>
    <title>Available Items</title>
    <style>
        .column {
            float: left;
            width: 33.33%;
            padding: 10px;
            box-sizing: border-box;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .item {
            background-color: #f2f2f2;
            padding: 20px;
            margin-bottom: 20px;
        }

        .item img {
            width: 150px;
            height: 150px;
            margin-bottom: 10px;
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
            <div class="row">
                <?php
                require_once('connexionDB.php');
                global $conn;
                // Fetch items from the table
                $sql = "SELECT i.id,nameItem,descriptions,price,categories,quantity,sellType,idLink,link FROM items as i inner join have as h on i.id = h.idItem inner join picturesvideos as pv on h.idLink=pv.id where categories=1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="column">';
                        echo '<div class="item">';
                        echo '<h2>' . $row["nameItem"] . '</h2>';
                        echo '<img src=' . $row["link"] . '>';
                        echo '<p>' . $row["descriptions"] . '</p>';
                        echo '<p>£' . $row["price"] . '</p>';
                        echo '<p>Quantity Available: ' . $row["quantity"] . '</p>';
                        echo '<a href="desserts.php?addTocart=' . $row['id'] . '" >Add to cart </a><br><br>';
                        //echo '<button class="add-to-cart">Add to Cart</button><br><br>';
                        echo '<a href="payment.php?buy=' . $row['id'] . '" >Buy Now </a><br><br>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                if (isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];
                    if (isset($_GET["addTocart"])) {
                        $value = $_GET['addTocart'];
                        $sql = "SELECT COUNT(*) AS count FROM possess WHERE username = '$username'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $count = $row['count'];
                            if ($count == 0) {
                                $sql = "INSERT INTO shoppingcart (quantity) VALUES (?)";
                                $stmt = $conn->prepare($sql);

                                $stmt->bind_param("i", $quantity);

                                $quantity = 1;

                                if ($stmt->execute()) {
                                    $sql = "SELECT cartId FROM  shoppingcart ORDER BY cartId DESC LIMIT 1";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $cartId = $row['cartId'];
                                        $sql = "INSERT INTO possess (username, cartId) VALUES (?, ?)";
                                        $stmt = $conn->prepare($sql);
                                        // Bind the parameter values
                                        $stmt->bind_param("si", $username, $cartId);

                                        // Execute the statement
                                        $stmt->execute();

                                        // Check if the insertion was successful
                                        if ($stmt->affected_rows > 0) {
                                            $sql = "INSERT INTO contains (cartId, itemId) VALUES (?, ?)";
                                            $stmt = $conn->prepare($sql);
                                            // Bind the parameter values
                                            $stmt->bind_param("si", $cartId, $value);

                                            // Execute the statement
                                            $stmt->execute();

                                            // Check if the insertion was successful
                                            if ($stmt->affected_rows > 0) {
                                                //echo "Record inserted successfully.";
                                            }
                                        }
                                    }
                                }
                            } else {
                                $sql = "SELECT * FROM possess WHERE username = '$username'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $cartId = $row['cartId']; // Assuming the column name for the cart ID is 'cart_id'
                
                                    $sql = "SELECT COUNT(*) AS count FROM contains WHERE cartId = '$cartId' AND itemId = '$value'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $count = $row['count'];
                                        if ($count == 0) {
                                            $sql = "INSERT INTO contains (cartId, itemId) VALUES (?, ?)";
                                            $stmt = $conn->prepare($sql);
                                            // Bind the parameter values
                                            $stmt->bind_param("si", $cartId, $value);

                                            // Execute the statement
                                            $stmt->execute();

                                            // Check if the insertion was successful
                                            if ($stmt->affected_rows > 0) {
                                                $sql = "SELECT * FROM shoppingcart WHERE cartId = '$cartId'";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $quantity = $row['quantity'] + 1;
                                                    $sql = "UPDATE shoppingcart SET quantity = $quantity WHERE cartId = '$cartId'";
                                                    if ($conn->query($sql) === TRUE) {
                                                        //echo "Quantity updated successfully.";
                                                    }
                                                }
                                            }
                                            $stmt->close();
                                        } else {
                                            $sql = "SELECT * FROM contains WHERE cartId = '$cartId' AND itemId = '$value'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $quantity = $row['quantity'] + 1;
                                                $sql = "UPDATE contains SET quantity = $quantity WHERE cartId = '$cartId' AND itemId = '$value'";
                                                if ($conn->query($sql) === TRUE) {
                                                    $sql = "SELECT * FROM shoppingcart WHERE cartId = '$cartId'";
                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        $quantity = $row['quantity'] + 1;
                                                        $sql = "UPDATE shoppingcart SET quantity = $quantity WHERE cartId = '$cartId'";
                                                        if ($conn->query($sql) === TRUE) {
                                                           // echo "Quantity updated successfully.";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        header('Location: desserts.php');
                    }
                } else {
                    if (isset($_GET["addTocart"])) {
                        header('Location: UserConnexion/formLoginRegister.php');
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