<!DOCTYPE html>
<html>
<head>
  <title>Profile Management</title>
  <style>
    .container {
  width: 400px;
  margin: 0 auto;
  padding: 20px;
}

h1 {
  text-align: center;
}

label {
  display: block;
  margin-top: 10px;
}

input {
  width: 100%;
  padding: 5px;
  margin-top: 5px;
}

button {
  margin-top: 10px;
  padding: 10px;
  width: 100%;
  background-color: #4CAF50;
  color: white;
  border: none;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}
</style>
</head>
<body>
<head>
<?php
$servername = "localhost"; // adress server mysql
$usernameServer = "root"; // username mysql
$passwordServer = ""; // passsword mysql
$dbname = "yourmarket"; // db name

    // Create a new connection
$conn = new mysqli($servername, $usernameServer, $passwordServer, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the user's profile data from the database
session_start();
$user = $_SESSION['username']; // Assuming you have a user ID to identify the user
$sql = "SELECT firstName, username, email, phone ,passwd FROM users WHERE username = '$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row["firstName"];
    //$name = $row["name"];
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
    // Retrieve form data
    $firstname = $_POST['firstName'];
    $name = $_POST['lastName'];
    $email = $_POST['email'];
    $username =$_POST['username'];
    $phoneNumber = $_POST['phone'];
    $passwd = $_POST['password'];

    $servername = "localhost"; // adress server mysql
    $usernameServer = "root"; // username mysql
    $passwordServer = ""; // passsword mysql
    $dbname = "yourmarket"; // db name

    // Create a new connection
    $conn = new mysqli($servername, $usernameServer, $passwordServer, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Construct update query
    $sql = "UPDATE users SET firstname='$firstname', email = '$email', username ='$username', phone ='$phoneNumber' , passwd = '$passwd' WHERE username='$user'";

    // Execute update query
    if ($conn->query($sql) === TRUE) {
     // echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    $_SESSION['username'] = $username;
    // Close the database connection
    // $conn->close();
    header('Location: profil.php');
  }
 ?>
  <div class="container">
    <h1>Profile Management</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <label for="firstName">First Name:</label>
      <input type="text" id="firstName" name="firstName"  value="<?php echo $firstName; ?>"required>

      <label for="lastName">Last Name:</label>
      <input type="text" id="lastName" name="lastName" value="<?php echo $firstName; ?>" required>

      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

      <label for="password">Password:</label>
      <input type="text" id="password" name="password" value="<?php echo $passwd; ?>" required>

      <label for="phone">Phone Number:</label>
      <input type="tel" id="phone" name="phone" value="<?php echo $phoneNumber; ?>" required>

      <button type="submit">Save Changes</button>
    </form>
  </div>
</body>
</html>