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
    
    .form input {
      width: 100%;
      margin-bottom: 10px;
    }
    
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
      <form id="customerForm">
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="surname" placeholder="Surname" required>
        <input type="text" name="address1" placeholder="Address Line 1" required>
        <input type="text" name="address2" placeholder="Address Line 2">
        <input type="text" name="city" placeholder="City" required>
        <input type="text" name="postalCode" placeholder="Postal code" required>
        <input type="text" name="country" placeholder="Country" required>
        <input type="tel" name="phone" placeholder="Telephone number" required>
      </form>
    </div>
    <div class="payment">
      <h2>Payment Information</h2>
      <form id="paymentForm">
        <input type="text" name="cardNumber" placeholder="Card number" required>
        <input type="text" name="nameOnCard" placeholder="Name on card" required>
        <input type="text" name="expirationDate" placeholder="Expiration date" required>
        <input type="text" name="securityCode" placeholder="Security code" required>
      </form>
      <button onclick="validateForm()">Validate Payment</button>
    </div>
  </div>
  
  <script>
    function validateForm() {
      var customerForm = document.getElementById("customerForm");
      var paymentForm = document.getElementById("paymentForm");
      
      if (customerForm.checkValidity() && paymentForm.checkValidity()) {
        alert("Payment validated!");
        // Add your code here to submit the form or perform further actions
      } else {
        alert("Please fill in all required fields.");
      }
    }
  </script>
</body>
</html>