<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cadastro de Tutores</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container py-3">
            <h1>Cadastro de Tutores</h1>

            <form method="post">
                <div class="mb-3">
                    <label for="nome" class="form-label">Informe o nome</label>
                    <input type="text" id="nome" name="nome" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="cpf" class="form-label">Informe o CPF</label>
                    <input type="text" id="cpf" name="cpf" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">Informe o telefone</label>
                    <input type="text" id="telefone" name="telefone" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Informe o endereço</label>
                    <input type="text" id="endereco" name="endereco" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Cadastrar Tutor</button>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $nome = $_POST['nome'];
                    $cpf = $_POST['cpf'];
                    $telefone = $_POST['telefone'];
                    $endereco = $_POST['endereco'];

                    require_once("conexao.php");

                    $sql = "INSERT INTO tutores (nome, cpf, telefone, endereco)
                            VALUES (:nome, :cpf, :telefone, :endereco)";

                    $resultado = $con->prepare($sql);
                    $resultado->bindParam(":nome", $nome);
                    $resultado->bindParam(":cpf", $cpf);
                    $resultado->bindParam(":telefone", $telefone);
                    $resultado->bindParam(":endereco", $endereco);

                    if ($resultado->execute()) {
                        echo "<p>Tutor cadastrado com sucesso!</p>";
                    } else {
                        echo "<p>Erro ao cadastrar tutor!</p>";
                    }
                }
            ?>

            <h2 class="mt-5">Tutores Cadastrados</h2>

            <?php
                require_once("conexao.php");

                $sql = "SELECT * FROM tutores";
                $resultado = $con->query($sql);
                $tutores = $resultado->fetchAll();

                foreach ($tutores as $tutor) {
                    echo "<div class='border p-2 mb-2'>";
                    echo "<p>ID: ".$tutor['id']."</p>";
                    echo "<p>Nome: ".$tutor['nome']."</p>";
                    echo "<p>CPF: ".$tutor['cpf']."</p>";
                    echo "<p>Telefone: ".$tutor['telefone']."</p>";
                    echo "<p>Endereço: ".$tutor['endereco']."</p>";
                    echo "<a href='excluir_tutor.php?id=".$tutor['id']."' class='btn btn-danger btn-sm'>Excluir</a>";
                    echo " <a href='editar_tutor.php?id=".$tutor['id']."' class='btn btn-primary btn-sm'>Editar</a>";
                    echo "</div>";
                }
            ?>

            <a href="index.php" class="btn btn-primary">Voltar</a>
        </div>
    </body>
</html>
