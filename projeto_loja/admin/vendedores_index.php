<?php
include 'protecao.php';
include 'conexao.php';

$usuario = $_SESSION['nome'];

// Definir o número de registros por página
$records_per_page = 10;

// Obter o termo de pesquisa, se presente
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchLike = "%$search%";

// Obter o número total de registros
$sql = "SELECT COUNT(*) total FROM vendedores WHERE nome LIKE ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $searchLike);
$stmt->execute();

// Obtém o resultado da consulta
$resultado = $stmt->get_result();

// Retorna a próxima linha do resultado da consulta como um array associativo
$consulta = $resultado->fetch_assoc();
$total_records = $consulta['total'];

// Calcular o número total de páginas
$total_pages = ceil($total_records / $records_per_page);

// Obter o número da página atual a partir da URL, se presente, caso contrário, definir como 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages) {
    $current_page = $total_pages;
}

// Calcular o início do registro da consulta SQL
$start_from = ($current_page - 1) * $records_per_page;

if ($start_from < 0) {
    $start_from = 0;
}

// Obter os registros para a página atual
$sql = "SELECT * FROM vendedores WHERE nome LIKE ? LIMIT ?, ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sii", $searchLike, $start_from, $records_per_page);
$stmt->execute();

// Obtém o resultado da consulta
$resultado = $stmt->get_result();
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
            <li><a class="link-active" href="vendedores_index.php">Usuários</a></li>
            <li><a href="produtos_index.php">Produtos</a></li>
            <li><a href="vendedores_index.php">Vendedores</a></li>
        </ul>
    </nav>
    <main>
        <h1>Cadastro de Usuários</h1>
        <a href="vendedores_create.php" class="link-add">Adicionar Usuário</a>

        <form method="GET" action="vendedores_index.php">
            <div class="campos">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Pesquisar por nome">
                <button type="submit">Pesquisar</button>
            </div>
        </form>

        <table>
            <tr>
                <th>Ações</th>
                <th>ID</th>
                <th>nome</th>
                <th>Ativo</th>
            </tr>
            <?php while($row = $resultado->fetch_assoc()): ?>
                <tr>
                    <td>
                        <a href="vendedores_update.php?id=<?php echo $row['id']; ?>">Editar</a> | 
                        <a href="vendedores_delete.php?id=<?php echo $row['id']; ?>" onclick="confirmarExclusao(event)">Excluir</a>
                    </td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td class="align-center">
                        <?php echo $row['administrador'] ? 'Sim' : 'Não'; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- Paginação -->
        <div class="pagination">
            <?php if($current_page > 1): ?>
                <a href="vendedores_index.php?page=<?php echo $current_page - 1; ?>">Anterior</a>
            <?php endif; ?>

            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <a href="vendedores_index.php?page=<?php echo $i; ?>" <?php if($i == $current_page) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if($current_page < $total_pages): ?>
                <a href="vendedores_index.php?page=<?php echo $current_page + 1; ?>">Próximo</a>
            <?php endif; ?>
        </div>
    </main>

    <script>
        function confirmarExclusao(event) {
            if (! confirm('Tem certeza que deseja excluir este registro?')) {
                event.preventDefault();
            }
        }
    </script>
</body>
</html>
