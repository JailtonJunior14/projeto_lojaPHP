<?php

include_once "admin/conexao.php";

$email = $_POST["email"];
$senha = $_POST["senha"];

$sql = "SELECT email, senha, administrador FROM usuarios WHERE email = ? AND senha = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ss", $email, md5($senha));
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 1){
    $usuario = $result->fetch_assoc();

    session_start();
    $_SESSION['email'] = $email;

    if($usuario['administrador'] == 1){
        $_SESSION['administrador'] = true;
    }else{
        $_SESSION['administrador'] = false;
    }

    header("Location: index.php");
}else{
    header("Location: login.php?erro=1");
}

$stmt->close();
$conexao->close();





?>