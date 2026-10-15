<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $categoria = $_POST["categoria"];
    $preco = $_POST["preco"];
    $estoque = $_POST["estoque"];

    $imagem = "";

    // Upload da foto
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {

        $nomeArquivo = $_FILES["imagem"]["name"];
        $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

        $extensoesPermitidas = ["jpg", "jpeg", "png", "gif", "webp"];

        if (in_array($extensao, $extensoesPermitidas)) {

            $novoNome = uniqid() . "." . $extensao;

            $pasta = "../uploads/produtos/";

            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true);
            }

            $caminho = $pasta . $novoNome;

            if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho)) {

                $imagem = $novoNome;

            } else {

                echo "Erro ao salvar a imagem.";
            }

        } else {

            echo "Formato de imagem não permitido.";
        }
    }

    $sql = "INSERT INTO produtos
            (nome, categoria, preco, estoque, imagem)
            VALUES ($1, $2, $3, $4, $5)";

    $resultado = pg_query_params(
        $conn,
        $sql,
        [
            $nome,
            $categoria,
            $preco,
            $estoque,
            $imagem
        ]
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

        <a href="produto_create.php">
            Cadastrar Produto
        </a>

        <a href="produto_select.php">
            Produtos
        </a>

        <a href="carrinho.php">
            🛒 Carrinho
        </a>

        <a href="../login/logout.php">
            Sair
        </a>

    </nav>

</header>

<main>

    <h2>🛍️ Cadastrar Produto</h2>

    <form
        method="POST"
        enctype="multipart/form-data"
    >

        <label>Nome do produto:</label>

        <input
            type="text"
            name="nome"
            required
        >

        <label>Categoria:</label>

        <input
            type="text"
            name="categoria"
            placeholder="Ex: Ração ou Brinquedo"
            required
        >

        <label>Preço:</label>

        <input
            type="number"
            name="preco"
            step="0.01"
            min="0"
            required
        >

        <label>Quantidade em estoque:</label>

        <input
            type="number"
            name="estoque"
            min="0"
            required
        >

        <label>Foto do produto:</label>

        <input
            type="file"
            name="imagem"
            accept="image/*"
        >

        <button type="submit">
            🛍️ Cadastrar Produto
        </button>

    </form>

</main>

</body>

</html>