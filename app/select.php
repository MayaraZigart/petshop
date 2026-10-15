<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

$sql = "SELECT * FROM pets ORDER BY data_banho, horario";

$resultado = pg_query($conn, $sql);

if (!$resultado) {
    die("Erro ao buscar os agendamentos.");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Banhos agendados</title>

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

        <h2>🛁 Banhos agendados</h2>

        <table border="1">

            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Nome</th>
                <th>Espécie</th>
                <th>Raça</th>
                <th>Idade</th>
                <th>Dono</th>
                <th>Telefone</th>
                <th>Data do banho</th>
                <th>Horário</th>
                <th>Observações</th>
                <th>Ações</th>
            </tr>

            <?php while ($pet = pg_fetch_assoc($resultado)) { ?>

                <tr>

                    <td>
                        <?php echo $pet["id"]; ?>
                    </td>

                    <td>

                        <?php if (!empty($pet["imagem"])) { ?>

                            <img
                                src="../uploads/pets/<?php echo htmlspecialchars($pet["imagem"]); ?>"
                                alt="Foto de <?php echo htmlspecialchars($pet["nome"]); ?>"
                                class="foto-pet"
                            >

                        <?php } else { ?>

                            🐾 Sem foto

                        <?php } ?>

                    </td>

                    <td>
                        <?php echo htmlspecialchars($pet["nome"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($pet["especie"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($pet["raca"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($pet["idade"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($pet["dono"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($pet["telefone"]); ?>
                    </td>

                    <td>

                        <?php
                        if (!empty($pet["data_banho"])) {
                            echo date("d/m/Y", strtotime($pet["data_banho"]));
                        }
                        ?>

                    </td>

                    <td>

                        <?php
                        if (!empty($pet["horario"])) {
                            echo date("H:i", strtotime($pet["horario"]));
                        }
                        ?>

                    </td>

                    <td>
                        <?php echo htmlspecialchars($pet["observacoes"]); ?>
                    </td>

                    <td>

                        <a href="update.php?id=<?php echo $pet["id"]; ?>">
                            Editar
                        </a>

                        <br>

                        <a
                            href="delete.php?id=<?php echo $pet["id"]; ?>"
                            onclick="return confirm('Tem certeza que deseja excluir este agendamento?');"
                        >
                            Excluir
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </table>

    </main>

</body>

</html>