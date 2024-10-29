<?php
include 'protecao.php';
include 'conexao.php';

$usuario = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    // Diretório onde a imagem será salva
    $diretorio = 'imagens/';
    
    // Verifica se o diretório existe, se não existir cria
    if (!file_exists("../$diretorio")) {
        mkdir("../$diretorio", 0777, true);
    }
    
    // Pega a extensão do arquivo
    $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    
    // Cria um nome único para o arquivo
    $novo_nome = uniqid() . '.' . $extensao;
    
    // Caminho completo onde a imagem será salva
    $caminho_foto = $diretorio . $novo_nome;

    // Move o arquivo para o diretório especificado
    if (move_uploaded_file($_FILES['foto']['tmp_name'], "../$caminho_foto")) {

        $sql = "INSERT INTO produtos (nome, descricao, preco, foto) 
            VALUES (?, ?, ?, ?)";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssds", $nome, $descricao, $preco, $caminho_foto);

        if ($stmt->execute()) {
            header('Location: produtos_index.php');
        } else {
            die("<b>Erro: </b>" . $stmt->error);
        }
    } else {
        die("<b>Erro ao fazer upload da imagem.</b>");
    }
}
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
        <h1>Adicionar Produto</h1>
        <form action="produtos_create.php" method="post" enctype="multipart/form-data">
            <div class="campos">
                <label>Nome:</label>
                <input type="text" name="nome" maxlength="50" required>

                <label>Descrição:</label>
                <textarea name="descricao" required></textarea>

                <label>Preço:</label>
                <input type="number" name="preco" min="0" max="99999999.99" step="0.01" required>

                <label>Foto:</label>
                <input type="file" name="foto" required><br>
                
                <input type="submit" value="Salvar">
            </div>
        </form>
        <a href="produtos_index.php">Consultar Produtos</a>
    </main>
</body>
</html>
