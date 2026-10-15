<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços - PetShop</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

<header>

    <h1>🐾 PetShop</h1>

    <nav>
        <a href="../index.php">Início</a>
        <a href="select.php">Serviços</a>
        <a href="../agenda/create.php">Agendar</a>
        <a href="../login/logout.php">Sair</a>
    </nav>

</header>

<main>

    <h2>🛁 Nossos Serviços</h2>

    <div class="servicos">

        <div class="servico">
            <h3>🛁 Banho</h3>
            <p>Higiene completa para o seu pet.</p>
            <strong>R$ 40,00</strong>
            <br><br>
            <a href="../agenda/create.php?servico=Banho">Marcar horário</a>
        </div>

        <div class="servico">
            <h3>✂️ Banho + Tosa</h3>
            <p>Banho e tosa completa.</p>
            <strong>R$ 70,00</strong>
            <br><br>
            <a href="../agenda/create.php?servico=Banho%20e%20Tosa">Marcar horário</a>
        </div>

        <div class="servico">
            <h3>✂️ Tosa</h3>
            <p>Tosa para deixar seu pet limpinho.</p>
            <strong>R$ 45,00</strong>
            <br><br>
            <a href="../agenda/create.php?servico=Tosa">Marcar horário</a>
        </div>

        <div class="servico">
            <h3>🧴 Hidratação</h3>
            <p>Hidratação especial para os pelos.</p>
            <strong>R$ 30,00</strong>
            <br><br>
           <a href="../agenda/create.php?servico=Hidratação">Marcar horário</a>
        </div>

    </div>

</main>

</body>
</html>