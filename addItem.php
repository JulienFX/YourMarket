<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
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
        $insertItemQuery = "INSERT INTO items (nameItem, descriptions, price, categories) VALUES ('$name', '$description', $price, '$category')";
        $lastInsert = "SELECT MAX(id) from items"; // last item insert
        $result = mysqli_query($conn, $lastInsert);
        $row = $result->fetch_assoc();
        // print_r($row);
        $idItem = $row['MAX(id)'];
        $username = $_SESSION["username"];

        $insertSellQuery = "INSERT INTO sell (username, idItem) VALUES ('$username', '$idItem')";
        if ($conn->query($insertItemQuery) === TRUE && $conn->query($insertSellQuery) === TRUE) {
            $itemId = $conn->insert_id;

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
                        $conn->query($insertPhotoQuery);
                        $lastInsert = "SELECT MAX(id) FROM picturesvideos";
                        $res = mysqli_query($conn,$lastInsert);
                        $row = $res->fetch_assoc();
                        $idLink = $row['MAX(id)'];
                        $insertHave = "INSERT INTO have (idLink, idItem) VALUES ('$idLink','$idItem')";
                        $conn->query($insertHave);

                    }
                }
            }

            echo "Item added successfully!";
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

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" required><br>

            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="1" id="cake">Cakes</option>
                <option value="2" id="electronic">Electronics</option>
            </select><br>

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
</body>
</html>
