<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<style>

    .content {
      text-align : center;
      /* margin: 20px; */
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    form {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    label {
      width: 100%;
      margin-bottom: 10px;
      font-weight: bold;
    }

    input[type="text"],
    textarea,
    select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 20px;
      font-size: 16px;
    }

    select {
      width: 100%;
      height: 40px;
    }

    #auctionsBlock {
      display: none;
    }

    input[type="number"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 20px;
      font-size: 16px;
    }

    input[type="file"] {
      margin-bottom: 20px;
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
  <link rel="stylesheet" type="text/css" href="Constant/styles.css">
</head>
<body>
    <?php
    require_once('connexionDB.php');
    global $conn;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $category = $_POST["category"];
        $sellType = $_POST["sellType"];
        $quantity = $_POST["quantity"];
        if(isset($_POST["auctionEndDate"])){
            $auctionEndDate = $_POST["auctionEndDate"];
        }else{
            $auctionEndDate= NULL;
        }
        $insertItemQuery = "INSERT INTO items (nameItem, descriptions, price, categories,sellType,quantity,endDate) VALUES ('$name', '$description', $price, '$category','$sellType','$quantity','$auctionEndDate')";
        if ($conn->query($insertItemQuery) === TRUE) {
            $lastInsertIdItem = $conn->insert_id; 
            $result = mysqli_query($conn, $lastInsertIdItem);
            $username = $_SESSION["username"];
            $insertSellQuery = "INSERT INTO sell (username, idItem) VALUES ('$username', '$lastInsertIdItem')";
        }
        if ($conn->query($insertSellQuery) === TRUE) {

            // Insérer les photos dans la table "pictures"
            if (isset($_FILES["photos"])) {
                $fileCount = count($_FILES["photos"]["name"]);
                for ($i = 0; $i < $fileCount; $i++) {
                    $photoName = $_FILES["photos"]["name"][$i];
                    $photoTmpName = $_FILES["photos"]["tmp_name"][$i];
                    $photoType = $_FILES["photos"]["type"][$i];
                    
                    // Vérifier le type de fichier
                    if (in_array($photoType, array("image/jpeg", "image/png"))) {
                        // Déplacer la photo téléchargée vers un répertoire de stockage
                        $uploadPath = "Photos/Items/" . $photoName;
                        move_uploaded_file($photoTmpName, $uploadPath);

                        // Insérer le chemin de la photo dans la table "pictures"
                        $insertPhotoQuery = "INSERT INTO picturesvideos (link) VALUES ('$uploadPath')";
                        if ($conn->query($insertPhotoQuery) === TRUE) {
                            $idLink = $conn->insert_id; 
                            $result = mysqli_query($conn, $idLink);
                
                            $insertHave = "INSERT INTO have (idLink, idItem) VALUES ('$idLink','$lastInsertIdItem')";
                            if($conn->query($insertHave)===TRUE){
                              echo "Item added successfully!";
                          }
                        }else{
                          echo "eror";
                        }

                    }
                }
            }

            
            
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
    <head>
        <?php include('Constant/head.php'); ?>
    </head>
    <div class="page">
      <nav>
          <?php include('Constant/navbar.php'); ?>
      </nav>
      
      <div class="content">
        <h2>Add a New Item</h2>

        <form method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea><br>

            <label for="sellType">Sell type :</label>
            <select name="sellType" id="sellType" onchange="toggleAuctionsBlock()" required>
                <option value="1" id="fixed">Fixed price & Offers</option>
                <option value="2" id="auctions">Auctions</option>
            </select><br>

            <div id="auctionsBlock" style="display: none;">
                <label for="auctionEndDate">Auction End Date:</label>
                <input type="datetime-local" name="auctionEndDate" id="auctionEndDate"><br>
            </div>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" required><br>

            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="1" id="cake">Cakes</option>
                <option value="2" id="electronic">Electronics</option>
            </select><br>
            
            <label for="quantity">Quantity :</label>
            <input type="number" name="quantity" id="quantity" required><br>

            <label for="photos">Photos:</label>
            <input type="file" name="photos[]" id="photos" multiple required><br>

            <input type="submit" value="Add">
        </form>
      </div>
    </div>
  <footer>
    <?php 
    include('Constant/footer.php'); 
    ?>
  </footer>

  <script>
    function toggleAuctionsBlock() {
      var sellType = document.getElementById("sellType");
      var auctionsBlock = document.getElementById("auctionsBlock");

      if (sellType.value === "2") {
        auctionsBlock.style.display = "block";
      } else {
        auctionsBlock.style.display = "none";
      }
    }
  </script>
</body>
</html>
