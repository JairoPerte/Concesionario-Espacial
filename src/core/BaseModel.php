<?php

namespace Jairo\ConcesionarioEspacial\Core;

use InvalidArgumentException;
use PDO;
use PDOException;
use Jairo\ConcesionarioEspacial\Core\Database;

abstract class BaseModel
{
    protected $table;

    public function cargar($id)
    {
        if (empty($this->table)) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'No se ha definido la tabla para este modelo.';
            return false;
        }
        try {
            $sql = "SELECT * from `$this->table` where id = :id";
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

    public function cargarTodoPaginado($num_pag, $elem_pag)
    {
        if (empty($this->table)) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'No se ha definido la tabla para este modelo.';
            return false;
        }
        try {
            $sql = "SELECT * from `$this->table` limit :elem_pag offset :offset";
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

    public function cargarTodo()
    {
        if (empty($this->table)) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'No se ha definido la tabla para este modelo.';
            return false;
        }
        try {
            $sql = "SELECT * from `$this->table`";
            $stmt = Database::getConnection()->prepare($sql);

            $resultado = $stmt->execute();

            // Si ha ido bien devolvemos los datos
            if ($resultado) return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'Hubo un problema al cargar el registro: ' . $e->getMessage();
            return false;
        }
    }

    public function borrar($id)
    {
        if (empty($this->table)) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'No se ha definido la tabla para este modelo.';
            return false;
        }
        try {
            $sql = "DELETE from `$this->table` where id = ?";
            $stmt = Database::getConnection()->prepare($sql);

            // Ejecutamos la sentencia substituyendo las interrogacions por los valores
            // Que metemos dentro del array que le pasamos a execute
            $resultado = $stmt->execute([$id]);

            // Devolvemos el resultado de la ejecucion de la sentencia
            return $resultado;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'Hubo un problema al eliminar el registro: ' . $e->getMessage();
            return false;
        }
    }

    public function obtenerTotalPaginas($registros_por_pagina)
    {
        try {
            // SQL para contar el total de registros
            $sql_total = "SELECT COUNT(*) AS total_registros FROM $this->table";

            // Preparar la consulta
            $stmt = Database::getConnection()->prepare($sql_total);

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


    public function insertar($datos)
    {
        // VALIDACIONES
        if (empty($this->table)) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'No se ha definido la tabla para este modelo.';
            return false;
        }
        if (empty($datos) || !is_array($datos)) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'El parámetro $datos debe ser un array asociativo correcto';
        }
        try {
            // Sacamos las claves que corresponden con los nombres de los campos
            $campos = array_keys($datos);

            // Generamos la sentencia SQL dinámica
            $sql = "INSERT INTO `$this->table` (`" . implode('`,`', $campos) . "`) VALUES (" . implode(',', array_fill(0, count($campos), '?')) . ")";

            // Preparamos la consulta
            $stmt = Database::getConnection()->prepare($sql);

            // Ejecutamos la consulta con los valores
            $stmt->execute(array_values($datos));

            // Obtenemos la conexión del id, ya que es de la conexión actual (no afecta los cambios de la actual)
            $idInsertado = Database::getConnection()->lastInsertId();

            return $idInsertado;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'Hubo un problema al insertar el registro: ' . $e->getMessage();
            return false;
        } catch (InvalidArgumentException) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            return false;
        }
    }

    public function modificar($id, $datos)
    {
        // VALIDACIONES
        if (empty($this->table)) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'No se ha definido la tabla para este modelo.';
            return false;
        }
        if (empty($datos) || !is_array($datos)) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'El parámetro $datos debe ser un array asociativo correcto';
        }
        try {
            // Sacamos las claves que corresponden con los nombres de los campos
            $campos = array_keys($datos);

            // Introducimos la sentencia
            $sql = "UPDATE `$this->table` SET ";

            // Vamos añadiendo los valores
            for ($i = 0; $i < count($campos); $i++) {
                if ($i < count($campos) - 1)
                    $sql .= "$campos[$i] = ?,";
                else
                    $sql .= "$campos[$i]=?";
            }
            $sql .= " WHERE id=?";

            $stmt = Database::getConnection()->prepare($sql);

            $resultado = $stmt->execute([...array_values($datos), $id]);

            // Devolvemos el resultado de la ejecucion de la sentencia
            return $resultado;
        } catch (PDOException $e) {
            // Por si al final quiero hacer los errores con el modo DOTENV
            echo 'Hubo un problema al insertar el registro: ' . $e->getMessage();
            return false;
        }
    }
}
