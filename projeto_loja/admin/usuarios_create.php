<?php
include 'protecao.php';
include 'conexao.php';

$usuario = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
    $administrador = isset($_POST['administrador']) ? 1 : 0;

    $sql = "INSERT INTO usuarios (email, senha, administrador) 
        VALUES (?, ?, ?)";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssi", $email, $senha, $administrador);

    if ($stmt->execute()) {
        header('Location: usuarios_index.php');
    } else {
        die("<b>Erro: </b>" . $stmt->error);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Loja ETEC - Adm. - Usuários</title>
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
            <li><a href="index.php">Principal</a></li>
            <li><a class="link-active" href="usuarios_index.php">Usuários</a></li>
            <li><a href="produtos_index.php">Produtos</a></li>
        </ul>
    </nav>
    <main>
        <h1>Adicionar Usuário</h1>
        <form action="usuarios_create.php" method="post">
            <div class="campos">
                <label>Email:</label>
                <input type="email" name="email" required>

                <label>Senha:</label>
                <input type="password" name="senha" required>

                <label><input type="checkbox" name="administrador"> Administrador</label>
                
                <input type="submit" value="Salvar">
            </div>
        </form>
        <a href="usuarios_index.php">Consultar Usuários</a>
    </main>
</body>
</html>
