<?php session_start(); 
require_once("connnexionDB.php");
global $conn;
$user = $_SESSION['username'];
$idItem = $_GET["editId"];
$sql = "SELECT * from items where id='$idItem'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row["id"];
    $nameItem = $row["nameItem"];
    $descriptions = $row["descriptions"];
    $price = $row["price"];
    $categories = $row["categories"];
    $available = $row["available"];
    $sellType = $row["selltype"];
} else {
    echo "this ID doesn't exist";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    // $id = $_POST['id'];
    $nameItem = $_POST['nameItem'];
    $descriptions = $_POST['descriptions'];
    $price =$_POST['price'];
    $categories = $_POST['categories'];
    $available = $_POST['available'];
    $sellType = $_POST["sellType"];

    $sql = "UPDATE items SET  nameItem='$nameItem', descriptions = '$descriptions', price ='$price', categories ='$categories' , available = '$available', sellType = '$sellType'";
    // TO CONTINUE 
}
?>
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
      </div>
    </div>
  <footer>
    <?php 
    include('Constant/footer.php'); 
    ?>
  </footer>
</body>
</html>
