<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "DELETE FROM pets WHERE id = $1";

    $resultado = pg_query_params(
        $conn,
        $sql,
        [$id]
    );

    if ($resultado) {
        header("Location: select.php");
        exit;
    } else {
        echo "Erro ao excluir o agendamento.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];

    $sql = "DELETE FROM pets WHERE id = $1";

    $resultado = pg_query_params(
        $conn,
        $sql,
        [$id]
    );

    if ($resultado) {
        header("Location: select.php");
        exit;
    } else {
        echo "Erro ao excluir o agendamento.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Excluir Agendamento</title>

    <link rel="stylesheet" href="../style/style.css">

</head>

<body>

    <header>

        <h1>🐾 PetShop</h1>

        <nav>

            <a href="../index.php">Início</a>

            <a href="create.php">Agendar Banho</a>

            <a href="select.php">Banhos Agendados</a>

            <a href="../login/logout.php">Sair</a>

        </nav>

    </header>

    <main>

        <h2>Excluir Agendamento</h2>

        <form method="POST">

            <label>Digite o ID do agendamento:</label>

            <input
                type="number"
                name="id"
                min="1"
                required
            >

            <button type="submit">
                Excluir Agendamento
            </button>

        </form>

    </main>

</body>

</html>