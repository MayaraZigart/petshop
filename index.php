<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PetShop</title>

    <link rel="stylesheet" href="style/style.css">
</head>

<body>

    <header>
        <h1>🐾 PetShop</h1>

        <nav>
           <nav>
        <a href="index.php">Início</a>
        <a href="app/create.php">Cadastrar Pet</a>
        <a href="app/select.php">Ver Pets</a>
        <a href="servicos/select.php">Serviços</a>
        <a href="agenda/create.php">Agendar</a>
        <a href="agenda/select.php">Agenda</a>
        <a href="login/logout.php">Sair</a>
        <a href="produtos/select.php">Produtos e Brinquedos</a>
</nav>
        </nav>
    </header>

    <main>

        <h2>Bem-vindo ao PetShop!</h2>

  <?php if (isset($_SESSION["usuario"])) { ?>

    <p>
        Usuário logado:
        <?php echo $_SESSION["usuario"]; ?>
    </p>

<?php } ?>

        <p>
            Sistema para cadastro e gerenciamento dos pets.
        </p>

        <div>
        <a href="app/create.php">🐶 Cadastrar Pet</a>
        <a href="app/select.php">🐾 Ver Pets</a>
        <a href="app/select_w.php">🔎 Consultar Pet</a>
        </div>

    </main>

    

</body>

</html>