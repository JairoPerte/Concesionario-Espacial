<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="/css/login.css">
    <link rel="shortcut icon" href="/img/icon/Infinity&Beyond-logo.jpg" type="image/x-icon">
</head>

<body>
    <div id="card">
        <a href="/"><img src="/img/icon/Infinity&Beyond-logo.jpg" alt="logo Infinity" class="icono"></a>
        <h2>Registro</h2>
        <form action="/register" method="POST">
            <label class="input">
                <input class="input_field" type="text" required placeholder=" " name="nickname" value="<?php echo isset($_POST['nickname']) ? htmlspecialchars($_POST['nickname']) : ''; ?>" />
                <span class="input_label">Nickname</span>
            </label>
            <?php if (!empty($NICKNAME_BAD_FORMATED)): ?>
                <div class="error-box">
                    <span class="icon">✖</span>
                    <span><?= htmlspecialchars($NICKNAME_BAD_FORMATED); ?></span>
                </div>
            <?php endif; ?>
            <?php if (!empty($NICKNAME_EXISTENTE)): ?>
                <div class="error-box">
                    <span class="icon">✖</span>
                    <span><?php echo htmlspecialchars($NICKNAME_EXISTENTE); ?></span>
                </div>
            <?php endif; ?>
            <label class="input">
                <input class="input_field" type="email" required placeholder=" " name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                <span class="input_label">Email</span>
            </label>
            <?php if (!empty($EMAIL_BAD_FORMATED)): ?>
                <div class="error-box">
                    <span class="icon">✖</span>
                    <span><?php echo htmlspecialchars($EMAIL_BAD_FORMATED); ?></span>
                </div>
            <?php endif; ?>
            <?php if (!empty($EMAIL_EXISTENTE)): ?>
                <div class="error-box">
                    <span class="icon">✖</span>
                    <span><?php echo htmlspecialchars($EMAIL_EXISTENTE); ?></span>
                </div>
            <?php endif; ?>
            <label class="input">
                <input class="input_field" type="password" required placeholder=" " name="password" />
                <span class="input_label">Contraseña</span>
            </label>
            <?php if (!empty($PASSWORD_BAD_FORMATED)): ?>
                <div class="error-box">
                    <span class="icon">✖</span>
                    <span><?php echo htmlspecialchars($PASSWORD_BAD_FORMATED); ?></span>
                </div>
            <?php endif; ?>
            <button>Registrarse</button>
            <div class="button-group">
                <a href="/login">¿Ya has iniciado sesión con anterioridad?</a>
            </div>
        </form>
    </div>
    <div id="image_right"></div>
</body>

</html>