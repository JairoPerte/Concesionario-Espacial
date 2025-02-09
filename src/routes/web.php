<?php

use FastRoute\RouteCollector;

// Tiene que devolver una función ya que la necesita como parámetro
return function (RouteCollector $route) {
    // PARA HOME
    $route->get("/", [\Jairo\ConcesionarioEspacial\Controllers\HomeController::class, 'inicio']);
    $route->get("/creddits", [\Jairo\ConcesionarioEspacial\Controllers\HomeController::class, 'creddits']);
    $route->post("/creddits", [\Jairo\ConcesionarioEspacial\Controllers\HomeController::class, 'sumarCreddits']);
    // PARA REGISTRO, LOGIN, VALIDACIÓN
    $route->get("/login", [\Jairo\ConcesionarioEspacial\Controllers\RegistroController::class, 'login']);
    $route->post("/login", [\Jairo\ConcesionarioEspacial\Controllers\RegistroController::class, 'verificarLogin']);
    $route->get("/register", [\Jairo\ConcesionarioEspacial\Controllers\RegistroController::class, 'registro']);
    $route->post("/register", [\Jairo\ConcesionarioEspacial\Controllers\RegistroController::class, 'registrarUsuario']);
    $route->get("/email-verify", [\Jairo\ConcesionarioEspacial\Controllers\RegistroController::class, 'verificacionEmail']);
    $route->post("/email-verify", [\Jairo\ConcesionarioEspacial\Controllers\RegistroController::class, 'validarCodigoEmail']);
    $route->post("/logout", [\Jairo\ConcesionarioEspacial\Controllers\RegistroController::class, 'logout']);
    // PARA PERFIL
    $route->get("/profile/{id:\d+}", [\Jairo\ConcesionarioEspacial\Controllers\PerfilController::class, 'mostrarPerfil']);
    $route->post("/profile/{id:\d+}", [\Jairo\ConcesionarioEspacial\Controllers\PerfilController::class, 'eliminarPerfil']);
    $route->get("/profile/config", [\Jairo\ConcesionarioEspacial\Controllers\PerfilController::class, 'configPerfil']);
    $route->post("/profile/config", [\Jairo\ConcesionarioEspacial\Controllers\PerfilController::class, 'comprobarConfigPerfil']);
    // PARA NAVES ESPACIALES
    $route->get("/spaceships", [\Jairo\ConcesionarioEspacial\Controllers\SpaceshipController::class, 'spaceships']);
    $route->get("/spaceships/add", [\Jairo\ConcesionarioEspacial\Controllers\SpaceshipController::class, 'addSpaceship']);
    $route->post("/spaceships/add", [\Jairo\ConcesionarioEspacial\Controllers\SpaceshipController::class, 'comprobarAddSpaceship']);
    $route->get("/spaceships/{id:\d+}", [\Jairo\ConcesionarioEspacial\Controllers\SpaceshipController::class, 'spaceship']);
    $route->post("/spaceships/{id:\d+}", [\Jairo\ConcesionarioEspacial\Controllers\SpaceshipController::class, 'eliminarSpaceship']);
    $route->get("/spaceships/{id:\d+}/edit", [\Jairo\ConcesionarioEspacial\Controllers\SpaceshipController::class, 'editarSpaceship']);
    $route->post("/spaceships/{id:\d+}/edit", [\Jairo\ConcesionarioEspacial\Controllers\SpaceshipController::class, 'comprobarEditarSpaceship']);
    $route->post("/spaceships/{id:\d+}/buy", [\Jairo\ConcesionarioEspacial\Controllers\SpaceshipController::class, 'comprarSpaceship']);
    // PARA PLANETAS
    $route->get("/planetarium", [\Jairo\ConcesionarioEspacial\Controllers\PlanetariumController::class, 'planetarium']);
    $route->get("/planetarium/{id:\d+}", [\Jairo\ConcesionarioEspacial\Controllers\PlanetariumController::class, 'planeta']);
};
