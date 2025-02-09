<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/css/basic.css">
    <link rel="stylesheet" href="/css/home.css">
    <link rel="shortcut icon" href="/img/icon/Infinity&Beyond-logo.jpg" type="image/x-icon">
</head>

<body>
    <header>
        <nav>
            <a href="/">Página Principal</a>
            <a href="/spaceships">Naves Espaciales</a>
            <a href="/planetarium">Planetarium</a>
            <?php if (!isset($sesion)): ?>
                <div id="iniciar_sesion">
                    <a href="/register" class="pendiente_sesion">Regristrarse</a>
                    <a> o </a>
                    <a href="/login" class="pendiente_sesion">¿Ya tienes una cuenta creada?</a>
                </div>
            <?php else: ?>
                <a href="/creddits">Comprar Créditos</a>
                <a href="/profile/<?= htmlspecialchars($sesion["user_id"]) ?>"><?= $sesion["user_nickname"] ?></a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <video class="video-fondo" autoplay loop muted>
            <source src="/video/space_loop.mp4" type="video/mp4">
            Tu navegador no soporta el elemento de video.
        </video>
        <div class="contenido-texto">
            <h1 class="title">
                <span class="title-word title-word-1">Infinity</span>
                <span class="title-word title-word-2">&</span>
                <span class="title-word title-word-3">Beyond</span>
            </h1>
            <h3>¿Estás listo para conquistar el universo?</h3>
        </div>
    </main>
</body>

</html>