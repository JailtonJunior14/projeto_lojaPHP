<?php
include 'protecao.php';

$usuario = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja ETEC - Adm.</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <header>
        <h1><a href="index.php" class="logo">Loja ETEC - Administração</a></h1>
        <div class="user-info">
            <span><a href="../index.php">Loja</a></span>
            <span> | </span>
            <span class="user-name"><?=$usuario?></span>
        </div>
    </header>    
    <nav>
        <ul>
            <li><a class="link-active" href="index.php">Principal</a></li>
            <li><a href="usuarios_index.php">Usuários</a></li>
            <li><a href="produtos_index.php">Produtos</a></li>
        </ul>
    </nav>
    <main>
        <h1>Bem vindo!</h1>
        <p class='user-email'><?=$usuario?></p>
    </main>
</body>
</html>
