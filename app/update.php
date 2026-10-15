<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

$pet = null;

if (isset($_GET["id"])) {

    $id = $_GET["id"];

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $especie = $_POST["especie"];
    $raca = $_POST["raca"];
    $idade = $_POST["idade"];
    $dono = $_POST["dono"];
    $telefone = $_POST["telefone"];
    $data_banho = $_POST["data_banho"];
    $horario = $_POST["horario"];
    $observacoes = $_POST["observacoes"];

    $sql = "UPDATE pets
            SET nome = $1,
                especie = $2,
                raca = $3,
                idade = $4,
                dono = $5,
                telefone = $6,
                data_banho = $7,
                horario = $8,
                observacoes = $9
            WHERE id = $10";

    $resultado = pg_query_params(
        $conn,
        $sql,
        [
            $nome,
            $especie,
            $raca,
            $idade,
            $dono,
            $telefone,
            $data_banho,
            $horario,
            $observacoes,
            $id
        ]
    );

    if ($resultado) {
        echo "Banho atualizado com sucesso!";

        // Busca os dados novamente depois da atualização
        $sql = "SELECT * FROM pets WHERE id = $1";

        $resultado = pg_query_params(
            $conn,
            $sql,
            [$id]
        );

        if ($resultado) {
            $pet = pg_fetch_assoc($resultado);
        }

    } else {
        echo "Erro ao atualizar o agendamento.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Agendamento</title>

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

    <h2>🛁 Editar Agendamento</h2>

    <?php if ($pet) { ?>

        <form method="POST">

            <input
                type="hidden"
                name="id"
                value="<?php echo $pet["id"]; ?>"
            >

            <label>Nome do pet:</label>

            <input
                type="text"
                name="nome"
                value="<?php echo htmlspecialchars($pet["nome"]); ?>"
                required
            >

            <label>Espécie:</label>

            <input
                type="text"
                name="especie"
                value="<?php echo htmlspecialchars($pet["especie"]); ?>"
                required
            >

            <label>Raça:</label>

            <input
                type="text"
                name="raca"
                value="<?php echo htmlspecialchars($pet["raca"]); ?>"
                required
            >

            <label>Idade:</label>

            <input
                type="number"
                name="idade"
                value="<?php echo htmlspecialchars($pet["idade"]); ?>"
                min="0"
                required
            >

            <label>Nome do dono:</label>

            <input
                type="text"
                name="dono"
                value="<?php echo htmlspecialchars($pet["dono"]); ?>"
                required
            >

            <label>Telefone:</label>

            <input
                type="text"
                name="telefone"
                value="<?php echo htmlspecialchars($pet["telefone"]); ?>"
                required
            >

            <label>Data do banho:</label>

            <input
                type="date"
                name="data_banho"
                value="<?php echo $pet["data_banho"]; ?>"
                required
            >

            <label>Horário:</label>

            <input
                type="time"
                name="horario"
                value="<?php echo $pet["horario"]; ?>"
                required
            >

            <label>Observações:</label>

            <textarea
                name="observacoes"
                rows="4"
            ><?php echo htmlspecialchars($pet["observacoes"]); ?></textarea>

            <button type="submit">
                Atualizar Agendamento
            </button>

        </form>

    <?php } else { ?>

        <p>Agendamento não encontrado.</p>

    <?php } ?>

</main>

</body>

</html>