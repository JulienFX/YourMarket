<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="Constant/styles.css">
  <script>
        function afficherChampTexte() {
            var choix = document.getElementById("choix").value;
            var champPrixVente = document.getElementById("champ-prix-vente");
            var champPrixDepart = document.getElementById("champ-prix-depart");
            
            if (choix === "1") {
                champPrixVente.style.display = "block";
                champPrixDepart.style.display = "none";
            } else if (choix === "2") {
                champPrixVente.style.display = "none";
                champPrixDepart.style.display = "block";
            } else {
                champPrixVente.style.display = "none";
                champPrixDepart.style.display = "none";
            }
        }
    </script>
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
        $insertItemQuery = "INSERT INTO items (nameItem, descriptions, price, categories,sellType) VALUES ('$name', '$description', $price, '$category','$sellType')";
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
                        }

                    }
                }
            }

            if($conn->query($insertHave)===TRUE){
                echo "Item added successfully!";
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

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" required><br>

            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="1" id="cake">Cakes</option>
                <option value="2" id="electronic">Electronics</option>
            </select><br>
            <label for="sellType">Sell type : </label>
            <select id="choix" onchange="afficherChampTexte()">
                <option value="">Select an option</option>
                <option value="1">Bids & Offer</option>
                <option value="2">Auctions</option>
            </select>
            <br><br>
            <div id="champ-prix-vente" style="display: none;">
                <label for="prix-vente">Prix de vente :</label>
                <input type="text" id="prix-vente">
            </div>
            <div id="champ-prix-depart" style="display: none;">
                <label for="prix-depart">Prix de départ :</label>
                <input type="text" id="prix-depart">
            </div>

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
