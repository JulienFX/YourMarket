<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <style>
    /* Add styles for the content and buttons */


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
        <h1>Users</h1>
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
                echo '<a href="findUser.php?deleteUsername='.$row["username"].'">delete him</a>';
                echo '<br>';
            }
        }
        if(isset($_GET["deleteUsername"])){
            $userToDelete = $_GET["deleteUsername"];
            $query = "DELETE FROM users where username ='$userToDelete'";
            if($conn->query($query)===true){
                header("Location:findUser.php");
            }else{
                echo "non";
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
