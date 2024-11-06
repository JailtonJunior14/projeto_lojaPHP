<?php
include 'protecao.php';
include 'conexao.php';

//$usuario = $_SESSION['nome'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    $sql = "INSERT INTO vendedores (nome, ativo) 
        VALUES (?, ?)";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("si", $nome, $ativo);

    if ($stmt->execute()) {
        header('Location: vendedores_index.php');
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
        <form action="vendedores_create.php" method="post">
            <div class="campos">
                <label>Nome:</label>
                <input type="text" name="nome" required>

                <label><input type="checkbox" name="ativo"> Ativo</label>
                
                <input type="submit" value="Salvar">
            </div>
        </form>
        <a href="vendedores_index.php">Consultar Vendedores</a>
    </main>
</body>
</html>
