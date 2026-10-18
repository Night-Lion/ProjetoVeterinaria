<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Animal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-3">
    <h1>Editar Animal</h1>

    <?php
        require_once("conexao.php");

        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $especie = $_POST['especie'];
            $raca = $_POST['raca'];
            $nascimento = $_POST['nascimento'];
            $id_tutor = $_POST['id_tutor'];

            $sql = "UPDATE pets SET nome = :nome, especie = :especie, raca = :raca, nascimento = :nascimento, id_tutor = :id_tutor WHERE id = :id";
            $resultado = $con->prepare($sql);
            $resultado->bindParam(":nome", $nome);
            $resultado->bindParam(":especie", $especie);
            $resultado->bindParam(":raca", $raca);
            $resultado->bindParam(":nascimento", $nascimento);
            $resultado->bindParam(":id_tutor", $id_tutor);
            $resultado->bindParam(":id", $id);

            if ($resultado->execute()) {
                echo "<p>Animal atualizado com sucesso!</p>";
            } else {
                echo "<p>Erro ao atualizar animal!</p>";
            }
        }

        $sql = "SELECT * FROM pets WHERE id = :id";
        $resultado = $con->prepare($sql);
        $resultado->bindParam(":id", $id);
        $resultado->execute();
        $pet = $resultado->fetch();
    ?>

    <?php if ($pet) { ?>
    <form method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome do animal</label>
            <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $pet['nome']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="especie" class="form-label">Espécie</label>
            <input type="text" id="especie" name="especie" class="form-control" value="<?php echo $pet['especie']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="raca" class="form-label">Raça</label>
            <input type="text" id="raca" name="raca" class="form-control" value="<?php echo $pet['raca']; ?>">
        </div>

        <div class="mb-3">
            <label for="nascimento" class="form-label">Data de nascimento</label>
            <input type="date" id="nascimento" name="nascimento" class="form-control" value="<?php echo $pet['nascimento']; ?>">
        </div>

        <div class="mb-3">
            <label for="id_tutor" class="form-label">Selecione o tutor</label>
            <select id="id_tutor" name="id_tutor" class="form-select" required>
                <?php
                    $sql = "SELECT * FROM tutores";
                    $resultado = $con->query($sql);
                    $tutores = $resultado->fetchAll();

                    foreach ($tutores as $tutor) {
                        if ($tutor['id'] == $pet['id_tutor']) {
                            echo "<option value='".$tutor['id']."' selected>".$tutor['nome']."</option>";
                        } else {
                            echo "<option value='".$tutor['id']."'>".$tutor['nome']."</option>";
                        }
                    }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
    <?php } else { ?>
        <p>Animal não encontrado!</p>
    <?php } ?>

    <a href="pets.php" class="btn btn-primary mt-3">Voltar</a>
</div>
</body>
</html>
