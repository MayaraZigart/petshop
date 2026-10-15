<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pet = $_POST["pet"];
    $dono = $_POST["dono"];
    $servico = $_POST["servico"];
    $data = $_POST["data"];
    $horario = $_POST["horario"];

    $sql_verifica = "SELECT * FROM agenda
                     WHERE data = $1
                     AND horario = $2";

    $verifica = pg_query_params(
        $conn,
        $sql_verifica,
        [$data, $horario]
    );

    if (pg_num_rows($verifica) > 0) {

        echo "Esse horário já está ocupado! Escolha outro horário.";

    } else {

        $sql = "INSERT INTO agenda (pet, dono, servico, data, horario)
                VALUES ($1, $2, $3, $4, $5)";

        $resultado = pg_query_params(
            $conn,
            $sql,
            [$pet, $dono, $servico, $data, $horario]
        );

        if ($resultado) {
            echo "Horário marcado com sucesso!";
        } else {
            echo "Erro ao marcar o horário.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Banho</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

<header>

    <h1>🐾 PetShop</h1>

    <nav>
        <a href="../index.php">Início</a>
        <a href="create.php">Agendar</a>
        <a href="select.php">Agenda</a>
        <a href="../login/logout.php">Sair</a>
    </nav>

</header>

<main>

    <h2>📅 Agendar serviço</h2>

    <form method="POST">

        <label>Nome do pet:</label>
        <br>
        <input type="text" name="pet" required>

        <br><br>

        <label>Nome do dono:</label>
        <br>
        <input type="text" name="dono" required>

        <br><br>

        <label>Serviço:</label>
        <br>

       <select name="servico" required>

    <option value="">Selecione o serviço</option>

    <option value="Banho"
        <?php if (isset($_GET["servico"]) && $_GET["servico"] == "Banho") echo "selected"; ?>>
        Banho
    </option>

    <option value="Banho e Tosa"
        <?php if (isset($_GET["servico"]) && $_GET["servico"] == "Banho e Tosa") echo "selected"; ?>>
        Banho e Tosa
    </option>

    <option value="Tosa"
        <?php if (isset($_GET["servico"]) && $_GET["servico"] == "Tosa") echo "selected"; ?>>
        Tosa
    </option>

    <option value="Hidratação"
        <?php if (isset($_GET["servico"]) && $_GET["servico"] == "Hidratação") echo "selected"; ?>>
        Hidratação
    </option>

</select>

        <br><br>

        <label>Data:</label>
        <br>
        <input type="date" name="data" required>

        <br><br>

        <label>Horário:</label>
        <br>
        <input type="time" name="horario" required>

        <br><br>

        <button type="submit">Agendar</button>

    </form>

</main>

</body>

</html>