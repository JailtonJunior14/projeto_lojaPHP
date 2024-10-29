<?php
session_start();
if(!(isset($_SESSION['administrador'])&&
$_SESSION['administrador']== 1)){
    header("Location: ../login.php");
    exit;
}
?>