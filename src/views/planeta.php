<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planeta</title>
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
            <h1 class="display-4 text-center text-primary">🌍 <?= htmlspecialchars($planeta['name']) ?></h1>
            <p class="fs-5"><strong class="text-info">Sistema:</strong> <?= htmlspecialchars($planeta['system']) ?></p>
            <p class="fs-5"><strong class="text-info">Número de lunas:</strong> <?= htmlspecialchars($planeta['moons']) ?></p>
            <p class="fs-5"><strong class="text-info">Área:</strong> <?= htmlspecialchars($planeta['area']) ?> km2</p>
            <p class="fs-5"><strong class="text-info">Habitable:</strong> <?= htmlspecialchars($planeta['habitable'] == 1 ? "Si" : "No") ?></p>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>