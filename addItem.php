<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="Constant/styles.css">
</head>
<body>
    <head>
        <?php include('Constant/head.php'); ?>
    </head>
    <div class="page">
      <nav>
          <?php include('Constant/navbar.php'); ?>
      </nav>
      <div class="content">
        <h2>Add a New Item</h2>

        <form method="POST" action="add_item.php" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea><br>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" required><br>

            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="cakes">Cakes</option>
                <option value="electronics">Electronics</option>
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
