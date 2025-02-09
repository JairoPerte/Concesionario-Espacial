<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Añadir Nave</title>
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="/img/icon/Infinity&Beyond-logo.jpg" type="image/x-icon">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Introduce los datos de la nave espacial</h1>
        <!-- El formulario envía los datos a "procesar.php" -->
        <form action="/spaceships/add" method="post">
            <!-- Campo: license_plate (Matrícula) -->
            <div class="form-group">
                <label for="license_plate">Matrícula:</label>
                <input type="text" name="license_plate" id="license_plate" class="form-control" maxlength="12" required>
            </div>

            <!-- Campo: name (Nombre) -->
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" class="form-control" maxlength="25" required>
            </div>

            <!-- Campo: speed (Velocidad, entero sin signo) -->
            <div class="form-group">
                <label for="speed">Velocidad:</label>
                <input type="number" name="speed" id="speed" class="form-control" min="0" step="1" required>
            </div>

            <!-- Campo: creddits (Créditos, BIGINT sin signo) -->
            <div class="form-group">
                <label for="creddits">Créditos:</label>
                <input type="number" name="creddits" id="creddits" class="form-control" min="0" step="1" required>
            </div>

            <!-- Campo: company_id (Se cargan las compañías desde la BD, aquí se simula) -->
            <div class="form-group">
                <label for="company_id">Compañía:</label>
                <select name="Company_id" id="company_id" class="form-control">
                    <?php foreach ($companies as $company): ?>
                        <option value="<?= $company['id'] ?>"><?= $company['name'] ?></option>;
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (isset($errores)): foreach ($errores as $error): ?>
                    <p style="color: red;"><?= $error ?></p>
            <?php endforeach;
            endif; ?>

            <button type="submit" class="btn btn-primary">Añadir</button>
        </form>
    </div>

    <!-- JavaScript de Bootstrap (opcional, para funcionalidades adicionales) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>