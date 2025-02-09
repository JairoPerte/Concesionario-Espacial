<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/css/basic.css">
    <link rel="stylesheet" href="/css/perfil.css">
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
        <section class="profile">
            <div class="profile-header">
                <img src="<?= htmlspecialchars($usuario["image"]) ?>" alt="Imagen de perfil" class="profile-img">
            </div>
            <h2 class="username"><?= htmlspecialchars($usuario["nickname"]) ?>
                <?php if (isset($sesion) && $usuario["id"] == $sesion["user_id"]): ?>
                    <a href="/profile/config" class="settings-btn">
                        <i class="fas fa-cog"></i>
                    </a>
                <?php endif; ?>
            </h2>
        </section>

        <hr>

        <section class="spaceships">
            <h3>Mis Naves Espaciales</h3>
            <div id="spaceship-list" class="spaceship-list">
                <!-- Aquí van as naves-->
            </div>
            <div class="pagination">
                <button id="prev-page">&laquo;</button>
                <span id="page-info"></span>
                <button id="next-page">&raquo;</button>
            </div>
        </section>
        <div id="user-id" data-id="<?= $usuario["id"] ?>"></div>
    </main>
    <!-- Para implementar AJAX -->
    <script src="/js/spaceshipsPerfil.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>

</html>