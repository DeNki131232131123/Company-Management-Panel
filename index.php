<?php
    include 'session.php';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "project_1";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn){
        die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
    }

    $query = "SELECT `zadania`, `iloscosob`,`opis`, `osoby`,`data` FROM `zadania_baza`";
    $result =  mysqli_query($conn,$query);





?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
<div class="content">
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
</div>
<div class="container">
   <div class="main">
    <h2>Zadania</h2>
        <table>
             <tr> 
                <th class="Table1">Zadanie</th>
                <th class="Table2">Ilość osób</th>
                <th class="Table3">Opis zadania</th>
                <th class="Table4">Osoby przydzielone</th>
                <th class="Table5">Data</th>
             </tr>
             <?php
            if(mysqli_num_rows($result) > 0){
                while ($row =mysqli_fetch_assoc($result)){
                    echo "<tr>"; 
                    echo '<td class="Table1">' . $row['zadania'] .'</td>';
                    echo '<td class="Table2">' . $row['iloscosob'] .'</td>';
                    echo '<td class="Table3">' . $row['opis'] .'</td>';
                    echo '<td class="Table4">' . $row['osoby'] .'</td>';
                    echo '<td class="Table5">' . $row['data'] .'</td>';
                    echo '</tr>';
                }
            }
            ?>
        </table>
        </div>
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
?>

            </ul>
    </div>

</body>
</html>
