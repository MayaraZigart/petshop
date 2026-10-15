<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

$sql = "SELECT * FROM produtos ORDER BY id DESC";

$resultado = pg_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Produtos - PetShop</title>

    <link rel="stylesheet" href="../style/style.css">

    <style>

        .produtos {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }

        .produto {
            width: 250px;
            padding: 20px;
            text-align: center;
        }

        .foto-produto {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            display: block;
            margin: 0 auto 15px;
        }

    </style>

</head>

<body>

<header>

    <h1>🐾 PetShop</h1>

    <nav>

        <a href="../index.php">Início</a>

        <a href="create.php">
            Agendar Banho
        </a>

        <a href="select.php">
            Banhos Agendados
        </a>

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

    <h2>🛍️ Loja PetShop</h2>

    <div class="produtos">

        <?php while ($produto = pg_fetch_assoc($resultado)) { ?>

            <div class="produto">

                <?php if (!empty($produto["imagem"])) { ?>

                    <img
                        src="../uploads/produtos/<?php echo htmlspecialchars($produto["imagem"]); ?>"
                        alt="<?php echo htmlspecialchars($produto["nome"]); ?>"
                        class="foto-produto"
                    >

                <?php } else { ?>

                    <p>📷 Sem imagem</p>

                <?php } ?>


                <h3>

                    <?php echo htmlspecialchars($produto["nome"]); ?>

                </h3>


                <p>

                    Categoria:

                    <?php echo htmlspecialchars($produto["categoria"]); ?>

                </p>


                <p>

                    💰 R$

                    <?php echo number_format(
                        $produto["preco"],
                        2,
                        ",",
                        "."
                    ); ?>

                </p>


                <p>

                    📦 Estoque:

                    <?php echo $produto["estoque"]; ?>

                </p>


                <?php if ($produto["estoque"] > 0) { ?>

                    <a href="carrinho.php?id=<?php echo $produto["id"]; ?>">

                        <button type="button">

                            🛒 Comprar

                        </button>

                    </a>

                <?php } else { ?>

                    <p>
                        ❌ Produto esgotado
                    </p>

                <?php } ?>

            </div>

        <?php } ?>

    </div>

</main>

</body>

</html>