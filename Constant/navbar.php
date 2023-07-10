<!DOCTYPE html>
<html>
<div class="navbar">
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="desserts.php">Cakes</a></li>
    <li><a href="electronics.php">Electronics</a></li>
    <?php
    require_once('connexionDB.php');
    if(isset($_SESSION["role"]) && $_SESSION['role'] <=1 ){ // <= 1 means admin ou seller 
      ?>
      <li><a href="manageItems.php">Manage product</a></li>
      <?php
    }
    if(isset($_SESSION["role"]) && $_SESSION['role'] ==0 ){ // admin
      ?>
      <li><a href="administration.php">Administration</a></li>
      <?php
    }
    ?>
  </ul>
</div>
</html>
