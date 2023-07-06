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
                $servername = "localhost"; // adress server mysql
                $usernameServer = "root"; // username mysql
                $passwordServer = ""; // passsword mysql
                $dbname = "yourmarket"; // db name
                
                // Create a new connection
                $conn = new mysqli($servername, $usernameServer, $passwordServer, $dbname);

                // Check the connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                // Fetch items from the table
                $sql = "SELECT * FROM items";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="column">';
                        echo '<div class="item">';
                        echo '<h2>' . $row["nameItem"] . '</h2>';
                        echo '<img src="Photos/xbox.png" alt="">';
                        echo '<p>' . $row["descriptions"] . '</p>';
                        echo '<p>£' . $row["price"] . '</p>';
                        echo '<button class="add-to-cart">Add to Cart</button><br><br>';
                        echo '<button onclick="openPayment();">Buy Now</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                // Close the database connection
                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <script>
    function openPayment() {
      window.open("payment.php", "_blank");
    }
  </script>
</body>

</html>