<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Atendimento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-3">
    <h1>Editar Atendimento</h1>

    <?php
        require_once("conexao.php");

        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $valor = $_POST['valor'];
            $data = $_POST['data'];
            $id_pet = $_POST['id_pet'];

            $sql = "UPDATE atendimentos SET nome = :nome, descricao = :descricao, valor = :valor, data = :data, id_pet = :id_pet WHERE id = :id";
            $resultado = $con->prepare($sql);
            $resultado->bindParam(":nome", $nome);
            $resultado->bindParam(":descricao", $descricao);
            $resultado->bindParam(":valor", $valor);
            $resultado->bindParam(":data", $data);
            $resultado->bindParam(":id_pet", $id_pet);
            $resultado->bindParam(":id", $id);

            if ($resultado->execute()) {
                echo "<p>Atendimento atualizado com sucesso!</p>";
            } else {
                echo "<p>Erro ao atualizar atendimento!</p>";
            }
        }

        $sql = "SELECT * FROM atendimentos WHERE id = :id";
        $resultado = $con->prepare($sql);
        $resultado->bindParam(":id", $id);
        $resultado->execute();
        $atendimento = $resultado->fetch();
    ?>

    <?php if ($atendimento) { ?>
    <form method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome do atendimento</label>
            <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $atendimento['nome']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" id="descricao" name="descricao" class="form-control" value="<?php echo $atendimento['descricao']; ?>">
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor (R$)</label>
            <input type="number" id="valor" name="valor" class="form-control" step="0.01" min="0" value="<?php echo $atendimento['valor']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="data" class="form-label">Data do atendimento</label>
            <input type="date" id="data" name="data" class="form-control" value="<?php echo $atendimento['data']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="id_pet" class="form-label">Animal atendido</label>
            <select id="id_pet" name="id_pet" class="form-select" required>
                <?php
                    $sql = "SELECT * FROM pets";
                    $resultado = $con->query($sql);
                    $pets = $resultado->fetchAll();

                    foreach ($pets as $pet) {
                        if ($pet['id'] == $atendimento['id_pet']) {
                            echo "<option value='".$pet['id']."' selected>".$pet['nome']."</option>";
                        } else {
                            echo "<option value='".$pet['id']."'>".$pet['nome']."</option>";
                        }
                    }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
    <?php } else { ?>
        <p>Atendimento não encontrado!</p>
    <?php } ?>

    <a href="atendimentos.php" class="btn btn-primary mt-3">Voltar</a>
</div>
</body>
</html>
