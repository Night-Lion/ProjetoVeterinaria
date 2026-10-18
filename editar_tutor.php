<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Tutor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-3">
    <h1>Editar Tutor</h1>

    <?php
        require_once("conexao.php");

        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $telefone = $_POST['telefone'];
            $endereco = $_POST['endereco'];

            $sql = "UPDATE tutores SET nome = :nome, cpf = :cpf, telefone = :telefone, endereco = :endereco WHERE id = :id";
            $resultado = $con->prepare($sql);
            $resultado->bindParam(":nome", $nome);
            $resultado->bindParam(":cpf", $cpf);
            $resultado->bindParam(":telefone", $telefone);
            $resultado->bindParam(":endereco", $endereco);
            $resultado->bindParam(":id", $id);

            if ($resultado->execute()) {
                echo "<p>Tutor atualizado com sucesso!</p>";
            } else {
                echo "<p>Erro ao atualizar tutor!</p>";
            }
        }

        $sql = "SELECT * FROM tutores WHERE id = :id";
        $resultado = $con->prepare($sql);
        $resultado->bindParam(":id", $id);
        $resultado->execute();
        $tutor = $resultado->fetch();
    ?>

    <?php if ($tutor) { ?>
    <form method="post">
        <div class="mb-3">
            <label for="nome" class="form-label">Informe o nome</label>
            <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $tutor['nome']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">Informe o CPF</label>
            <input type="text" id="cpf" name="cpf" class="form-control" value="<?php echo $tutor['cpf']; ?>">
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">Informe o telefone</label>
            <input type="text" id="telefone" name="telefone" class="form-control" value="<?php echo $tutor['telefone']; ?>">
        </div>

        <div class="mb-3">
            <label for="endereco" class="form-label">Informe o endereço</label>
            <input type="text" id="endereco" name="endereco" class="form-control" value="<?php echo $tutor['endereco']; ?>">
        </div>

        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
    <?php } else { ?>
        <p>Tutor não encontrado!</p>
    <?php } ?>

    <a href="tutores.php" class="btn btn-primary mt-3">Voltar</a>
</div>
</body>
</html>
