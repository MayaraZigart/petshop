<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

// Adicionar produto ao carrinho
if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "SELECT * FROM produtos WHERE id = $1";

    $resultado = pg_query_params(
        $conn,
        $sql,
        [$id]
    );

    if ($resultado && pg_num_rows($resultado) > 0) {

        $produto = pg_fetch_assoc($resultado);

        if ($produto["estoque"] > 0) {

            if (isset($_SESSION["carrinho"][$id])) {
                $_SESSION["carrinho"][$id]++;
            } else {
                $_SESSION["carrinho"][$id] = 1;
            }
        }
    }

    header("Location: carrinho.php");
    exit;
}


// Remover produto
if (isset($_GET["remover"])) {

    $id = $_GET["remover"];

    unset($_SESSION["carrinho"][$id]);

    header("Location: carrinho.php");
    exit;
}


// Finalizar compra
if (isset($_POST["finalizar_compra"])) {

    if (empty($_SESSION["carrinho"])) {

        header("Location: carrinho.php");
        exit;
    }

    // Buscar o ID do usuário pelo e-mail da sessão
    $email = $_SESSION["usuario"];

    $sqlUsuario = "
        SELECT id
        FROM usuarios
        WHERE email = $1
    ";

    $resultadoUsuario = pg_query_params(
        $conn,
        $sqlUsuario,
        [$email]
    );

    if (!$resultadoUsuario || pg_num_rows($resultadoUsuario) == 0) {

        echo "Usuário não encontrado.";
        exit;
    }

    $usuario = pg_fetch_assoc($resultadoUsuario);
    $usuarioId = $usuario["id"];


    // Começar uma transação
    pg_query($conn, "BEGIN");

    $total = 0;
    $produtosCompra = [];


    // Conferir produtos e estoque
    foreach ($_SESSION["carrinho"] as $id => $quantidade) {

        $sqlProduto = "
            SELECT *
            FROM produtos
            WHERE id = $1
            FOR UPDATE
        ";

        $resultadoProduto = pg_query_params(
            $conn,
            $sqlProduto,
            [$id]
        );

        if (!$resultadoProduto || pg_num_rows($resultadoProduto) == 0) {

            pg_query($conn, "ROLLBACK");

            echo "Produto não encontrado.";
            exit;
        }

        $produto = pg_fetch_assoc($resultadoProduto);

        // Verificar estoque
        if ($produto["estoque"] < $quantidade) {

            pg_query($conn, "ROLLBACK");

            echo "
                <p>
                    Estoque insuficiente para o produto:
                    " . htmlspecialchars($produto["nome"]) . "
                </p>

                <a href='carrinho.php'>
                    Voltar ao carrinho
                </a>
            ";

            exit;
        }

        $subtotal = $produto["preco"] * $quantidade;

        $total += $subtotal;

        $produtosCompra[] = [
            "id" => $produto["id"],
            "quantidade" => $quantidade,
            "preco" => $produto["preco"],
            "estoque" => $produto["estoque"]
        ];
    }


    // Criar a compra
    $sqlCompra = "
        INSERT INTO compras
        (usuario_id, valor_total, status)
        VALUES ($1, $2, $3)
        RETURNING id
    ";

    $resultadoCompra = pg_query_params(
        $conn,
        $sqlCompra,
        [
            $usuarioId,
            $total,
            "Finalizada"
        ]
    );

    if (!$resultadoCompra) {

        pg_query($conn, "ROLLBACK");

        echo "Erro ao registrar a compra.";
        exit;
    }

    $compra = pg_fetch_assoc($resultadoCompra);

    $compraId = $compra["id"];


    // Registrar os produtos da compra
    foreach ($produtosCompra as $item) {

        $sqlItem = "
            INSERT INTO itens_compra
            (compra_id, produto_id, quantidade, preco)
            VALUES ($1, $2, $3, $4)
        ";

        $resultadoItem = pg_query_params(
            $conn,
            $sqlItem,
            [
                $compraId,
                $item["id"],
                $item["quantidade"],
                $item["preco"]
            ]
        );

        if (!$resultadoItem) {

            pg_query($conn, "ROLLBACK");

            echo "Erro ao registrar os produtos da compra.";
            exit;
        }


        // Diminuir o estoque
        $novoEstoque = $item["estoque"] - $item["quantidade"];

        $sqlEstoque = "
            UPDATE produtos
            SET estoque = $1
            WHERE id = $2
        ";

        $resultadoEstoque = pg_query_params(
            $conn,
            $sqlEstoque,
            [
                $novoEstoque,
                $item["id"]
            ]
        );

        if (!$resultadoEstoque) {

            pg_query($conn, "ROLLBACK");

            echo "Erro ao atualizar o estoque.";
            exit;
        }
    }


    // Confirmar a transação
    pg_query($conn, "COMMIT");


    // Limpar carrinho
    $_SESSION["carrinho"] = [];

    $compraFinalizada = true;
}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Carrinho - PetShop</title>

    <link
        rel="stylesheet"
        href="../style/style.css"
    >

</head>

<body>

<header>

    <h1>🐾 PetShop</h1>

    <nav>

        <a href="../index.php">
            Início
        </a>

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

    <?php if (isset($compraFinalizada)) { ?>

        <h2>🎉 Compra realizada com sucesso!</h2>

        <p>
            Obrigado pela sua compra!
        </p>

        <p>
            Seu pedido foi registrado no sistema.
        </p>

        <a href="produto_select.php">

            <button type="button">
                🛍️ Continuar Comprando
            </button>

        </a>

    <?php } else { ?>

        <h2>🛒 Meu Carrinho</h2>


        <?php if (empty($_SESSION["carrinho"])) { ?>

            <p>
                Seu carrinho está vazio.
            </p>

            <a href="produto_select.php">

                <button type="button">
                    🛍️ Ver Produtos
                </button>

            </a>

        <?php } else { ?>

            <?php

            $total = 0;

            foreach ($_SESSION["carrinho"] as $id => $quantidade) {

                $sql = "
                    SELECT *
                    FROM produtos
                    WHERE id = $1
                ";

                $resultado = pg_query_params(
                    $conn,
                    $sql,
                    [$id]
                );

                if (
                    $resultado &&
                    pg_num_rows($resultado) > 0
                ) {

                    $produto = pg_fetch_assoc($resultado);

                    $subtotal =
                        $produto["preco"] * $quantidade;

                    $total += $subtotal;

            ?>

                    <div class="produto">

                        <?php if (!empty($produto["imagem"])) { ?>

                            <img
                                src="../uploads/produtos/<?php
                                    echo htmlspecialchars(
                                        $produto["imagem"]
                                    );
                                ?>"
                                alt="<?php
                                    echo htmlspecialchars(
                                        $produto["nome"]
                                    );
                                ?>"
                                class="foto-produto"
                            >

                        <?php } ?>


                        <h3>
                            <?php
                                echo htmlspecialchars(
                                    $produto["nome"]
                                );
                            ?>
                        </h3>


                        <p>
                            Quantidade:
                            <?php echo $quantidade; ?>
                        </p>


                        <p>
                            Preço:
                            R$
                            <?php
                                echo number_format(
                                    $produto["preco"],
                                    2,
                                    ",",
                                    "."
                                );
                            ?>
                        </p>


                        <p>
                            Subtotal:
                            R$
                            <?php
                                echo number_format(
                                    $subtotal,
                                    2,
                                    ",",
                                    "."
                                );
                            ?>
                        </p>


                        <a
                            href="carrinho.php?remover=<?php
                                echo $id;
                            ?>"
                        >

                            <button type="button">
                                ❌ Remover
                            </button>

                        </a>

                    </div>

            <?php

                }
            }

            ?>


            <h2>

                Total:

                R$

                <?php

                    echo number_format(
                        $total,
                        2,
                        ",",
                        "."
                    );

                ?>

            </h2>


            <a href="produto_select.php">

                <button type="button">
                    🛍️ Continuar Comprando
                </button>

            </a>


            <form method="POST">

                <button
                    type="submit"
                    name="finalizar_compra"
                >
                    ✅ Finalizar Compra
                </button>

            </form>


        <?php } ?>

    <?php } ?>

</main>

</body>

</html>