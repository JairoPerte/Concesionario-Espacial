<?php

namespace Jairo\ConcesionarioEspacial\Core;

use FastRoute\Dispatcher;
use Jairo\ConcesionarioEspacial\Controllers\RegistroController;

use function FastRoute\simpleDispatcher;

class Router
{
    // Esta es la función que se va a ejecutar para arrancar el fastroute    
    /**
     * run
     * 
     * Es el enrutador, despacha la ruta y redirige la ruta al controlador seleccionado.
     *
     * @return void
     */
    public function run()
    {
        // Aquí están todas las rutas (no es una clase así que lo pegamos aquí, para que quede más ordenado el código)
        $dispatcher = simpleDispatcher(require_once __DIR__ . '/../routes/web.php');

        // Obtener datos de la solicitud
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Eliminar parámetros de la consulta
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        // Despachar la ruta
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        // Posición 0 es si está en las rutas puestas
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                if (RegistroController::comprobarSesion(false)) {
                    $sesion = $_SESSION;
                }
                require_once __DIR__ . "/../views/404.php";
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);
                echo '405 - Method Not Allowed';
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1]; // Posición 1 es ruta del controller + la función
                $vars = $routeInfo[2]; // Posición 2 son las variables

                // Asignación doble de variables que recibe un array es  igaul $class=$handler[0] y $method=$handler[1]
                [$controller, $method] = $handler;
                //Equivalente a $controller = App\Controlador\EntrenadorController y llamamos directamente a la función 
                (new $controller())->$method($vars);
                break;
        }
    }
}
