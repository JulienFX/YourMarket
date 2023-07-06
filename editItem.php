<?php session_start(); 
require_once("connexionDB.php");
global $conn;
$user = $_SESSION['username'];
$idItem = $_GET["id"];
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
    $sellType = $row["sellType"];
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
    if ($conn->query($sql) === TRUE) {
      // echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    header('Location: myItems.php');
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
      <h1>Item management</h1>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <label for="nameItem">Name:</label>
        <input type="text" id="nameItem" name="nameItem" value="<?php echo $nameItem; ?>" required><br>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo $descriptions; ?>" required> <br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo $price; ?>" required><br>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo $categories; ?>" required><br>

        <label for="availablr">Available:</label>
        <input type="text" id="available" name="available" value="<?php echo $available; ?>" required><br>

        <label for="sellType">Sell Type:</label>
        <input type="text" id="sellType" name="sellType" value="<?php echo $sellType; ?>" required><br>

        <button type="submit">Save Changes</button>
      </form>
      </div>
    </div>
  <footer>
    <?php 
    include('Constant/footer.php'); 
    ?>
  </footer>
</body>
</html>
