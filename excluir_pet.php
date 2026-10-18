<?php
    require_once("conexao.php");

    $id = $_GET['id'];

    $sql = "SELECT * FROM atendimentos WHERE id_pet = :id";
    $resultado = $con->prepare($sql);
    $resultado->bindParam(":id", $id);
    $resultado->execute();
    $atendimentos = $resultado->fetchAll();

    if (count($atendimentos) > 0) {
        echo "Não é possível excluir este animal, pois existem atendimentos cadastrados para ele!";
    } else {
        $sql = "DELETE FROM pets WHERE id = :id";
        $resultado = $con->prepare($sql);
        $resultado->bindParam(":id", $id);

        if ($resultado->execute()) {
            echo "Animal excluído com sucesso!";
        } else {
            echo "Erro ao excluir animal!";
        }
    }
?>

<p><a href="pets.php">Voltar para animais</a></p>
