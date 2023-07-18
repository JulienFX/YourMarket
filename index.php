<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
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
        <!-- Add the video element with a loop attribute -->
        <video id="background-video" autoplay loop muted style="width: 100%; height: 100%;">
          <source src="Photos/45711041.mp4" type="video/mp4">
        </video>
      </div>
    </div>
  <footer>
    <?php include('Constant/footer.php'); ?>
  </footer>
</body>
</html>
