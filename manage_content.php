<?php
include 'session.php';

// Połączenie z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$database = "project_1";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}

// Dodawanie treści
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['query'])) {
    $works = mysqli_real_escape_string($conn, $_POST['works']);
    $people_value = mysqli_real_escape_string($conn, $_POST['people_value']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $employees = isset($_POST['employees']) ? $_POST['employees'] : array();
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    
    if (!empty($works) && !empty($people_value) && !empty($description) && !empty($employees) && !empty($date)) {
        $employeesList = mysqli_real_escape_string($conn, implode(", ", $employees)); // Konwersja tablicy na string

        $pendingQuery = "INSERT INTO `zadania_baza`(`zadania`, `iloscosob`, `opis`, `osoby`, `data`)
                        VALUES ('$works', '$people_value', '$description', '$employeesList', '$date')";

        if (mysqli_query($conn, $pendingQuery)) {
            echo "Nowe zadanie zostało dodane pomyślnie.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Błąd podczas dodawania zadania: " . mysqli_error($conn);
        }
    }
}

// Usuwanie treści
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_note'])) {
    $notedelete = mysqli_real_escape_string($conn, $_POST['note_name']);
    $deleteQuery = "DELETE FROM `zadania_baza` WHERE `zadania` = '$notedelete'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Pomyślnie usunięto zadanie o tytule " . htmlspecialchars($notedelete) . "<br>";
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    } else {
        echo "Błąd usuwania zadania: " . mysqli_error($conn) . "<br>";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles1.css">
    <title>Zadania</title>
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
            <th>Akcje</th>
        </tr>
        <?php
        $query = "SELECT `zadania`, `iloscosob`, `opis`, `osoby`, `data` FROM `zadania_baza`";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo '<td class="Table1">' . htmlspecialchars($row['zadania']) . '</td>';
                echo '<td class="Table2">' . htmlspecialchars($row['iloscosob']) . '</td>';
                echo '<td class="Table3">' . htmlspecialchars($row['opis']) . '</td>';
                echo '<td class="Table4">' . htmlspecialchars($row['osoby']) . '</td>';
                echo '<td class="Table5">' . htmlspecialchars($row['data']) . '</td>';
                echo '<td>
                    <form method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                        <input type="hidden" name="note_name" value="' . htmlspecialchars($row['zadania']) . '">
                        <input type="submit" name="delete_note" value="Usuń zadanie">
                    </form>
                </td>';
                echo "</tr>";
            }
        }
        ?>
    </table>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table>
            <tr>
                <th>Zadanie</th>
                <th>Ilość osób</th>
                <th>Opis zadania</th>
                <th>Osoby przydzielone</th>
                <th>Data</th>
                <th><input type="submit" name="query" value="Dodaj zadanie"></th>
            </tr>
            <tr>
                <td><input type="text" name="works" placeholder="Wpisz nazwę zadania" required></td>
                <td><input type="number" name="people_value" placeholder="Wpisz ilość osób" required></td>
                <td><input type="text" name="description" placeholder="Opis zadania" required></td>
                <td>
                    <?php
                    $PeopleQuery = "SELECT `name`, `surname` FROM `pracownicy`";
                    $result = mysqli_query($conn, $PeopleQuery);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $fullName = htmlspecialchars($row['name'] . ' ' . $row['surname']);
                            echo '<input type="checkbox" name="employees[]" value="' . $fullName . '">';
                            echo '<label for="employees[]">' . $fullName . '</label><br>';
                        }
                    }
                    ?>
                </td>
                <td><input type="date" name="date" required></td>
            </tr>
        </table>
    </form>
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
        if (isset($_SESSION['position']) && $_SESSION['position'] == 'Menadżer') {
            $position = htmlspecialchars($_SESSION['position']);
            echo '<li><a href="manage.php">Zarządzaj</a></li>';
        }
        ?>
    </ul>
</div>
</body>
</html>
<?php
mysqli_close($conn);
?>
