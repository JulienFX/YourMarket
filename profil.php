<!DOCTYPE html>
<html>

<head>
  <title>Profile Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f1f1f1;
    }

    .page {
      max-width: 500px;
      margin: 20px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .page h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    .form-group .name-group {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .form-group .name-group input {
      width: calc(50% - 5px);
    }

    .form-group button {
      display: block;
      width: 120px;
      padding: 10px;
      background-color: #4caf50;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      margin-left: 0;
    }

    .form-group button:hover {
      background-color: #45a049;
    }
  </style>
</head>

<body>
  <?php
  $servername = "localhost"; // adresse du serveur MySQL
  $usernameServer = "root"; // nom d'utilisateur MySQL
  $passwordServer = ""; // mot de passe MySQL
  $dbname = "yourmarket"; // nom de la base de données
  
  // Créer une nouvelle connexion
  $conn = new mysqli($servername, $usernameServer, $passwordServer, $dbname);

  // Vérifier la connexion
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Récupérer les données de profil de l'utilisateur depuis la base de données
  session_start();
  $user = $_SESSION['username']; // Supposons que vous ayez un identifiant utilisateur pour identifier l'utilisateur
  $sql = "SELECT * FROM users WHERE username = '$user'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row["firstName"];
    $name = $row["familyName"];
    $username = $row["username"];
    $email = $row["email"];
    $phoneNumber = $row["phone"];
    $passwd = $row["passwd"];
  } else {
    echo "No user found with the provided ID.";
  }

  $conn->close();
  ?>
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $firstname = $_POST['firstName'];
    $name = $_POST['lastName'];
    $username = $_POST['username'];
    $phoneNumber = $_POST['phone'];
    $passwd = $_POST['password'];

    $servername = "localhost"; // adresse du serveur MySQL
    $usernameServer = "root"; // nom d'utilisateur MySQL
    $passwordServer = ""; // mot de passe MySQL
    $dbname = "yourmarket"; // nom de la base de données
  
    // Créer une nouvelle connexion
    $conn = new mysqli($servername, $usernameServer, $passwordServer, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Construire la requête de mise à jour
    $sql = "UPDATE users SET email='$email', firstname='$firstname', familyName='$name', username ='$username', phone ='$phoneNumber' , passwd = '$passwd' WHERE username='$user'";

    // Exécuter la requête de mise à jour
    if ($conn->query($sql) === TRUE) {
      // echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    $_SESSION['username'] = $username;
    // Fermer la connexion à la base de données
    $conn->close();
    header('Location: profil.php');
  }
  ?>

  <head>
    <?php include('Constant/head.php'); ?>
  </head>

  <div class="page">
    <h1>Account Information</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
      </div>

      <div class="form-group name-group">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo $name; ?>" required>
      </div>

      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
      </div>

      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $phoneNumber; ?>" required>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="text" id="password" name="password" value="<?php echo $passwd; ?>" required>
      </div>

      <div class="form-group">
        <button type="submit">Save Changes</button>
      </div>
    </form>
  </div>
  <footer>
    <?php
    include('Constant/footer.php');
    ?>
  </footer>

</body>

</html>