<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona Logowania</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST["login"];
        $haslo = $_POST["haslo"];
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "project_1";

        $conn = mysqli_connect($servername, $username, $password, $database);

        if (!$conn) {
            die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM user_login WHERE login = '$login' AND haslo = '$haslo'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $position = $row['Position'];
            session_start();
            $_SESSION["login"] = $login;
            $_SESSION["position"] = $position;
            setcookie("login", $login, time() + 3600, "/");
            setcookie("position", $position, time() + 3600, "/");

            header("Location: index.php");
            exit();
        } else {
            echo "Błąd logowania. Spróbuj ponownie.";
        }
        mysqli_close($conn);
    }
    ?>
    <div class="container">
        <div class="login-box">
            <h1>Logowanie</h1>
            <form action="login.php" method="post">
                <div class="input-group">
                    <label for="login">Nazwa użytkownika:</label>
                    <input type="text" id="login" name="login" required>
                </div>
                <div class="input-group">
                    <label for="haslo">Hasło:</label>
                    <input type="password" id="haslo" name="haslo" required>
                </div>
                <div class="input-group">
                    <input type="submit" value="Zaloguj się">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
