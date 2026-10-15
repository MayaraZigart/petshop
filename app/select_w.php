<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

$pet = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];

    $sql = "SELECT * FROM pets WHERE id = $1";

    $resultado = pg_query_params(
        $conn,
        $sql,
        [$id]
    );

    if ($resultado) {
        $pet = pg_fetch_assoc($resultado);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Consultar Pet</title>

    <link rel="stylesheet" href="../style/style.css">

</head>

<body>

    <header>

        <h1>🐾 PetShop</h1>

        <nav>
            <a href="../index.php">Início</a>
            <a href="create.php">Cadastrar Pet</a>
            <a href="select.php">Ver Pets</a>
            <a href="select_w.php">Consultar Pet</a>
            <a href="../login/logout.php">Sair</a>
        </nav>

    </header>

    <main>

        <h2>Consultar Pet</h2>

        <form method="POST">

            <label>Digite o ID do pet:</label>

            <br><br>

            <input type="number" name="id" required>

            <br><br>

            <button type="submit">Consultar</button>

        </form>

        <br>

        <?php if ($pet) { ?>

            <h2>Pet encontrado!</h2>

            <p>
                <strong>ID:</strong>
                <?php echo $pet["id"]; ?>
            </p>

            <p>
                <strong>Nome:</strong>
                <?php echo $pet["nome"]; ?>
            </p>

            <p>
                <strong>Espécie:</strong>
                <?php echo $pet["especie"]; ?>
            </p>

            <p>
                <strong>Raça:</strong>
                <?php echo $pet["raca"]; ?>
            </p>

            <p>
                <strong>Idade:</strong>
                <?php echo $pet["idade"]; ?>
            </p>

            <p>
                <strong>Dono:</strong>
                <?php echo $pet["dono"]; ?>
            </p>

        <?php } elseif ($_SERVER["REQUEST_METHOD"] == "POST") { ?>

            <p>Pet não encontrado.</p>

        <?php } ?>

    </main>

</body>

</html>