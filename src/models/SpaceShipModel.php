<?php

namespace Jairo\ConcesionarioEspacial\Models;

use Jairo\ConcesionarioEspacial\Core\BaseModel;
use Jairo\ConcesionarioEspacial\Core\Database;
use PDO;
use PDOException;

class SpaceShipModel extends BaseModel
{
    public function __construct()
    {
        $this->table = "SpaceShip";
    }

    public function obtenerDatosBasico($id)
    {
        try {
            $sql = "SELECT 
                SpaceShip.*, 
                Company.name AS company_name, 
                User.nickname AS user_nickname,
                Planet.name AS planet_name 
                FROM SpaceShip
                JOIN Company ON SpaceShip.company_id = Company.id
                LEFT JOIN User ON SpaceShip.user_id = User.id
                LEFT JOIN Planet ON SpaceShip.planet_id = Planet.id
                WHERE SpaceShip.id = :id";
            $stmt = Database::getConnection()->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $resultado = $stmt->execute();

            //Si ha ido bien devolvemos los datos
            if ($resultado) return $stmt->fetch();
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'Hubo un problema al cargar datos: ' . $e->getMessage();
            return false;
        }
    }

    public function cargarTodosDatosPaginado($num_pag, $elem_pag)
    {
        try {
            $sql = "SELECT SpaceShip.*, 
                Company.name AS company_name, 
                User.nickname AS user_nickname, 
                Planet.name AS planet_name 
                FROM SpaceShip
                JOIN Company ON SpaceShip.company_id = Company.id
                LEFT JOIN User ON SpaceShip.user_id = User.id
                LEFT JOIN Planet ON SpaceShip.planet_id = Planet.id ORDER BY SpaceShip.id limit :elem_pag offset :offset;";
            $stmt = Database::getConnection()->prepare($sql);

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

    public function comprobarUsuarioSpaceship($id, $idUser)
    {
        try {
            $sql = "SELECT User_id FROM SpaceShip WHERE id=:id";
            $stmt = Database::getConnection()->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Si ha ido bien devolvemos true
            if ($stmt->execute()) {
                $resultado = $stmt->fetch();
                if ($resultado['User_id'] == $idUser) {
                    return true;
                }
            }

            return false;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'Hubo un problema al cargar paginado el registro: ' . $e->getMessage();
            return false;
        }
    }

    public function comprarNave($id, $idUser)
    {
        try {
            $sql = "SELECT creddits FROM User WHERE id=:id";
            $stmt = Database::getConnection()->prepare($sql);

            $stmt->bindParam(':id', $idUser, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $resultado = $stmt->fetch();
                $credditsUser = $resultado['creddits'];

                $sql = "SELECT creddits, User_id FROM SpaceShip WHERE id=:id";
                $stmt = Database::getConnection()->prepare($sql);

                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $resultado = $stmt->fetch();
                    $creddits = $resultado['creddits'];

                    if ($creddits <= $credditsUser) {
                        $naveM = new SpaceShipModel();
                        $userM = new UserModel();

                        $userM->modificar($idUser, ["creddits" => ((int)$credditsUser - (int)$creddits)]);

                        if ($resultado['User_id'] != null) {
                            $userM->modificar($resultado['User_id'], ["creddits" => ($userM->cargar($resultado['User_id'])["creddits"] + $creddits)]);
                        }

                        $naveM->modificar($id, ["User_id" => $idUser]);
                    }
                }

                return false;
            }
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'Hubo un problema al cargar paginado el registro: ' . $e->getMessage();
            return false;
        }
    }
}
