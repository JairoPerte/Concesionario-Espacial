<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link rel="shortcut icon" href="/img/icon/Infinity&Beyond-logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="/css/profileConfig.css">
</head>

<body>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Configuración de Usuario</title>
        <link rel="stylesheet" href="/css/profileConfig.css">
    </head>

    <body>
        <div class="container">
            <!-- Menú lateral con flecha curva -->
            <div class="menu">
                <a href="/profile/<?= htmlspecialchars($sesion['user_id']) ?>" class="back-arrow">&#8594; Volver</a>
                <a href="#datos">Datos de Usuario</a>
                <a href="#privacidad">Privacidad</a>
                <a href="#eliminar">Eliminar Datos</a>
            </div>

            <div class="content">
                <h2>Configuración de Usuario</h2>

                <!-- Sección de Datos -->
                <form action="/profile/config" method="POST" enctype="multipart/form-data">
                    <div class="section" id="datos">
                        <h3>Datos</h3>
                        <label for="image">Imagen de Perfil:</label>
                        <input type="file" name="image" id="image">
                        <label for="username">Nickname:</label>
                        <input type="text" name="username" id="username" placeholder="Nombre de Usuario" value="<?= htmlspecialchars($sesion['user_nickname']) ?>">
                        <label for="passwordNuev">Nueva Contraseña:</label>
                        <input type="password" id="passwordNuev" name="new_password" placeholder="Contraseña Nueva">
                        <label for="passwordAnt">Contraseña:</label>
                        <input type="password" id="passwordAnt" name="old_password" placeholder="Contraseña Antigua" required>
                        <?php if ($_SERVER["REQUEST_METHOD"] == 'POST'): ?>
                            <p id="error">La contraseña o el formulario están mal</p>
                        <?php endif; ?>
                        <button type="submit" name="update_data">Confirmar</button>
                    </div>
                </form>

                <!-- Sección de Email -->
                <div class="section" id="privacidad">
                    <h3>Email</h3>
                    <label for="updates">Recibir actualizaciones y novedades</label>
                    <input type="checkbox" id="updates">
                </div>

                <!-- Sección de Eliminar Datos -->
                <div class="section" id="eliminar">
                    <h3>Eliminar Datos</h3>
                    <div class="delete-buttons">
                        <form action="/profile/<?= htmlspecialchars($sesion['user_id']) ?>" method="post" id="form_eliminar">
                            <button id="delete-account-btn">Eliminar Cuenta</button>
                        </form>
                        <form action="/logout" method="POST">
                            <button id="logout-btn">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popup para eliminar cuenta -->
        <div id="delete-popup" class="popup">
            <div class="popup-content">
                <p>¿Seguro que quieres eliminar tu cuenta? Esta acción no se puede deshacer.</p>
                <button id="confirm-delete" disabled>Eliminar Cuenta (5)</button>
                <button id="cancel-delete">Cancelar</button>
            </div>
        </div>

        <script src="/js/profileConfig.js"></script>
    </body>

    </html>
</body>

</html>