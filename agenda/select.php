<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

$sql = "SELECT * FROM agenda
        ORDER BY data, horario";

$resultado = pg_query($conn, $sql);

if (!$resultado) {
    die("Erro ao buscar a agenda.");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - PetShop</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

<header>

    <h1>🐾 PetShop</h1>

    <nav>
        <a href="../index.php">Início</a>
        <a href="../servicos/select.php">Serviços</a>
        <a href="create.php">Agendar</a>
        <a href="select.php">Agenda</a>
        <a href="../login/logout.php">Sair</a>
    </nav>

</header>

<main>

    <h2>📅 Agenda de Serviços</h2>

    <table>

        <tr>
            <th>Data</th>
            <th>Horário</th>
            <th>Pet</th>
            <th>Dono</th>
            <th>Serviço</th>
        </tr>

        <?php while ($agenda = pg_fetch_assoc($resultado)) { ?>
        <td>
    <?php if (!empty($produto['imagem'])): ?>
        <img src="../uploads/produtos/<?= htmlspecialchars($produto['imagem']) ?>" 
             alt="<?= htmlspecialchars($produto['produto']) ?>"
             class="foto-produto">
    <?php else: ?>
        <span>Sem foto</span>
    <?php endif; ?>
</td>

            <tr>

                <td><?php echo $agenda["data"]; ?></td>

                <td><?php echo $agenda["horario"]; ?></td>

                <td><?php echo $agenda["pet"]; ?></td>

                <td><?php echo $agenda["dono"]; ?></td>

                <td><?php echo $agenda["servico"]; ?></td>

                <th>Foto</th>

            </tr>

        <?php } ?>

    </table>

</main>

</body>

</html>