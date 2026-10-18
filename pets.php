<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cadastro de Animais</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container py-3">
            <h1>Cadastro de Animais</h1>

            <form method="post">
                <div class="mb-3">
                    <label for="nome" class="form-label">Informe o nome do animal</label>
                    <input type="text" id="nome" name="nome" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="especie" class="form-label">Informe a espécie</label>
                    <input type="text" id="especie" name="especie" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="raca" class="form-label">Informe a raça</label>
                    <input type="text" id="raca" name="raca" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="nascimento" class="form-label">Data de nascimento</label>
                    <input type="date" id="nascimento" name="nascimento" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="id_tutor" class="form-label">Selecione o tutor</label>
                    <select id="id_tutor" name="id_tutor" class="form-select" required>
                        <option value="">Selecione um tutor</option>
                        <?php
                            require_once("conexao.php");

                            $sql = "SELECT * FROM tutores";
                            $resultado = $con->query($sql);
                            $tutores = $resultado->fetchAll();

                            foreach ($tutores as $tutor) {
                                echo "<option value='".$tutor['id']."'>".$tutor['nome']."</option>";
                            }
                        ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Cadastrar Animal</button>
                <a href="index.php" class="btn btn-primary">Voltar</a>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $nome = $_POST['nome'];
                    $especie = $_POST['especie'];
                    $raca = $_POST['raca'];
                    $nascimento = $_POST['nascimento'];
                    $id_tutor = $_POST['id_tutor'];

                    $sql = "INSERT INTO pets (nome, especie, raca, nascimento, id_tutor)
                            VALUES (:nome, :especie, :raca, :nascimento, :id_tutor)";

                    $resultado = $con->prepare($sql);
                    $resultado->bindParam(":nome", $nome);
                    $resultado->bindParam(":especie", $especie);
                    $resultado->bindParam(":raca", $raca);
                    $resultado->bindParam(":nascimento", $nascimento);
                    $resultado->bindParam(":id_tutor", $id_tutor);

                    if ($resultado->execute()) {
                        echo "<p>Animal cadastrado com sucesso!</p>";
                    } else {
                        echo "<p>Erro ao cadastrar animal!</p>";
                    }
                }
            ?>

            <h2 class="mt-5">Animais Cadastrados</h2>

            <?php
                $sql = "SELECT pets.*, tutores.nome AS nome_tutor
                        FROM pets
                        INNER JOIN tutores ON pets.id_tutor = tutores.id";

                $resultado = $con->query($sql);
                $pets = $resultado->fetchAll();

                foreach ($pets as $pet) {
                    echo "<div class='border p-2 mb-2'>";
                    echo "<p>ID: ".$pet['id']."</p>";
                    echo "<p>Nome: ".$pet['nome']."</p>";
                    echo "<p>Espécie: ".$pet['especie']."</p>";
                    echo "<p>Raça: ".$pet['raca']."</p>";
                    echo "<p>Data de nascimento: ".$pet['nascimento']."</p>";
                    echo "<p>Tutor: ".$pet['nome_tutor']."</p>";
                    echo " <a href='excluir_pet.php?id=".$pet['id']."' class='btn btn-danger btn-sm'>Excluir</a>";
                    echo "<a href='editar_pet.php?id=".$pet['id']."' class='btn btn-primary btn-sm'>Editar</a>";
                    echo "</div>";
                }
            ?>
        </div>
    </body>
</html>
