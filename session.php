<?php

session_start();

if (!isset($_SESSION['login'])) {

    if (isset($_COOKIE['login']) && isset($_COOKIE['position'])) {
        $_SESSION['login'] = $_COOKIE['login'];
        $_SESSION['position'] = $_COOKIE['position'];
    } else {
        header("Location: login.php");
        exit();
    }
}


$login = $_SESSION['login'];
$position = $_SESSION['position'];
?>



