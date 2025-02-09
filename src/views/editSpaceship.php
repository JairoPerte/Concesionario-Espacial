<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar <?= htmlspecialchars($nave['name']) ?></title>
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="/img/icon/Infinity&Beyond-logo.jpg" type="image/x-icon">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Introduce los datos de la nave espacial</h1>
        <!-- El formulario envía los datos a "procesar.php" -->
        <form action="/spaceships/<?= $nave['id'] ?>/edit" method="post">

            <!-- Campo: name (Nombre) -->
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" class="form-control" maxlength="25" value="<?= htmlspecialchars($nave['name']) ?>" required>
            </div>

            <!-- Campo: speed (Velocidad, entero sin signo) -->
            <div class="form-group">
                <label for="speed">Velocidad:</label>
                <input type="number" name="speed" id="speed" class="form-control" min="0" step="1" value="<?= htmlspecialchars($nave['speed']) ?>" required>
            </div>

            <!-- Campo: creddits (Créditos, BIGINT sin signo) -->
            <div class="form-group">
                <label for="creddits">Créditos:</label>
                <input type="number" name="creddits" id="creddits" class="form-control" min="0" step="1" value="<?= htmlspecialchars($nave['creddits']) ?>" required>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="true" id="sale" name="sale" />
                <label class="form-check-label" for="sale">¿Poner a la venta?</label>
            </div>

            <?php if (isset($errores)): foreach ($errores as $error): ?>
                    <p style="color: red;"><?= $error ?></p>
            <?php endforeach;
            endif; ?>

            <button type="submit" class="btn btn-primary">Editar</button>
        </form>
    </div>

    <!-- JavaScript de Bootstrap (opcional, para funcionalidades adicionales) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>