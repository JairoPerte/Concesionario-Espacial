<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nave Espacial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/basic.css">
    <link rel="shortcut icon" href="/img/icon/Infinity&Beyond-logo.jpg" type="image/x-icon">
</head>

<body class="bg-dark text-light">
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
    <main class="container py-5">
        <div class="card bg-secondary text-white shadow-lg p-4">
            <h1 class="display-4 text-center text-primary">🚀 <?= htmlspecialchars($nave['name']) ?></h1>
            <p class="fs-5"><strong class="text-info">Matrícula:</strong> <?= htmlspecialchars($nave['license_plate']) ?></p>
            <p class="fs-5"><strong class="text-info">Velocidad:</strong> <?= htmlspecialchars($nave['speed']) ?> km/h</p>
            <p class="fs-5"><strong class="text-info">Compañía:</strong> <?= htmlspecialchars($nave['company_name']) ?></p>
            <p class="fs-5"><strong class="text-warning">Precio:</strong> <span class="text-warning"><?= htmlspecialchars($nave['creddits']) ?> Créditos Espaciales</span></p>

            <?php if (isset($nave['Planet_id'])): ?>
                <p class="fs-5" id="planeta"><strong class="text-primary">Planeta:</strong> <a href="/planetarium/<?= htmlspecialchars($nave['Planet_id']) ?>" class="text-light text-decoration-none">🌍 <?= htmlspecialchars($nave['planet_name']) ?></a></p>
            <?php endif; ?>

            <?php if (isset($nave['User_id'])): ?>
                <p class="fs-5" id="usuario"><strong class="text-success">Propietario:</strong> <a href="/profile/<?= htmlspecialchars($nave['User_id']) ?>" class="text-light text-decoration-none">👨‍🚀 <?= htmlspecialchars($nave['user_nickname']) ?></a></p>
            <?php endif; ?>

            <?php if ($nave['sale'] == 1 && (isset($sesion["user_id"]) && ($nave["User_id"] == null || $sesion["user_id"] != $nave['User_id']))): ?>
                <form action="/spaceships/<?= htmlspecialchars($nave['id']) ?>/buy" method="POST">
                    <button id="comprar" class="btn btn-lg btn-primary w-100 mt-3 fw-bold">
                        🛒 Comprar
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>