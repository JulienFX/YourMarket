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
      <a href="">Your cart</a>
      <?php 
      if(isset($_SESSION['username'])){
        echo '<a href="disconnect.php">Manage account</a>';
      }else{
        echo '<a href="login.php">Login</a>';
      } ?>
      
    </div>
  </header>

  <div class="content">
    <!-- Votre contenu ici -->
  </div>
</html>
