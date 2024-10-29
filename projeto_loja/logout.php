<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])){
    $_SESSION = [];

    session_destroy();
}

header("Location: index.php");
?>