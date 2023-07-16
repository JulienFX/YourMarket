<!DOCTYPE html>
<html>
<head>
  <style>
    .header {
      background-color: gray;
      padding: 1%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: white;
    }
    .profile-button {
        position: relative;
        display: inline-block;
    }
    
    .profile-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 120px;
        background-color: #f9f9f9;
        padding: 8px;
        border: 1px solid #ccc;
        z-index: 1;
    }
    
    .profile-button:hover .profile-dropdown {
        display: block;
    }
  </style>
</head>
  <header class="header">
    <div class="header-title">YourMarket</div>
    <div class="search-bar">
      <!-- Insérez ici le code de votre barre de recherche -->
      <input type="text" placeholder="Search..." />
      <button type="submit">Search</button>
    </div>
    <div>
      <a href="cart.php">Your cart</a>
      <?php 
      if(isset($_SESSION['username'])){
        ?>
        <div class="profile-button">
        <img src="Photos/pdp.png" height="50px" alt="Photo de profil">
        <div class="profile-dropdown">
            <a href="profil.php">Profil</a>
            <br>
            <a href="disconnect.php">Logout</a><br>
            <a href="orders.php">Your Orders</a>
        </div>
      </div>
      <?php
      }else{
        echo '<a href="UserConnexion/formLoginRegister.php">Login</a>';
      } ?>
      
    </div>
  </header>

  <div class="content">
    <!-- Votre contenu ici -->
  </div>
</html>
