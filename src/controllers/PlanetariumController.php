<?php

namespace Jairo\ConcesionarioEspacial\Controllers;

use Jairo\ConcesionarioEspacial\Core\BaseController;
use Jairo\ConcesionarioEspacial\Models\PlanetModel;

class PlanetariumController extends BaseController
{
    public function planetarium()
    {
        $planetaM = new PlanetModel();
        $planetarium = $planetaM->cargarTodo();
        if (RegistroController::comprobarSesion(false)) {
            $this->view("planetarium", ['planetarium' => $planetarium, 'sesion' => $_SESSION]);
        } else {
            $this->view("planetarium", ['planetarium' => $planetarium]);
        }
    }

    public function planeta($vars)
    {
        $planetaM = new PlanetModel();
        $planeta = $planetaM->cargar($vars['id']);
        if ($planeta) {
            if (RegistroController::comprobarSesion(false)) {
                $this->view("planeta", ['sesion' => $_SESSION, 'planeta' => $planeta]);
            } else {
                $this->view("planeta", ['planeta' => $planeta]);
            }
        } else {
            http_response_code(404);
            if (RegistroController::comprobarSesion(false)) {
                $this->view("404", ['sesion' => $_SESSION]);
            } else {
                $this->view("404");
            }
        }
    }
}
