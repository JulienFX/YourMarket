<!DOCTYPE html>
<html>
<head>
    <title>Login page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        h2 {
            margin-top: 30px;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) inset;
        }

        button[type="submit"],
        button[type="button"] {
            width: 100%;
            padding: 10px 20px;
            margin-top: 15px;
            background-color: #FF9900;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        button[type="submit"]:hover,
        button[type="button"]:hover {
            background-color: #FFB84D;
        }

        button[type="submit"]:focus,
        button[type="button"]:focus {
            outline: none;
        }

        a {
            display: block;
            margin-top: 20px;
            color: #0066c0;
            text-decoration: none;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function openRegistrationForm() {
            document.getElementById("registrationForm").style.display = "block";
        }
    </script>
</head>

<body>
    <?php
    require_once "checkLoginRegister.php";

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Récupérer les valeurs du formulaire
        if (isset($_POST["newUsername"])) { // enregistrement
            $firstName = $_POST["firstName"];
            $name = $_POST["name"];
            $username = $_POST["newUsername"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $password = $_POST["newPassword"];
            $role = $_POST["role"];
            // Appeler la fonction pour inscrire l'utilisateur
            newUser($firstName, $name, $username, $email, $phone, $password, $role);
        }else{ // login
            $username = $_POST["username"];
            $password = $_POST["password"];
            login($username, $password);
        }

    }
    ?>
    <h2>Connexion</h2>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Connect</button>
    </form>

    <br>

    <button onclick="openRegistrationForm()">Inscription</button>

    <div id="registrationForm" style="display: none;">
        <h2>Inscription</h2>
        <form method="POST">
            <label for="firstName">Firt name:</label>
            <input type="text" id="firstName" name="firstName" required><br>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="newUsername">Username:</label>
            <input type="text" id="newUsername" name="newUsername" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required><br>

            <label for="newPassword">Password:</label>
            <input type="password" id="newPassword" name="newPassword" required><br>

            <label for="need">I wish to :</label>
            <select name="role">
                <option value="1" id="buySell">Buy and sell</option>
                <option value="2" id="buy">Only buy</option>
            </select>
            <br> <br>
            <button type="submit">Register</button>
        </form>
    </div>
    <br>
    <a href="../index.php">return home</a>

</body>

</html>