<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login-container">
        <?php
        session_start();
        if (isset($_GET['erro'])) {
        ?>
            <div class="error-message">
                Usuário ou senha inválido
            </div>
        <?php
        }
        ?>
        <form action="autenticar.php" method="post">
            <div class="campos">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <br>
        <a href="site.php">Voltar para a Loja</a>
    </div>
</body>

</html>