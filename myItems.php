<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<style>


        .content {
            display: flex;
            flex-wrap: wrap;
        }

        .column {
            flex: 33.33%;
            padding: 10px;
        }

        .item {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .item h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .item img {
            width:250px;
            height: 250px
            margin-bottom: 10px;
        }

        .item p {
            margin-bottom: 5px;
        }

        .item a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #007BFF;
        }

        .item a:hover {
            text-decoration: underline;
        }
    </style>
  <link rel="stylesheet" type="text/css" href="Constant/styles.css">
</head>
<body>
    <head>
        <?php 
        ob_start();
        include('Constant/head.php'); ?>
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
        $sql = "SELECT i.id,nameItem,descriptions,price,categories,sellType,quantity,endDate,idLink,link FROM items as i inner join have as h on i.id = h.idItem inner join picturesvideos as pv on h.idLink=pv.id  where i.id in (SELECT idItem from sell where username ='$username') ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { // !empty($result) && 
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="column">';
                echo '<div class="item">';
                echo '<h2>' . $row["nameItem"] . '</h2>';
                echo '<img src='.$row["link"].' alt="">';
                echo '<p>' . $row["descriptions"] . '</p>';
                echo '<p>£' . $row["price"] . '</p>';
                echo'<a href="myItems.php?editId='.$row['id'].'" >edit item </a>';
                echo'<a href="myItems.php?deleteId='.$row['id'].'" >delete item</a>';
                echo '</div>';
                echo '</div>';
            }
        }
        
        if(isset($_GET["editId"])){
          header("location:editItem.php?id=".$_GET["editId"]);
        }else if(isset($_GET["deleteId"])){
          $id = $_GET["deleteId"];
          $delete = mysqli_query($conn,"DELETE FROM items where id='$id'");
          header("location:myItems.php");
          exit;
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
