<?php

namespace Jairo\ConcesionarioEspacial\Core;

abstract class BaseController
{
    /**
     * view
     * 
     * Renderiza la nueva vista y le pasa los parámetros
     *
     * @param  mixed $view
     * @param  mixed $data
     * @return void
     */
    protected function view($view, $data = [])
    {
        //Extract recibe un array asociativo con nombres de variables como las clasves y sus valores y sus valores
        extract($data);
        require_once __DIR__ . "/../views/{$view}.php";
    }
}
