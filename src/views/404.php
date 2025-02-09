<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>404 - Página no encontrada</title>
  <link rel="stylesheet" href="/css/basic.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: rgb(42, 41, 51);
      color: #333;
      text-align: center;
      padding: 50px;
    }

    h1 {
      font-size: 80px;
      color: #ff6347;
    }

    p {
      font-size: 24px;
      color: antiquewhite;
    }

    .explorer {
      font-size: 30px;
      font-weight: bold;
      color: #1e90ff;
    }

    .emoji {
      font-size: 40px;
    }
  </style>
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
    <h1>404</h1>
    <p>Página no encontrada</p>
    <p>Aquí no hay nada que buscar, ¡aventurero intergaláctico!</p>
    <p class="explorer">
      ¡Vuelve a tu nave y sigue explorando el universo! 🚀
    </p>
  </main>
</body>

</html>