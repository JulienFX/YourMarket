<?php
session_start();
function newUser($firstName, $name, $username, $email, $phone, $password) {
    $servername = "localhost"; // adress server mysql
    $usernameServer = "root"; // username mysql
    $passwordServer = ""; // passsword mysql
    $dbname = "yourmarket"; // db name

    try {
        // creation of a PDO 
        $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $usernameServer, $passwordServer);

        // Configuration error mode 
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare query : security
        $query = "INSERT INTO users (firstName, name, username, email, phone, passwd)
                  VALUES (:firstName, :name, :username, :email, :phone, :password)";
        $stmt = $connexion->prepare($query);

        // link values and params
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $password);

        // execute query
        $stmt->execute();
        $_SESSION['username'] = $username;
        // Redirection 
        header('Location: index.php');
    } catch(PDOException $e) {
        // En cas d'erreur, afficher le message d'erreur
        echo "Erreur d'inscription: " . $e->getMessage();
    }
}

function login($username, $password){
    $servername = "localhost"; // adress server mysql
    $usernameServer = "root"; // username mysql
    $passwordServer = ""; // passsword mysql
    $dbname = "yourmarket"; // db name

    try {
        // creation of a pdo connexion with DB
        $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $usernameServer, $passwordServer);

        // configuration error mode 
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare query : security 
        $query = "SELECT username, passwd FROM users where username=? and passwd=?";
        $stmt = $connexion->prepare($query);

        // put inside an array value 
        $array = array($username,$password);

        // execute query
        $stmt->execute($array);
        $_SESSION['username'] = $username;
        // Redirection 
        header('Location: index.php');
    } catch(PDOException $e) {
        // En cas d'erreur, afficher le message d'erreur
        echo "Faux MDP " . $e->getMessage();
    }
}

?>
