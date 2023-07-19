<?php 
ob_start();
session_start(); ?>
<!DOCTYPE html>
<html>
  <style>

  .content p {
    margin-bottom: 10px;
  }

  .content a {
    display: inline-block;
    margin-right: 10px;
    padding: 8px 16px;
    font-size: 14px;
    text-align: center;
    text-decoration: none;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }

  .content a:hover {
    background-color: #45a049;
  }

  .content a.change-role {
    background-color: #FF9900;
  }

  .content a.change-role:hover {
    background-color: #FFB84D;
  }

  .content a.delete {
    background-color: #f44336;
  }

  .content a.delete:hover {
    background-color: #d32f2f;
  }

  .content br {
    margin-bottom: 10px;
  }
  </style>
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
            if($row["roles"]==0){
              echo 'Role : Admin<br>';
              echo '<a href="seeProfil.php?username='.$user.'&newRole=1">Change role to seller</a><br>';
              echo '<a href="seeProfil.php?username='.$user.'&newRole=2">Change role to buyer</a>';
            }else if($row["roles"]==1){
              echo 'Role : Seller<br>';
              echo '<a href="seeProfil.php?username='.$user.'&newRole=0">Change role to admin</a><br>';
              echo '<a href="seeProfil.php?username='.$user.'&newRole=2">Change role to buyer</a>';
            }else{
              echo "Role : Buyer<br>";
              echo '<a href="seeProfil.php?username='.$user.'&newRole=0">Change role to admin</a><br>';
              echo '<a href="seeProfil.php?username='.$user.'&newRole=1">Change role to seller</a>';
            }
            if(isset($_GET["newRole"])){
              $newRole = $_GET["newRole"];
              $sql="UPDATE users SET roles ='$newRole' where username='$user'";
              $conn->query($sql);
              header('Location:seeProfil.php?username='.$user);
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
