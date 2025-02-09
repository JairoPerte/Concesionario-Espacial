<?php

namespace Jairo\ConcesionarioEspacial\Controllers;

use Jairo\ConcesionarioEspacial\Core\BaseController;
use Jairo\ConcesionarioEspacial\Core\SubidaArchivos;
use Jairo\ConcesionarioEspacial\Models\UserModel;

class PerfilController extends BaseController
{
    public function mostrarPerfil($vars)
    {
        $userM = new UserModel();
        $usuario = $userM->obtenerUser($vars['id']);
        if ($usuario) {
            if (RegistroController::comprobarSesion(false)) {
                $this->view("perfil", ['sesion' => $_SESSION, 'usuario' => $usuario]);
            } else {
                $this->view("perfil", ['usuario' => $usuario]);
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

    public function configPerfil()
    {
        if (RegistroController::comprobarSesion(true)) {
            $this->view("profileConfig", ['sesion' => $_SESSION]);
        } else {
            header("Location: /login");
        }
    }

    public function eliminarPerfil($vars)
    {
        if (RegistroController::comprobarSesion(true)) {
            if ($_SESSION['user_id'] == $vars['id']) {
                $userM = new UserModel();
                session_start();
                session_unset();
                session_destroy();
                $userM->borrar($vars['id']);
                header("Location: /register");
            }
        } else {
            header("Location: /");
        }
    }

    public function comprobarConfigPerfil()
    {
        // La configuración es un sitio privado, por eso le pongo el true ahí
        if (RegistroController::comprobarSesion(true)) {
            // Verificamos si el formulario fue enviado correctamente
            if (isset($_POST['update_data']) && isset($_POST['old_password'])) {
                $userM = new UserModel();
                $old_password = $_POST['old_password'];
                $id = $_SESSION['user_id'];

                // Comprobamos si la contraseña actual es correcta
                if ($userM->comprobarPassword($id, $old_password)) {
                    $updateData = []; // Array dinámico para almacenar solo los datos modificados

                    // Añadimos los datos que estén introducidos
                    if (!empty($_POST['new_password'])) {
                        $new_password = $_POST['new_password'];
                        $updateData['password'] = password_hash($new_password, PASSWORD_ARGON2ID);
                    }
                    if (!empty($_POST['username'])) {
                        $updateData['nickname'] = $_POST['username'];
                        $_SESSION['user_nickname'] = $_POST['username'];
                    }
                    if (!empty($_FILES['image'])) {
                        $image = $_FILES['image'];
                        $shortdirectory = SubidaArchivos::subirImagenPerfil($image, $id);
                        if ($shortdirectory) {
                            $updateData['image'] = $shortdirectory;
                        } else {
                            //Fallo al subir imagen
                        }
                    }

                    // Si hay algo que actualizar, llamamos al método modificar
                    if (!empty($updateData)) {
                        $userM->modificar($id, $updateData);
                        //Mensaje de éxito
                        header("Location: /profile/$id");
                    } else {
                        // No se hizo ningún cambio
                    }
                } else {
                    // Mostrar mensaje de error: La contraseña actual no es correcta
                    $this->view('profileConfig');
                }
            } else {
                // Mostrar error de formulario incorrecto
                $this->view('profileConfig');
            }
        } else {
            // Intenta acceder a la configuración sin estar conectado
            header("Location: /login");
            exit;
        }
    }
}
