<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <style>
    .content a {
  display: inline-block;
  margin: 10px;
  padding: 12px 20px;
  font-size: 16px;
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

/* Center the content */
.content {
  text-align: center;
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
        <h1>Administration</h1>
        <a href="findUser.php">Find users</a>
        <a href="findItems.php">Find items</a>
        <a href="auctionVerified.php">Find auctions</a>
      </div>
    </div>
  <footer>
    <?php 
    include('Constant/footer.php'); 
    ?>
  </footer>
</body>
</html>
