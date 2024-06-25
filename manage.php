<?php
include 'session.php';
error_reporting(0);
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "project_1";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn){
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}

// Dodawanie Pracowników 
if ($_SERVER["REQUEST_METHOD"] == "POST"){ 
    $addlogin = $_POST['log'];
    $addpassword = $_POST['haslo'];
    $addname = $_POST['name'];
    $addsurname = $_POST['surname'];
    $addposition = $_POST['Stanowisko'] ?? '';


    

    if (!empty($addlogin) && !empty($addpassword) && !empty($addname) && !empty($addsurname) && !empty($addposition)) {
        $addlogin = mysqli_real_escape_string($conn, $addlogin);
        $addpassword = mysqli_real_escape_string($conn, $addpassword);
        $addname = mysqli_real_escape_string($conn, $addname);
        $addsurname = mysqli_real_escape_string($conn, $addsurname);
        $addposition = mysqli_real_escape_string($conn, $addposition);

        $send = "INSERT INTO `user_login`(`login`, `haslo`, `Position`) VALUES ('$addlogin', '$addpassword', '$addposition')";
        if (mysqli_query($conn, $send)) {
            $send2 = "INSERT INTO `pracownicy`(`Name`, `Surname`, `Position`,`login`) VALUES ('$addname', '$addsurname', '$addposition', '$addlogin')";
            mysqli_query($conn, $send2);
            header("Location: " .$_SERVER["PHP_SELF"]);
        } 
    }
    
}
                //Zarządzanie pracownikami          
            $sending = '';
            $query = "SELECT `login`, `Position`,`haslo` FROM `user_login`";
            $query_result = mysqli_query($conn, $query);
            if (mysqli_num_rows($query_result) > 0) {
                while ($row = mysqli_fetch_assoc($query_result)){
                    $login = $row['login'];
                    $PositionMain = $row['Position'];
                    $haslo = $row['haslo'];
            
                    $sending .= '<form method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                    $sending .= '<tr><th>Login Użytkownika: ' . $login . '</th><th>'
                        . $PositionMain . '<select name="Stanowisko1" style="float:right;">
                        <option value="Pracownik">Pracownik</option>
                        <option value="Księgowa">Księgowa</option>
                        <option value="Grafik">Grafik</option>
                        <option value="Menadżer">Menadżer</option></select>
                        <input type="hidden" name="login" value="' . $login . '">
                        <input type="submit" name="update-position" style="float:right";></th>
                        <th>'
                         . $haslo . '
                         <input type="submit" name="update_password"style="float:right;"
                         ><input type="text" class="cycek" name="change_password" style="float:right;"></th>
                         <th><input type="hidden" name="connect_login" value="' . $login . '">
                         <input type="submit" name="delete_user" value="usuń">
                         </th></tr><br>';
                    $sending .= '</form>';
                }


            }else{
                echo "Brak użytkowników w bazie danych";;
            }

            //Zmiana stanowiska
            if ($_SERVER["REQUEST_METHOD"]== "POST"){
                if(isset($_POST['update-position'])){
                if(isset($_POST['Stanowisko1']) && isset($_POST['login'])){

                $Position1 = $_POST['Stanowisko1'];
                $login = $_POST['login'];
                if(!empty($Position1) && !empty($login)){
                    $updateQuery = "UPDATE `user_login` SET `Position` = '$Position1' WHERE `login` = '$login'";
                    mysqli_query($conn,$updateQuery);
                    header("Location: " .$_SERVER["PHP_SELF"]);
                }
            }
            }
            }
            //Usuwanie użytkowników
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
                $loginToDelete = $_POST['connect_login'];
                $deleteQuery = "DELETE user_login, pracownicy FROM user_login JOIN pracownicy ON user_login.login = pracownicy.login WHERE user_login.login = '$loginToDelete'";
                if (mysqli_query($conn, $deleteQuery)) {
                    echo "Pomyślnie usunięto użytkownika o loginie " . $loginToDelete . "<br>";
                    header("Location: " .$_SERVER["PHP_SELF"]);
                } else {
                    echo "Błąd usuwania użytkownika " . mysqli_error($conn) . "<br>";
                }
                
            }
            
            
            //Zmiana hasła
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                if(isset($_POST['update_password'])){
                    if(isset($_POST['change_password']) && isset($_POST['login'])){
                        $haslo1 = $_POST['change_password'];
                        $login = $_POST['login'];
                                if(!empty($haslo1) && !empty($login)){
                                    $updatePasswordQuery = "UPDATE `user_login` SET `haslo` = '$haslo1' WHERE `login` = '$login'";
                                    mysqli_query($conn, $updatePasswordQuery);
                                    header("Location: " .$_SERVER["PHP_SELF"]);
                        }
                    }
                }
            }
            
            





            session_destroy();
           mysqli_close($conn);
            ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles1.css"> 
</head>
<body>
<div class="welcome-message">
    <h1>Witaj 
    <?php
 
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    echo htmlspecialchars($login); 
} else {
    echo "nieznajomy";
}
?>
</h1>
    </div>
<div class="menu">
        <h2>Menu</h2>
        <ul>
            <li><a href="index.php">Strona główna</a></li>
            <li><a href="profile.php">Profil</a></li>
            <li><a href="settings.php">Ustawienia</a></li>
            <li><a href="logout.php">Wyloguj się</a></li>
            <?php
if(isset($_SESSION['position']) && $_SESSION['position'] == 'Menadżer') {
$position = htmlspecialchars($_SESSION['position']);
echo '<li><a href="manage.php">Zarządzaj</a></li>'; 
} 
if(isset($_SESSION['position']) && $_SESSION['position'] == 'Menadżer') {
    $position = htmlspecialchars($_SESSION['position']);
    echo '<li><a href="manage_content.php">Zarządzaj Treścią</a></li>'; 
    } 
?>

        </ul>
</div>
    <div class="container">

    

    <div class="main">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <ul>
                <h2>Dodaj Pracownika</h2>
                <li> Wpisz Login </li><input type="text" name="log"> 
                <li> Wpisz hasło </li><input type="text" name="haslo">
                <li> Wpisz Imię </li><input type="text" name="name">
                <li> Wpisz Nazwisko </li><input type="text" name="surname">
                <li> Wybierz Stanowisko </li>
                <select name="Stanowisko">
                    <option value="Pracownik">Pracownik</option>
                    <option value="Księgowa">Księgowa</option>
                    <option value="Grafik">Grafik</option>
                    <option value="Menadżer">Menadżer</option>
                </select>
                <input type="submit">
            </ul>
            <div class="select-container">
            <ul>
                    <h2>Zarządzaj pracownikami</h2>
                    <table>  
                      <tr><th><h2>Login</h2></th><th><h2>Stanowisko</h2></th><th><h2>Hasło</th></h2></tr>                   
                    <?php
                    echo $sending;
                    ?>
                    </table>
</div>

        </form>
    </div> 
    </div>
</body>
</html>