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
        $user = $_GET["username"];
        $sql = "SELECT * FROM users where username='".$user."'";
        $result = $conn->query($sql);
        if($result->num_rows>0){
            $row = $result->fetch_assoc();
            echo "username : ". $row["username"]."<br>";
            echo "First name : ".$row["firstName"]."<br>";
            echo "Family Name : ".$row["familyName"]."<br>";
            echo "Email : ".$row["email"]."<br>";
            echo "Phone : ".$row["phone"]."<br>";
            
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
