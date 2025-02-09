<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planetarium</title>
    <link rel="stylesheet" href="/css/basic.css">
    <link rel="shortcut icon" href="/img/icon/Infinity&Beyond-logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="/css/spaceships.css">
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
        <div class="contenedor">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Sistema</th>
                        <th>Num. Lunas</th>
                        <th>Área</th>
                        <th>¿Es habitable?</th>
                    </tr>
                </thead>
                <tbody id="tabla-body">
                    <?php if (isset($planetarium)):
                        foreach ($planetarium as $planeta): ?>
                            <tr>
                                <td><a href="/planetarium/<?= htmlspecialchars($planeta["id"]) ?>"><?= htmlspecialchars($planeta["name"]) ?></a></td>
                                <td><?= htmlspecialchars($planeta["system"]) ?></td>
                                <td><?= htmlspecialchars($planeta["moons"]) ?></td>
                                <td><?= htmlspecialchars($planeta["area"]) ?></td>
                                <td><?= htmlspecialchars($planeta["habitable"] == 1 ? "Si" : "No") ?></td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>