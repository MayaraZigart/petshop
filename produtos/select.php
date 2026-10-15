<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

$sql = "SELECT * FROM produtos ORDER BY id";

$resultado = pg_query($conn, $sql);

if (!$resultado) {
    die("Erro ao buscar os produtos.");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Produtos - PetShop</title>

    <link rel="stylesheet" href="../style/style.css">

</head>

<body>

<header>

    <h1>🐾 PetShop</h1>

    <nav>

        <a href="../index.php">Início</a>

        <a href="../servicos/select.php">Serviços</a>

        <a href="../agenda/create.php">Agendar</a>

        <a href="select.php">Produtos</a>

        <a href="../login/logout.php">Sair</a>

    </nav>

</header>

<main>

    <h2>🛍️ Produtos e Brinquedos</h2>

    <p>Confira nossos produtos disponíveis:</p>

    <table>

        <tr>

            <th>ID</th>
            <th>Produto</th>
            <th>Categoria</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Ações</th>

        </tr>

        <?php while ($produto = pg_fetch_assoc($resultado)) { ?>

        <tr>

            <td>
                <?php echo $produto["id"]; ?>
            </td>

            <td>
                <?php echo $produto["nome"]; ?>
            </td>

            <td>
                <?php echo $produto["categoria"]; ?>
            </td>

            <td>
                R$
                <?php
                echo number_format(
                    $produto["preco"],
                    2,
                    ",",
                    "."
                );
                ?>
            </td>

            <td>
                <?php echo $produto["estoque"]; ?>
            </td>

            <td>

                <a href="update.php?id=<?php echo $produto["id"]; ?>">
                    Editar
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

    <br>

    <a href="create.php">
        ➕ Cadastrar Produto ou Brinquedo
    </a>

</main>

</body>

</html>