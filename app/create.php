<?php

require_once "../database/connect.php";
require_once "../login/verifica_user.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $especie = $_POST["especie"];
    $raca = $_POST["raca"];
    $idade = $_POST["idade"];
    $dono = $_POST["dono"];
    $telefone = $_POST["telefone"];
    $data_banho = $_POST["data_banho"];
    $horario = $_POST["horario"];
    $observacoes = $_POST["observacoes"];

    $imagem = "";

    // Verificar se a data não está no passado
    if ($data_banho < date("Y-m-d")) {

        $mensagem = "❌ Não é possível agendar um banho para uma data passada.";

    } else {

        // Verificar se o horário já está ocupado
        $sqlHorario = "
            SELECT id
            FROM pets
            WHERE data_banho = $1
            AND horario = $2
        ";

        $resultadoHorario = pg_query_params(
            $conn,
            $sqlHorario,
            [
                $data_banho,
                $horario
            ]
        );

        if (
            $resultadoHorario &&
            pg_num_rows($resultadoHorario) > 0
        ) {

            $mensagem = "❌ Esse horário já está ocupado. Escolha outro horário.";

        } else {

            // Upload da foto
            if (
                isset($_FILES["imagem"]) &&
                $_FILES["imagem"]["error"] == 0
            ) {

                $nomeArquivo = $_FILES["imagem"]["name"];

                $extensao = strtolower(
                    pathinfo(
                        $nomeArquivo,
                        PATHINFO_EXTENSION
                    )
                );

                $extensoesPermitidas = [
                    "jpg",
                    "jpeg",
                    "png",
                    "gif",
                    "webp"
                ];

                if (
                    in_array(
                        $extensao,
                        $extensoesPermitidas
                    )
                ) {

                    $novoNome =
                        uniqid() . "." . $extensao;

                    $pasta = "../uploads/pets/";

                    if (!is_dir($pasta)) {

                        mkdir(
                            $pasta,
                            0777,
                            true
                        );
                    }

                    $caminho =
                        $pasta . $novoNome;

                    if (
                        move_uploaded_file(
                            $_FILES["imagem"]["tmp_name"],
                            $caminho
                        )
                    ) {

                        $imagem = $novoNome;

                    } else {

                        $mensagem =
                            "❌ Erro ao salvar a imagem.";
                    }

                } else {

                    $mensagem =
                        "❌ Formato de imagem não permitido.";
                }
            }


            // Cadastrar o banho
            if ($mensagem == "") {

                $sql = "
                    INSERT INTO pets
                    (
                        nome,
                        especie,
                        raca,
                        idade,
                        dono,
                        telefone,
                        data_banho,
                        horario,
                        observacoes,
                        imagem
                    )
                    VALUES
                    (
                        $1,
                        $2,
                        $3,
                        $4,
                        $5,
                        $6,
                        $7,
                        $8,
                        $9,
                        $10
                    )
                ";

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
                        $imagem
                    ]
                );


                if ($resultado) {

                    $mensagem =
                        "✅ Banho agendado com sucesso!";

                } else {

                    $mensagem =
                        "❌ Erro ao agendar o banho.";
                }
            }
        }
    }
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

    <title>Agendar Banho - PetShop</title>

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

    <h2>🛁 Agendar Banho</h2>


    <?php if ($mensagem != "") { ?>

        <p>
            <?php echo htmlspecialchars($mensagem); ?>
        </p>

    <?php } ?>


    <form
        method="POST"
        enctype="multipart/form-data"
    >

        <label>
            Nome do pet:
        </label>

        <input
            type="text"
            name="nome"
            required
        >


        <label>
            Espécie:
        </label>

        <input
            type="text"
            name="especie"
            placeholder="Ex: Cachorro"
            required
        >


        <label>
            Raça:
        </label>

        <input
            type="text"
            name="raca"
            required
        >


        <label>
            Idade:
        </label>

        <input
            type="number"
            name="idade"
            min="0"
            required
        >


        <label>
            Nome do dono:
        </label>

        <input
            type="text"
            name="dono"
            required
        >


        <label>
            Telefone:
        </label>

        <input
            type="text"
            name="telefone"
            placeholder="Ex: (11) 99999-9999"
            required
        >


        <label>
            Data do banho:
        </label>

        <input
            type="date"
            name="data_banho"
            min="<?php echo date('Y-m-d'); ?>"
            required
        >


        <label>
            Horário:
        </label>

        <input
            type="time"
            name="horario"
            required
        >


        <label>
            Observações:
        </label>

        <textarea
            name="observacoes"
            rows="4"
            placeholder="Alguma observação sobre o banho..."
        ></textarea>


        <label>
            Foto do pet:
        </label>

        <input
            type="file"
            name="imagem"
            accept="image/*"
        >


        <button type="submit">
            🛁 Agendar Banho
        </button>

    </form>


    <br>


    <a href="select.php">

        <button type="button">
            📋 Ver Banhos Agendados
        </button>

    </a>

</main>

</body>

</html>