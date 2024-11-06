<?php
include 'protecao.php';
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM vendedores WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: vendedores_index.php');
    } else {
        die("Erro:<br>" . $stmt->error);
    }
} else {
    header('Location: vendedores_index.php');
}
?>
