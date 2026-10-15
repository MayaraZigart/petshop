<?php

require_once "../database/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "INSERT INTO usuarios (email, senha)
            VALUES ($1, $2)";

    $resultado = pg_query_params(
        $conn,
        $sql,
        [$email, $senha]
    );

    if ($resultado) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar usuário.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Usuário</title>

    <link rel="stylesheet" href="../style/style.css">

</head>

<body>

    <header>

        <h1>🐾 PetShop</h1>

        <nav>
            <a href="../index.php">Início</a>
            <a href="cadastra.php">Cadastrar Usuário</a>
            <a href="login.php">Login</a>
        </nav>

    </header>

    <main>

        <h2>Cadastrar Usuário</h2>

        <form method="POST">

            <label>E-mail:</label>

            <br>

            <input
                type="email"
                name="email"
                required
            >

            <br><br>

            <label>Senha:</label>

            <br>

            <input
                type="password"
                name="senha"
                required
            >

            <br><br>

            <button type="submit">
                Cadastrar
            </button>

        </form>

    </main>

</body>

</html>