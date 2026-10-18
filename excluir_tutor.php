<?php
    require_once("conexao.php");

    $id = $_GET['id'];

    $sql = "DELETE FROM tutores WHERE id = :id";
    $resultado = $con->prepare($sql);
    $resultado->bindParam(":id", $id);

    if ($resultado->execute()) {
        echo "Tutor excluído com sucesso!";
    } else {
        echo "Erro ao excluir tutor!";
    }
?>

<p><a href="tutores.php">Voltar para tutores</a></p>