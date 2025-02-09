<?php

namespace Jairo\ConcesionarioEspacial\Controllers;

use Jairo\ConcesionarioEspacial\Core\BaseController;
use Jairo\ConcesionarioEspacial\Controllers\RegistroController;
use Jairo\ConcesionarioEspacial\Models\UserModel;

class HomeController extends BaseController
{
    public function inicio()
    {
        if (RegistroController::comprobarSesion(false)) {
            $this->view('home', ["sesion" => $_SESSION]);
        } else {
            $this->view('home');
        }
    }

    public function creddits()
    {
        if (RegistroController::comprobarSesion(false)) {
            $this->view('creddits', ["sesion" => $_SESSION]);
        } else {
            header("Location: /");
        }
    }

    public function sumarCreddits()
    {
        if (RegistroController::comprobarSesion(false)) {
            if (isset($_POST['creddits'])) {
                var_dump($_POST['creddits']);
                $userM = new UserModel();
                $userM->sumarCreditos($_SESSION['user_id'], (int) $_POST['creddits']);
            }
        }
        header("Location: /");
    }
}
