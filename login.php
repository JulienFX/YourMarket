<!DOCTYPE html>
<html>
<head>
    <title>Page de Login</title>
    <script>
        function openRegistrationForm() {
            document.getElementById("registrationForm").style.display = "block";
        }
    </script>
</head>
<body>
    <h2>Connexion</h2>
    <form>
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
        <form>
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

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
