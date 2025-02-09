<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Email</title>
    <link rel="shortcut icon" href="/img/icon/Infinity&Beyond-logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="/css/verificarEmail.css">
    <script src="/js/verificarEmail.js"></script>
</head>

<body>
    <div class="container">
        <h2>¡Bienvenido, <span id="persona"><?= htmlspecialchars($user_nickname) ?></span>!</h2>
        <p>Solo estás a un paso para iniciar tu cuenta. Introduce el código recibido por correo.</p>
        <form id="verification-form" method="POST" action="/email-verify">
            <div class="code-input">
                <input type="text" maxlength="1">
                <input type="text" maxlength="1">
                <input type="text" maxlength="1">
                <input type="text" maxlength="1">
                <input type="text" maxlength="1">
            </div>
            <input type="hidden" name="verification_code" id="hidden-code">
            <button type="submit" class="verify-btn">Verificar Email</button>
        </form>
        <p class="error-message" style="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo "display: block;" ?>">El código introducido es incorrecto. Inténtalo de nuevo.</p>
        <p class="resend">¿No te ha llegado un código? <a href="#">Enviar otro código</a>. ¿Sigues aún sin recibir el correo? <a href="/logout">¿Te habrás equivocado de email?</a></p>
    </div>
</body>

</html>