<?php
include 'protecao.php';
include 'conexao.php';

$usuario = $_SESSION['email'];
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
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $administrador = isset($_POST['administrador']) ? 1 : 0;

    if (!empty($_POST['senha'])) {
        $senha = md5($_POST['senha']);
        $sql = "UPDATE usuarios SET email = ?, senha = ?, administrador = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('ssii', $email, $senha, $administrador, $id);
    } else {
        $sql = "UPDATE usuarios SET email = ?, administrador = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('sii', $email, $administrador, $id);
    }

    if ($stmt->execute()) {
        header('Location: usuarios_index.php');
    } else {
        die("Erro:<br>" . $stmt->error);
    }
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Fetch e exibe o resultado
            $usuario = $resultado->fetch_assoc();
?>
        <h1>Alterar Usuário</h1>
        <form action="usuarios_update.php" method="post">
            <div class="campos">
                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>

                <label>Senha:</label>
                <input type="password" name="senha">

                <label><input type="checkbox" name="administrador" 
                    <?php echo ($usuario['administrador'] == 1 ? "checked" : "");?>> Administrador</label>
                
                <input type="submit" value="Salvar">
            </div>
        </form>
<?php
        } else {
            echo "<p>Usuário não encontrado.</p>";
        }
    } else {
        echo "<p>Usuário não encontrado.</p>";
    }
}
?>
        <a href="usuarios_index.php">Consultar Usuários</a>
    </main>
</body>
</html>
