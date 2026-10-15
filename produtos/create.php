<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $categoria = $_POST["categoria"];
    $preco = $_POST["preco"];
    $estoque = $_POST["estoque"];

    $sql = "INSERT INTO produtos (nome, categoria, preco, estoque)
            VALUES ($1, $2, $3, $4)";

    $resultado = pg_query_params(
        $conn,
        $sql,
        [$nome, $categoria, $preco, $estoque]
    );

    if ($resultado) {
        echo "Produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar produto.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

<header>

    <h1>🐾 PetShop</h1>

    <nav>
        <a href="../index.php">Início</a>
        <a href="create.php">Cadastrar Produto</a>
        <a href="select.php">Produtos</a>
        <a href="../login/logout.php">Sair</a>
    </nav>

</header>

<main>

    <h2>🛍️ Cadastrar Produto</h2>

    <form method="POST">

        <label>Nome do produto:</label>
        <br>
        <input type="text" name="nome" required>

        <br><br>

        <label>Categoria:</label>
        <br>
        <input type="text" name="categoria" placeholder="Ex: Ração" required>

        <br><br>

        <label>Preço:</label>
        <br>
        <input type="number" name="preco" step="0.01" min="0" required>

        <br><br>

        <label>Quantidade em estoque:</label>
        <br>
        <input type="number" name="estoque" min="0" required>

        <br><br>

        <button type="submit">Cadastrar Produto</button>

    </form>

</main>

</body>

</html>