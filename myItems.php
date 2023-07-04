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
        require_once('connexionDB.php');
        global $conn;
        // Fetch items from the table
        $username = $_SESSION["username"];
        $sql = "SELECT i.id,nameItem,descriptions,price,categories,available,sellType,idLink,link FROM items as i natural join have as h inner join picturesvideos as pv on h.idLink=pv.id where i.id in (SELECT idItem from sell where username ='$username')  group by i.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="column">';
                echo '<div class="item">';
                echo '<h2>' . $row["nameItem"] . '</h2>';
                echo '<img src='.$row["link"].' alt="">';
                echo '<p>' . $row["descriptions"] . '</p>';
                echo '<p>£' . $row["price"] . '</p>';
                echo '<button>edit item</button>';
                echo '<button>delete item</button>';
                echo '</div>';
                echo '</div>';
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
