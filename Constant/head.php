<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Website Title</title>
  <style>
    /* Add your custom styles here */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .header {
      background-color: #232f3e;
      /* Amazon's header color */
      padding: 1% 2%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: white;
    }

    .header a {
      text-decoration: none;
      color: white;
    }

    .header a:hover {
      text-decoration: none;
      color: #f0c14b; /* Change link color on hover to Amazon's yellow color */
    }

    .header img.logo {
      height: 70px;
      border-radius: 8px; /* Make the logo slightly rounded */
      margin-right: 20px; /* Add some space between logo and search bar */
    }

    .search-bar {
      display: flex;
      align-items: center;
      border: 1px solid white;
      border-radius: 4px;
      padding: 6px;
    }

    .search-bar input[type="text"] {
      border: none;
      background-color: transparent;
      color: white;
      padding: 6px;
      width: 300px;
      /* Make the search input wider */
    }

    .search-bar button {
      background-color: #f0c14b;
      /* Amazon's search button color */
      border: none;
      color: #111;
      padding: 8px 12px;
      cursor: pointer;
      border-radius: 0 4px 4px 0;
    }

    .profile-button {
      position: relative;
      display: inline-block;
    }

    .profile-dropdown {
      display: none;
      position: absolute;
      top: 100%;
      right: 0;
      min-width: 120px;
      background-color: #f9f9f9;
      padding: 8px;
      border: 1px solid #ccc;
      z-index: 1;
    }

    .profile-button:hover .profile-dropdown {
      display: block;
    }

    .header .cart-icon {
      display: inline-block;
      position: relative;
      margin-right: 100px; /* Add some space between cart icon and profile picture */
    }

    .header .cart-icon img {
      height: 30px;
      cursor: pointer;
    }
    /* Make the profile picture round */
    .profile-button img {
      height: 50px;
      width: 50px;
      border-radius: 50%;
      object-fit: cover;
    }

    /* Change color and underline behavior for links in profile-dropdown */
    .profile-dropdown a {
      color: black;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <header class="header">
    <a href="index.php"><img src="Photos/logo.png" class="logo"></a>
    <div class="search-bar">
      <input type="text" placeholder="Search..." />
      <button type="submit">Search</button>
    </div>
    <div>
      <a href="cart.php" class="cart-icon">
        <img src="Photos/shopping-cart.png" alt="Your Cart">
      </a>
      <?php
      if (isset($_SESSION['username'])) {
        ?>
        <div class="profile-button">
          <img src="Photos/pdp.png" alt="Photo de profil"> <!-- Replace with your profile picture URL -->
          <div class="profile-dropdown">
            <a href="profil.php">Profile</a>
            <br>
            <a href="disconnect.php">Logout</a><br>
            <a href="orders.php">Your Orders</a>
          </div>
        </div>
        <?php
      } else {
        echo '<a href="UserConnexion/formLoginRegister.php">Login</a>';
      } ?>
    </div>
  </header>

  <div class="content">
    <!-- Your content goes here -->
  </div>
</body>

</html>
