<?php session_start(); ?>
<!DOCTYPE html>
<html>
<style>
    /* Add styles for the content section */
    .content {
      text-align: center;
    }

    .content a {
      display: inline-block;
      margin: 10px;
      padding: 8px 16px;
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
        <h1>Manage Items</h1>
        <a href="addItem.php">add an item</a>
        <a href="myItems.php">see my items</a>
      </div>
    </div>
  <footer>
    <?php 
    include('Constant/footer.php'); 
    ?>
  </footer>
</body>
</html>
