<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naves Espaciales</title>
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
                        <th>Matrícula</th>
                        <th>Velocidad</th>
                        <th>Precio</th>
                        <th>¿A la venta?</th>
                        <th>Compañía</th>
                        <th>Planeta</th>
                        <th>Usuario</th>
                        <th>
                            <form action="/spaceships/add" method="get">
                                <button class="button add">
                                    <i class="fas fa-plus"></i> Añadir
                                </button>
                            </form>
                        </th>
                    </tr>
                </thead>
                <tbody id="tabla-body">
                </tbody>
            </table>
            <div class="pagination">
                <button id="prev-page">&laquo;</button>
                <span id="page-info"></span>
                <div class="select-container">
                    <div class="select-display" id="select-display">
                        <span id="selected-limit">10</span>
                        <span class="arrow" id="arrow">&#9660;</span>
                    </div>
                    <ul class="select-options" id="select-options">
                        <li data-value="5">5</li>
                        <li data-value="10">10</li>
                        <li data-value="15">15</li>
                    </ul>
                </div>
                <button id="next-page">&raquo;</button>
            </div>
        </div>
        <div id="sesion-id" data-sesion_id="<?= isset($sesion["user_id"]) ? $sesion["user_id"] : "" ?>"></div>
    </main>
    <!-- Para implementar AJAX -->
    <script src="/js/spaceships.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</body>

</html>