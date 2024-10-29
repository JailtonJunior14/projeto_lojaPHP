<?php
// Adiciona o arquivo de conexão
include "admin/conexao.php";

// Inicia a sessão
session_start();

// Nome do usuário atual
$usuario = "Visitante";
// Indica se o usuário atual é um 'administrador'
$administrador = false;

if (isset($_SESSION['email'])) {
    $usuario = $_SESSION['email'];
    $administrador = $_SESSION['administrador'];
}

// Verifica se a variável de sessão 'total' existe
if (!isset($_SESSION['total'])) {
    // Se não existir, cria a variável de sessão e atribui o valor zero
    $_SESSION['total'] = 0;
}

// Verifica se foi clicado no botão 'Comprar"
if (isset($_POST['id'])) {
    $sql = "SELECT preco FROM produtos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $_POST['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se um usuário foi encontrado
    if ($result->num_rows === 1) {
        $produto = $result->fetch_assoc();

        $_SESSION['total'] += $produto['preco'];
    }
}

// Formata o valor de 'total' no formato R$ 1.234,56
$valor_formatado = "R$ " . number_format($_SESSION['total'], 2, ',', '.');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja ETEC</title>
    <link rel="stylesheet" href="css/loja.css">
</head>
<body>
    <header>
        <h1><a href="index.php">Loja ETEC</a></h1>
        <div class="cart-info">
        <?php
            if ($administrador) {
        ?>
                <span><a href="/loja/admin/">Admin</a></span>
                <span> | </span> 
        <?php
            }
        ?>
            <span><img class="cart-icon" src="imagens/carrinho.png" alt="Carrinho"></span>
            <span>Total: <?=$valor_formatado?></span>
            <span> | </span>
            <span class="user-name"><?=$usuario?></span>
            <span> | </span>
            <span>
        <?php
                if (!isset($_SESSION['email'])) {
        ?>
                    <a href="login.php">Realizar login</a>
        <?php
                } else {
        ?>
                    <form action="logout.php" method="post">
                        <button name="logout" type="submit" class="link-button">Logout</button>
                    </form>
        <?php
                }
        ?>
            </span>
        </div>
    </header>
    <main>
        <?php
        // Consulta SQL para selecionar todos os produtos
        $sql = "SELECT * FROM produtos ORDER BY id";
        $result = $conexao->query($sql);

        // Verifica se a consulta retornou algum resultado
        if ($result->num_rows > 0) {
            // Loop pelos resultados e exibe cada produto
            while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $nome = $row["nome"];
                $descricao = $row["descricao"];
                $preco_formatado = "R$ " . number_format($row["preco"], 2, ',', '.');
                $foto = $row["foto"];

                // O arquivo da foto existe?
                if (! file_exists($foto)) {
                    // Se não existir, atribui um valor padrão
                    $foto = "imagens/nao_encontrado.png";
                }
        ?>
        <div class="product">
            <img src="<?=$foto?>" alt="Foto do produto">
            <div class="product-details">
                <h2><?=$nome?></h2>
                <p><?=$descricao?></p>
                <p class="product-price"><?=$preco_formatado?></p>
        <?php
                if (isset($_SESSION['email'])) {
        ?>
                    <form action="index.php" method="post">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <button class="add-to-cart" name="botao_comprar">Comprar</button>
                    </form>
        <?php
                }
        ?>
            </div>
        </div>
        <?php
            }
        }
        ?>
    </main>
</body>
</html>
