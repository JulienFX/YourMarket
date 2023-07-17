<!DOCTYPE html>
<html>

<head>
  <title>Payment Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .navbar {
      background-color: #333;
      color: #fff;
      padding: 10px;
      text-align: center;
    }

    .navbar h1 {
      margin: 0;
    }

    .container {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin: 20px;
    }

    .form {
      width: 45%;
      background-color: #f2f2f2;
      padding: 20px;
      border-radius: 5px;
    }

    .form h2 {
      margin-top: 0;
    }

    .form input {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .payment {
      width: 45%;
      background-color: #f2f2f2;
      padding: 20px;
      border-radius: 5px;
    }

    .payment h2 {
      margin-top: 0;
    }

    .payment input {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .payment .flex-container {
      display: flex;
      justify-content: space-between;
    }

    .payment .flex-container div {
      width: 48%;
    }

    .payment button {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      text-align: center;
      cursor: pointer;
      border-radius: 4px;
      margin-top: 10px;
    }

    .payment .icons {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 10px;
    }

    .payment .icons img {
      height: 30px;
      margin: 0 5px;
    }
  </style>
</head>

<body>
  <div class="navbar">
    <h1>YourMarket</h1>
  </div>
  <div class="container">
    <div class="form">
      <h2>Customer Information</h2>
      <form id="customerForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="namea" placeholder="Name">
        <input type="text" name="surname" placeholder="Surname">
        <input type="text" name="address1" placeholder="Address Line 1">
        <input type="text" name="address2" placeholder="Address Line 2">
        <input type="text" name="city" placeholder="City">
        <input type="text" name="postalCode" placeholder="Postal code">
        <input type="text" name="country" placeholder="Country">
        <input type="tel" name="phone" placeholder="Telephone number">
      </form>
    </div>
    <div class="payment">
      <h2>Payment Information</h2>
      <form id="paymentForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="nameOnCard" placeholder="Name on Card">
        <input type="text" name="cardNumber" placeholder="Card Number">
        <div class="flex-container">
          <div>
            <input type="text" name="expirationDate" placeholder="Expiration Date">
          </div>
          <div>
            <input type="text" name="securityCode" placeholder="Security Code">
          </div>
        </div>
        <button type="submit">SUBMIT PAYMENT</button>
      </form>
      <div class="icons">
        <img src="Photos/visa_icon.png" alt="Visa">
        <img src="Photos/paypal_icon.png" alt="PayPal">
        <img src="Photos/mastercard_icon.png" alt="Mastercard">
      </div>
    </div>
  </div>
  <?php
     session_start();
     require_once('connexionDB.php');
     global $conn;
     if (isset($_GET["buy"])) {
       $itemId = $_GET["buy"];
       $_SESSION['itemId'] = $itemId;
       unset( $_SESSION['cartId']);
     } else if (isset($_GET["cartId"])) {
       $cartId = $_GET["cartId"];
       $_SESSION['cartId'] = $cartId;
       unset( $_SESSION['itemId']);
     }
     if (isset($_SESSION['username'])) {
       if ($_SERVER["REQUEST_METHOD"] === "POST") {
         $username = $_SESSION['username'];
         if (isset($_SESSION['itemId'])) {
           echo "buy";
           $itemId = $_SESSION['itemId'];
    
           $sql = "INSERT INTO orders (quantity, itemId) VALUES (?, ?)";
           $stmt = $conn->prepare($sql);
    
           $stmt->bind_param("si", $quantity, $itemId);
    
           $quantity = 1;
    
           if ($stmt->execute()) {
             $sql = "SELECT orderId FROM  orders ORDER BY orderId DESC LIMIT 1";
             $result = $conn->query($sql);
    
             if ($result->num_rows > 0) {
               $row = $result->fetch_assoc();
               $orderId = $row['orderId'];
               $sql = "INSERT INTO hold (orderId, username) VALUES (?, ?)";
               $stmt = $conn->prepare($sql);
               // Bind the parameter values
               $stmt->bind_param("is", $orderId, $username);
    
               // Execute the statement
               $stmt->execute();
               $sql = "SELECT quantity FROM items WHERE id = ?";
               $stmt = $conn->prepare($sql);
               $stmt->bind_param("i", $itemId);
               $stmt->execute();
               $stmt->bind_result($currentQuantity);
               $stmt->fetch();
               $stmt->close();
    
               $newQuantity = $currentQuantity - 1;
               if ($newQuantity < 0) {
                 $newQuantity = 0;
               }
               $sql = "UPDATE items SET quantity = ? WHERE id = ?";
               $stmt = $conn->prepare($sql);
               $stmt->bind_param("ii", $newQuantity, $itemId);
               $stmt->execute();
               $stmt->close();
               header('Location: desserts.php');
             }
           }
         } else if ($_SESSION['cartId']) {
           $sql = "SELECT * FROM possess JOIN contains ON possess.cartId = contains.cartId WHERE possess.username = '$username'";
    
           $result = $conn->query($sql);
    
           // Display the cart items
           if ($result->num_rows > 0) {
             while ($row = $result->fetch_assoc()) {
               $quantity = $row["quantity"];
               $cartId = $row["cartId"];
               $itemId = $row["itemId"];
               
               $sql = "INSERT INTO orders (quantity, itemId) VALUES (?, ?)";
               $stmt = $conn->prepare($sql);
    
               $stmt->bind_param("si", $quantity, $itemId);
    
               if ($stmt->execute()) {
                 $sql = "SELECT orderId FROM  orders ORDER BY orderId DESC LIMIT 1";
                 $res = $conn->query($sql);
    
                 if ($result->num_rows > 0) {
                   $r = $res->fetch_assoc();
                   $orderId = $r['orderId'];
                   $sql = "INSERT INTO hold (orderId, username) VALUES (?, ?)";
                   $stmt = $conn->prepare($sql);
                   // Bind the parameter values
                   $stmt->bind_param("is", $orderId, $username);
    
                   // Execute the statement
                   $stmt->execute();
                   $sql = "SELECT quantity FROM items WHERE id = ?";
                   $stmt = $conn->prepare($sql);
                   $stmt->bind_param("i", $itemId);
                   $stmt->execute();
                   $stmt->bind_result($currentQuantity);
                   $stmt->fetch();
                   $stmt->close();
    
                   $newQuantity = $currentQuantity - $quantity;
                   if ($newQuantity < 0) {
                     $newQuantity = 0;
                   }
                   $sql = "UPDATE items SET quantity = ? WHERE id = ?";
                   $stmt = $conn->prepare($sql);
                   $stmt->bind_param("ii", $newQuantity, $itemId);
                   $stmt->execute();
                   $stmt->close();
                   $sql = "DELETE FROM contains WHERE cartId = '$cartId'";
    
                   $conn->query($sql);
                 }
               }
             }   
           }
           header('Location: desserts.php');
         }
       }
     } else {
       header('Location: UserConnexion/formLoginRegister.php');
     }
  ?>
</body>

</html>
