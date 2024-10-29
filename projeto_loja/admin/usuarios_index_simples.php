<?php
include 'conexao.php';

$sql = "SELECT * FROM usuarios";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Loja ETEC</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1><a href="index.php" class="logo">Loja ETEC</a></h1>
        <div class="user-info">
            <span>André Lima</span>
        </div>
    </header>    
    <nav>
        <ul>
            <li><a href="usuarios_index.php">Usuários</a></li>
            <li><a href="produtos_index.php">Produtos</a></li>
        </ul>
    </nav>
    <main>
        <h1>Cadastro de Usuários</h1>
        <a href="create.php">Adicionar Usuário</a>
        <table>
            <tr>
                <th>Ações</th>
                <th>ID</th>
                <th>Email</th>
                <th>Administrador</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <a href="update.php?id=<?php echo $row['id']; ?>">Editar</a> | 
                        <a href="delete.php?id=<?php echo $row['id']; ?>">Excluir</a>
                    </td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td class="align-center">
                        <?php echo $row['administrador'] ? 'Sim' : 'Não'; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </main>
</body>
</html>
