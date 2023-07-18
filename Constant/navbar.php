<!DOCTYPE html>
<html>
<head>
  <style>
    /* GENERAL */
    body {
        margin: 0;
        padding: 0;
    }

    /* NAVBAR */
    nav {
        width: 10%;
        left: 0;
        flex-grow: 1;
    }

    .navbar {
        background-color: #232f3e; /* Amazon's header color */
        height: 100%;
        float: left;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .navbar ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .navbar li {
        margin: 10px 0;
    }

    .navbar a {
        display: flex;
        align-items: center;
        padding: 10px;
        text-decoration: none;
        color: white;
        transition: background-color 0.3s ease;
    }

    .navbar a:hover {
        background-color: #f0c14b; /* Change link color on hover to Amazon's yellow color */
    }

    /* Add icon style */
    .navbar i {
        margin-right: 8px;
    }

    /* PAGE */
    .page {
        border: 1px solid black;
        display: flex;
    }

    .content {
        text-align: center;
        width: 100%;
    }
  </style>
  <!-- Add Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <div class="navbar">
    <ul>
      <li><a href="index.php"><i class="fas fa-home"></i>Home</a></li>
      <li><a href="desserts.php"><i class="fas fa-birthday-cake"></i>Cakes</a></li>
      <li><a href="electronics.php"><i class="fas fa-laptop"></i>Electronics</a></li>
      <?php
      require_once('connexionDB.php');
      if(isset($_SESSION["role"]) && $_SESSION['role'] <= 1 ){ // <= 1 means admin or seller
        ?>
        <li><a href="manageItems.php"><i class="fas fa-cogs"></i>Manage product</a></li>
        <?php
      }
      if(isset($_SESSION['role'])){
        ?>
        <li><a href="negotiation.php"><i class="fas fa-handshake"></i>See negotiation</a></li>
        <?php
      }
      if(isset($_SESSION["role"]) && $_SESSION['role'] == 0 ){ // admin
        ?>
        <li><a href="administration.php"><i class="fas fa-users-cog"></i>Administration</a></li>
        <?php
      }
      ?>
    </ul>
  </div>
</body>
</html>
