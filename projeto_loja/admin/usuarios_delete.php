<?php
include 'protecao.php';
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: usuarios_index.php');
    } else {
        die("Erro:<br>" . $stmt->error);
    }
} else {
    header('Location: usuarios_index.php');
}
?>
