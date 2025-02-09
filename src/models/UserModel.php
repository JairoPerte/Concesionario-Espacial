<?php

namespace Jairo\ConcesionarioEspacial\Models;

use Jairo\ConcesionarioEspacial\Core\BaseModel;
use Jairo\ConcesionarioEspacial\Core\Database;
use PDO;
use PDOException;

class UserModel extends BaseModel
{
    public function __construct()
    {
        $this->table = "User";
    }

    public function existeEmail($email)
    {
        try {
            $sql = "SELECT email FROM User WHERE email = :email";
            $stmt = Database::getConnection()->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch();
            if ($usuario) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            return false;
        }
    }

    public function existeNickname($nickname)
    {
        try {
            $sql = "SELECT nickname FROM User WHERE nickname = :nickname";
            $stmt = Database::getConnection()->prepare($sql);
            $stmt->bindParam(':nickname', $nickname, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch();
            if ($usuario) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            return false;
        }
    }

    public function validacionEmail($id)
    {
        try {
            $sql = "SELECT validated FROM User WHERE id = :id";
            $stmt = Database::getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $usuario = $stmt->fetch();
            if ($usuario) {
                return $usuario['validated'] == 1 ? true : false;
            }
            return false;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            return false;
        }
    }

    public function verificarCodigoEmail($id, $codigo)
    {
        try {
            $sql = "SELECT validated_code FROM User WHERE id = :id";
            $stmt = Database::getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $usuario = $stmt->fetch();
            if ($usuario && $codigo == $usuario["validated_code"]) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            return false;
        }
    }

    public function validarEmail($id)
    {
        try {
            $sql = "UPDATE User SET validated=1 WHERE id=:id";

            $stmt = Database::getConnection()->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            return false;
        }
    }

    public function comprobarUsuario($email, $password)
    {
        try {
            $sql = "SELECT id, password, nickname, validated FROM User WHERE email = :email";
            $stmt = Database::getConnection()->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch();

            // Si es válida la contraseña pues enviamos los datos para guardarlos en SESSIONS
            if ($usuario && password_verify($password, $usuario['password'])) {
                return ["id" => $usuario['id'], "nickname" => $usuario['nickname'], "validated" => $usuario["validated"]];
            }

            return false;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            return false;
        }
    }

    public function comprobarPassword($id, $password)
    {
        try {
            $sql = "SELECT password FROM User WHERE id = :id";
            $stmt = Database::getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $usuario = $stmt->fetch();

            // Si es válida la contraseña pues enviamos los datos para guardarlos en SESSIONS
            if ($usuario && password_verify($password, $usuario['password'])) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            return false;
        }
    }

    public function comprobarCookie($id, $cookie)
    {
        try {
            $sql = "SELECT id FROM User WHERE id = :id and cookie = :cookie";
            $stmt = Database::getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':cookie', $cookie, PDO::PARAM_STR);

            // Si no está vacia existe
            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function insertarSesion($id)
    {
        try {
            $sql = "UPDATE User SET cookie=:cookie WHERE id=:id";

            $stmt = Database::getConnection()->prepare($sql);

            $hash = bin2hex(random_bytes(32));

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':cookie', $hash, PDO::PARAM_STR);
            $stmt->execute();
            return $hash;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            return false;
        }
    }

    public function insertarCodigoValidacion($id)
    {
        try {
            $sql = "UPDATE User SET validated_code=:code WHERE id=:id";

            $stmt = Database::getConnection()->prepare($sql);

            $code = $this::generarCodigoVerificacion();

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':code', $code, PDO::PARAM_STR);
            $stmt->execute();
            return $code;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            return false;
        }
    }

    public function obtenerUser($id)
    {
        try {
            $sql = "SELECT id, nickname, image FROM User WHERE id = :id";
            $stmt = Database::getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $usuario = $stmt->fetch();

            // Si es válida la contraseña pues enviamos los datos para guardarlos en SESSIONS
            if ($usuario) {
                return $usuario;
            }

            return false;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            return false;
        }
    }

    public function obtenerSpaceShips($id, $num_pag, $elem_pag)
    {
        try {
            $sql = "SELECT * from SpaceShip WHERE User_id = :id limit :elem_pag offset :offset";
            $stmt = Database::getConnection()->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':elem_pag', $elem_pag, PDO::PARAM_INT);

            // Calculamos el offset con el número de la página
            $offset = ($elem_pag * ($num_pag - 1));
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            $resultado = $stmt->execute();

            // Si ha ido bien devolvemos los datos
            if ($resultado) return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'Hubo un problema al cargar paginado el registro: ' . $e->getMessage();
            return false;
        }
    }

    public function obtenerTotalNaves($registros_por_pagina, $id)
    {
        try {
            // SQL para contar el total de registros
            $sql = "SELECT COUNT(*) AS total_registros FROM SpaceShip WHERE User_id = :id";

            // Preparar la consulta
            $stmt = Database::getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el resultado de la consulta
                $resultado = $stmt->fetch();

                // Si fetch() devuelve false (sin resultados), tratarlo como un valor por defecto
                if ($resultado) {
                    $total_registros = $resultado['total_registros'];

                    // Calcular el total de páginas
                    $total_paginas = ceil($total_registros / $registros_por_pagina);

                    // Devolver el total de páginas
                    return $total_paginas;
                } else {
                    // Si no hay registros, retornar 0
                    return 0;
                }
            } else {
                // Si la consulta falla, devolver 0
                return 0;
            }
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'Hubo un problema al obtener el número total de páginas: ' . $e->getMessage();
            return false;
        }
    }

    public function obtenerCompany($id)
    {
        try {
            $sql = "SELECT * from Company WHERE User_id = :id limit :elem_pag offset :offset";
            $stmt = Database::getConnection()->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $resultado = $stmt->execute();

            // Si ha ido bien devolvemos los datos
            if ($resultado) return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'Hubo un problema al cargar paginado el registro: ' . $e->getMessage();
            return false;
        }
    }

    public function sumarCreditos($id, $creditos)
    {
        try {
            $sql = "SELECT creddits from User WHERE id = :id";
            $stmt = Database::getConnection()->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Si ha ido bien devolvemos los datos
            if ($stmt->execute()) {
                $resultado = $stmt->fetch();
                $creditosTotales = $resultado['creddits'] + $creditos;
                $sql = "UPDATE User SET creddits=:creddits WHERE id=:id";

                $stmt = Database::getConnection()->prepare($sql);

                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':creddits', $creditosTotales, PDO::PARAM_INT);
                $stmt->execute();
                return true;
            }
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'Hubo un problema al cargar paginado el registro: ' . $e->getMessage();
            return false;
        }
    }

    public static function generarCodigoVerificacion()
    {
        // Como quiero un código número pues tengo que utilizar: random int genera un número de 0-99999 str_pad se encarga de que sean 5 dígitos si o si, si no llega rellena con 0 en la izq
        return str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
    }
}
