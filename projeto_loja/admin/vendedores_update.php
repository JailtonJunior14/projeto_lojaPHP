<?php
include 'protecao.php';
include 'conexao.php';

//$usuario = $_SESSION['nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Loja ETEC - Adm. - Vendedores</title>
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
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    
        $sql = "UPDATE vendedores SET nome = ?, ativo = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('sii', $nome, $ativo, $id);

    if ($stmt->execute()) {
        header('Location: vendedores_index.php');
    } else {
        die("Erro:<br>" . $stmt->error);
    }
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        $sql = "SELECT * FROM vendedores WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Fetch e exibe o resultado
            $usuario = $resultado->fetch_assoc();
?>
        <h1>Alterar Vendedor</h1>
        <form action="vendedores_update.php" method="post">
            <div class="campos">
                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                <label>Nome:</label>
                <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>" required>

                <label><input type="checkbox" name="ativo" 
                    <?php echo ($usuario['ativo'] == 1 ? "checked" : "");?>> Ativo</label>
                
                <input type="submit" value="Salvar">
            </div>
        </form>
<?php
        } else {
            echo "<p>Vendedor não encontrado.</p>";
        }
    } else {
        echo "<p>Vendedor não encontrado.</p>";
    }
}
?>
        <a href="vendedores_index.php">Consultar Vendedores</a>
    </main>
</body>
</html>
