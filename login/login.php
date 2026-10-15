<?php

session_start();

require_once "../database/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios
            WHERE email = $1 AND senha = $2";

    $resultado = pg_query_params(
        $conn,
        $sql,
        [$email, $senha]
    );

    if (pg_num_rows($resultado) > 0) {

        $usuario = pg_fetch_assoc($resultado);

        $_SESSION["usuario"] = $usuario["email"];

        header("Location: ../index.php");
        exit;

    } else {

        echo "E-mail ou senha incorretos.";

    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - PetShop</title>

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

        <h2>Login</h2>

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
                Entrar
            </button>

        </form>

    </main>

</body>

</html>