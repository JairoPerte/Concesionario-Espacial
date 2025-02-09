<?php

require_once __DIR__ . '/vendor/autoload.php';
// Cargamos el dotenv desde el principio (para no tener q ponerlo cada dos por tres)
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// coge la URI para comprobar que es:
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Asegúrate de que no se pueda salir de la carpeta public usando ../
$realPath = realpath(__DIR__ . '/public' . $uri);
$publicPath = realpath(__DIR__ . '/public');

// Verifica si el archivo solicitado está dentro de la carpeta public
if ($uri !== "/" && $realPath && strpos($realPath, $publicPath) === 0 && file_exists($realPath)) {

    //Se saca la extensión para saber q tipo de archivo es
    $extension = pathinfo($realPath, PATHINFO_EXTENSION);

    //Si es un php lo necesitamos para el AJAX
    if ($extension === 'php') {
        include $realPath;
        exit;
    }

    // Asignar tipos MIME específicos para extensiones conocidas
    $mimeType = match ($extension) {
        'css' => 'text/css; charset=UTF-8',
        'js' => 'application/javascript; charset=UTF-8',
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        'ttf' => 'font/ttf',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        default => mime_content_type($realPath), // Fallback
    };


    // Determinar tipo de contenido
    header('Content-Type: ' . $mimeType);

    // Leer el archivo y devolverlo
    readfile($realPath);
    exit;
}

// Si no es un archivo estático pues es una ruta y se redirige a index.php
require_once __DIR__ . '/public/index.php';
