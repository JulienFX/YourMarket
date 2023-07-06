<?php
session_start();
require_once('../connexionDB.php');

function newUser($firstName, $name, $username, $email, $phone, $password, $role) {
    global $conn; // access to $conn in connexionDB.php
    try {
        // prepare query : security
        $query = "INSERT INTO users (firstName, familyName, username, email, phone, passwd, roles)
          VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = mysqli_prepare($conn, $query);

        if ($statement) {
            // sssssssi => s : string, i : integer ... type of content 
            mysqli_stmt_bind_param($statement, "ssssssi",$firstName, $name, $username, $email, $phone, $password, $role);
        
            if (mysqli_stmt_execute($statement)) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                header('Location: ../index.php');
            } else {
                echo "Erreur lors de l'exécution de la requête : " . mysqli_error($conn);
            }
            mysqli_stmt_close($statement);
        } else {
            echo "Erreur lors de la préparation de la requête : " . mysqli_error($conn);
        }
    } catch(PDOException $e) {
        // En cas d'erreur, afficher le message d'erreur
        echo "Erreur d'inscription: " . $e->getMessage();
    }
}

function login($username, $password){
    global $conn;
    try {
        // prepare query : security 
        $query = "SELECT count(*) FROM users where username='$username' and passwd='$password'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row_count = mysqli_num_rows($result);
        
            if ($row_count > 0) {
                $_SESSION['username'] = $username;
                $q = "SELECT roles FROM users where username='$username'";
                $res = mysqli_query($conn, $q);
                $row = $res->fetch_assoc();
                $_SESSION['role'] = $row['roles'];
                header('Location: ../index.php');
            } else {
                echo "Il n'y a pas de résultat.";
            }
            mysqli_free_result($result);
        } else {
            echo "Erreur lors de l'exécution de la requête : " . mysqli_error($conn);
        }
    } catch(PDOException $e) {
        // En cas d'erreur, afficher le message d'erreur
        echo "Faux MDP " . $e->getMessage();
    }
}

?>