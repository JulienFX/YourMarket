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
        require_once("connexionDB.php");
        global $conn;
        $himself = $_SESSION["username"];
        $sql = "SELECT username FROM users where username!='$himself'";
        $result = $conn->query($sql);
        if($result->num_rows>0){
            while ($row = $result->fetch_assoc()){
                echo $row["username"];
                echo ' <a href="seeProfil.php?username='.$row["username"].'">see his profil</a> ';
                echo '<a href="">delete him</a>';
                echo '<br>';
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
