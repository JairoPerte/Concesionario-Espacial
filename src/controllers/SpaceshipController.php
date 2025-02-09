<?php

namespace Jairo\ConcesionarioEspacial\Controllers;

use Jairo\ConcesionarioEspacial\Core\BaseController;
use Jairo\ConcesionarioEspacial\Models\CompanyModel;
use Jairo\ConcesionarioEspacial\Models\SpaceShipModel;

class SpaceshipController extends BaseController
{
    public function spaceships()
    {
        if (RegistroController::comprobarSesion(false)) {
            $this->view("spaceships", ['sesion' => $_SESSION]);
        } else {
            $this->view("spaceships");
        }
    }

    public function spaceship($vars)
    {
        $naveM = new SpaceShipModel();
        $nave = $naveM->obtenerDatosBasico($vars['id']);
        if ($nave) {
            if (RegistroController::comprobarSesion(false)) {
                $this->view("spaceship", ['sesion' => $_SESSION, 'nave' => $nave]);
            } else {
                $this->view("spaceship", ['nave' => $nave]);
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

    public function eliminarSpaceship($vars)
    {
        if (RegistroController::comprobarSesion(true)) {
            $naveM = new SpaceShipModel();
            if ($naveM->comprobarUsuarioSpaceship($vars['id'], $_SESSION['user_id'])) {
                $naveM->borrar($vars['id']);
                header("Location: /spaceships");
                exit;
            }
            header("Location: /spaceships/" . $vars['id']);
        }
    }

    public function addSpaceship()
    {
        // Recargamos sesión
        RegistroController::comprobarSesion(false);
        $companies = new CompanyModel();
        $this->view('addSpaceship', ["companies" => $companies->cargarTodo()]);
    }

    public function comprobarAddSpaceship()
    {
        $errores = [];
        $data = $_POST;

        /* VALIDACIONES */
        // Validar license_plate
        if (empty($data['license_plate']) || trim($data['license_plate']) === '') {
            $errores[] = 'La matrícula es obligatoria.';
        } elseif (strlen($data['license_plate']) > 12) {
            $errores[] = 'La matrícula no puede tener más de 12 caracteres.';
        }

        // Validar name
        if (empty($data['name']) || trim($data['name']) === '') {
            $errores[] = 'El nombre es obligatorio.';
        } elseif (strlen($data['name']) > 25) {
            $errores[] = 'El nombre no puede tener más de 25 caracteres.';
        }

        // Validar speed
        if (empty($data['speed']) || trim($data['speed']) === '') {
            $errores[] = 'La velocidad es obligatoria.';
        } elseif (!ctype_digit($data['speed'])) {
            $errores[] = 'La velocidad debe ser un número entero sin signo.';
        } else {
            $data['speed'] = (int) $data['speed'];
        }

        // Validar creddits
        if (empty($data['creddits']) || trim($data['creddits']) === '') {
            $errores[] = 'Los créditos son obligatorios.';
        } elseif (!ctype_digit($data['creddits'])) {
            $errores[] = 'Los créditos deben ser un número entero sin signo.';
        } else {
            $data['creddits'] = (int) $data['creddits'];
        }

        // Validar company_id
        $companies = new CompanyModel();
        if (empty($data['Company_id'])) {
            $errores[] = 'La compañía es obligatoria.';
        } elseif (!ctype_digit($data['Company_id']) || !$companies->cargar($data['Company_id'])) {
            $errores[] = 'La compañía no existe.';
        } else {
            $data['Company_id'] = (int) $data['Company_id'];
        }

        //Si no hay errores pues lo añadimos
        if (empty($errores)) {
            $naveM = new SpaceShipModel();
            $naveM->insertar($data);
            header("Location: /spaceships");
        } else {
            $this->view('addSpaceship', ["companies" => $companies->cargarTodo(), "errores" => $errores]);
        }
    }


    public function editarSpaceship($vars)
    {
        if (RegistroController::comprobarSesion(true)) {
            $naveM = new SpaceShipModel();
            $nave = $naveM->cargar($vars['id']);
            if ($nave) {
                if ($nave['User_id'] == $_SESSION['user_id']) {
                    $this->view('editSpaceship', ['nave' => $nave]);
                    exit;
                }
            }
        }
        header("Location: /");
    }

    public function comprobarEditarSpaceship($vars)
    {
        // Comprobamos que sea el usuario registrado sea el propietario y que la nave exista
        if (RegistroController::comprobarSesion(true)) {
            $naveM = new SpaceShipModel();
            $nave = $naveM->cargar($vars['id']);
            if ($nave) {
                if ($nave['User_id'] == $_SESSION['user_id']) {
                    $errores = [];
                    $data = $_POST;

                    /* VALIDACIONES */
                    // Validar name
                    if (empty($data['name']) || trim($data['name']) === '') {
                        $errores[] = 'El nombre es obligatorio.';
                    } elseif (strlen($data['name']) > 25) {
                        $errores[] = 'El nombre no puede tener más de 25 caracteres.';
                    }

                    // Validar speed
                    if (empty($data['speed']) || trim($data['speed']) === '') {
                        $errores[] = 'La velocidad es obligatoria.';
                    } elseif (!ctype_digit($data['speed'])) {
                        $errores[] = 'La velocidad debe ser un número entero sin signo.';
                    } else {
                        $data['speed'] = (int) $data['speed'];
                    }

                    // Validar creddits
                    if (empty($data['creddits']) || trim($data['creddits']) === '') {
                        $errores[] = 'Los créditos son obligatorios.';
                    } elseif (!ctype_digit($data['creddits'])) {
                        $errores[] = 'Los créditos deben ser un número entero sin signo.';
                    } else {
                        $data['creddits'] = (int) $data['creddits'];
                    }

                    // Validar sale
                    if (isset($data['sale'])) {
                        $data['sale'] = 1;
                    } else {
                        $data['sale'] = 0;
                    }

                    //Si no hay errores pues lo añadimos
                    if (empty($errores)) {
                        $naveM = new SpaceShipModel();
                        $naveM->modificar($vars['id'], $data);
                        header("Location: /spaceships/" . $vars['id']);
                    } else {
                        $this->view('editSpaceship', ["errores" => $errores, 'nave' => $nave]);
                    }
                }
            }
        }
    }

    public function comprarSpaceship($vars)
    {
        if (RegistroController::comprobarSesion(true)) {
            $naveM = new SpaceShipModel();
            $nave = $naveM->cargar($vars['id']);
            if ($nave['sale'] == 1 && ($nave["User_id"] == null || $_SESSION["user_id"] != $nave['User_id'])) {
                $naveM->comprarNave($vars['id'], $_SESSION['user_id']);
            }
        }
        header("Location: /spaceships/" . $vars['id']);
    }
}
