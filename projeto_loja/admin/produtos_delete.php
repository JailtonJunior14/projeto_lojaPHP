<?php
include 'protecao.php';
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM produtos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $produto = $resultado->fetch_assoc();

    $caminho_foto = "../" . $produto['foto'];

    if (file_exists($caminho_foto)) {
        // Tenta excluir o arquivo
        if (unlink($caminho_foto)) {
            // Arquivo excluído com sucesso
        } else {
            die("Erro ao excluir o arquivo.");
        }
    }

    $sql = "DELETE FROM produtos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: produtos_index.php');
    } else {
        die("Erro:<br>" . $stmt->error);
    }
} else {
    header('Location: produtos_index.php');
}
?>
