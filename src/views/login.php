<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/css/login.css">
    <link rel="shortcut icon" href="/img/icon/Infinity&Beyond-logo.jpg" type="image/x-icon">
</head>

<body>
    <div id="card">
        <a href="/"><img src="/img/icon/Infinity&Beyond-logo.jpg" alt="logo Infinity" class="icono"></a>
        <h2>Inicio Sesión</h2>
        <form action="/login" method="POST">
            <label class="input">
                <input class="input_field" type="email" required placeholder=" " name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                <span class="input_label">Email</span>
            </label>
            <label class="input">
                <input class="input_field" type="password" required placeholder=" " name="password" />
                <span class="input_label">Contraseña</span>
            </label>
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                <div class="error-box">
                    <span class="icon">✖</span>
                    <span>La contraseña o email no es correcta.</span>
                </div>
            <?php endif; ?>
            <button type="submit">Iniciar Sesión</button>
            <div class="button-group">
                <a href="#">¿Has olvidado la contraseña?</a>
                <a href="/register">¿No estás registrado?</a>
            </div>
        </form>
    </div>
    <div id="image_right"></div>
</body>

</html>