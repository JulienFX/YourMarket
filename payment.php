<!DOCTYPE html>
<html>

<head>
  <title>Payment Page</title>
  <style>
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
    }

    .form {
      width: 50%;
    }

    .payment {
      width: 45%;
    }

    .form input,
    .payment input {
      width: 100%;
      margin-bottom: 10px;
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
    </div>
    <div class="payment">
      <h2>Payment Information</h2>
      <input type="text" name="cardNumber" placeholder="Card number">
      <input type="text" name="nameOnCard" placeholder="Name on card">
      <input type="text" name="expirationDate" placeholder="Expiration date">
      <input type="text" name="securityCode" placeholder="Security code">
      <button type="submit">Validate Payment</button>
      </form>
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
           // header('Location: desserts.php');
          }
        }
      } else if ($_SESSION['cartId']) {
        echo "cart";
        $sql = "SELECT * FROM possess JOIN contains ON possess.cartId = contains.cartId WHERE possess.username = '$username'";

        $result = $conn->query($sql);

        // Display the cart items
        if ($result->num_rows > 0) {
          echo $result->num_rows;
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