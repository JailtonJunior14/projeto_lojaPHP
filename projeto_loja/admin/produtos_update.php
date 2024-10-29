<?php
include 'protecao.php';
include 'conexao.php';

$usuario = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Loja ETEC - Adm. - Produtos</title>
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
            <li><a href="usuarios_index.php">Usuários</a></li>
            <li><a class="link-active" href="produtos_index.php">Produtos</a></li>
        </ul>
    </nav>
    <main>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        die("Tem foto");
    } else {
        die("Não tem foto");
    }

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
    
        $sql = "SELECT * FROM produtos WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Fetch e exibe o resultado
            $produto = $resultado->fetch_assoc();

            $foto = "../" . $produto["foto"];

            // O arquivo da foto existe?
            if (! file_exists($foto)) {
                // Se não existir, atribui um valor padrão
                $foto = "../imagens/nao_encontrado.png";
            }
?>
        <h1>Alterar Usuário</h1>
        <form action="produtos_update.php" method="post" enctype="multipart/form-data">
            <div class="campos">
                <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
                <label>Nome:</label>
                <input type="text" name="nome" value="<?php echo $produto['nome']; ?>" maxlength="50" required>

                <label>Descrição:</label>
                <textarea name="descricao" required><?php echo $produto['descricao']; ?></textarea>

                <label>Preço:</label>
                <input type="number" name="preco" value="<?php echo $produto['preco']; ?>" min="0" max="99999999.99" step="0.01" required>

                <label>Foto:</label>
                <input type="file" name="foto"><br>
                <img src="<?php echo $foto; ?>" alt="Foto do produto" class="foto-produto"><br>
                
                <input type="submit" value="Salvar">
            </div>
        </form>
<?php
        } else {
            echo "<p>Produto não encontrado.</p>";
        }
    } else {
        echo "<p>Produto não encontrado.</p>";
    }
}
?>
        <a href="produtos_index.php">Consultar Produtos</a>
    </main>
</body>
</html>
