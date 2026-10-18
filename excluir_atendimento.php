<?php
    require_once("conexao.php");

    $id = $_GET['id'];

    $sql = "DELETE FROM atendimentos WHERE id = :id";
    $resultado = $con->prepare($sql);
    $resultado->bindParam(":id", $id);

    if ($resultado->execute()) {
        echo "Atendimento excluído com sucesso!";
    } else {
        echo "Erro ao excluir atendimento!";
    }
?>

<p><a href="atendimentos.php">Voltar para atendimentos</a></p>
