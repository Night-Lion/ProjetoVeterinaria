<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cadastro de Atendimentos</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container py-3">
            <h1>Cadastro de Atendimentos</h1>

            <form method="post">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do atendimento</label>
                    <input type="text" id="nome" name="nome" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" id="descricao" name="descricao" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="valor" class="form-label">Valor (R$)</label>
                    <input type="number" id="valor" name="valor" class="form-control" step="0.01" min="0" required>
                </div>

                <div class="mb-3">
                    <label for="data" class="form-label">Data do atendimento</label>
                    <input type="date" id="data" name="data" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="id_pet" class="form-label">Animal atendido</label>
                    <select id="id_pet" name="id_pet" class="form-select" required>
                        <option value="">Selecione um animal</option>
                        <?php
                            require_once("conexao.php");

                            $sql = "SELECT * FROM pets";
                            $resultado = $con->query($sql);
                            $pets = $resultado->fetchAll();

                            foreach ($pets as $pet) {
                                echo "<option value='".$pet['id']."'>".$pet['nome']."</option>";
                            }
                        ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Cadastrar Atendimento</button>
                <a href="index.php" class="btn btn-primary">Voltar</a>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $nome = $_POST['nome'];
                    $descricao = $_POST['descricao'];
                    $valor = $_POST['valor'];
                    $data = $_POST['data'];
                    $id_pet = $_POST['id_pet'];

                    $sql = "INSERT INTO atendimentos (nome, descricao, valor, data, id_pet)
                            VALUES (:nome, :descricao, :valor, :data, :id_pet)";

                    $resultado = $con->prepare($sql);
                    $resultado->bindParam(":nome", $nome);
                    $resultado->bindParam(":descricao", $descricao);
                    $resultado->bindParam(":valor", $valor);
                    $resultado->bindParam(":data", $data);
                    $resultado->bindParam(":id_pet", $id_pet);

                    if ($resultado->execute()) {
                        echo "<p>Atendimento cadastrado com sucesso!</p>";
                    } else {
                        echo "<p>Erro ao cadastrar atendimento!</p>";
                    }
                }
            ?>

            <h2 class="mt-5">Atendimentos Cadastrados</h2>

            <?php
                $sql = "SELECT atendimentos.*, pets.nome AS nome_pet
                        FROM atendimentos
                        INNER JOIN pets ON atendimentos.id_pet = pets.id";

                $resultado = $con->query($sql);
                $atendimentos = $resultado->fetchAll();

                foreach ($atendimentos as $atendimento) {
                    echo "<div class='border p-2 mb-2'>";
                    echo "<p>ID: ".$atendimento['id']."</p>";
                    echo "<p>Nome: ".$atendimento['nome']."</p>";
                    echo "<p>Descrição: ".$atendimento['descricao']."</p>";
                    echo "<p>Valor: R$ ".$atendimento['valor']."</p>";
                    echo "<p>Data: ".$atendimento['data']."</p>";
                    echo "<p>Animal: ".$atendimento['nome_pet']."</p>";
                    echo "<a href='editar_atendimento.php?id=".$atendimento['id']."' class='btn btn-primary btn-sm'>Editar</a>";
                    echo " <a href='excluir_atendimento.php?id=".$atendimento['id']."' class='btn btn-danger btn-sm'>Excluir</a>";
                    echo "</div>";
                }
            ?>
        </div>
    </body>
</html>
