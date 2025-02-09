<?php

namespace Jairo\ConcesionarioEspacial\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        // Si no está creada la conexión pues la creamos
        if (self::$connection === null) {
            // Los datos del DOTENV
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $dbname = $_ENV['DB_NAME'];
            $username = $_ENV['DB_USERNAME'];
            $password = $_ENV['DB_PASSWORD'];

            //Hacemos el DSN con los datos del DOTENV
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

            try {
                self::$connection = new PDO($dsn, $username, $password);

                // Configuramos para que los errores no devuelvan false y devuelva array asociativos las consultas
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Por si al final quiero hacer los errores con el modo DOTENV
                // throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
            }
        }

        // Devolvemos la conexión
        return self::$connection;
    }

    static function obtenerTipoParametro($variable)
    {
        // Obtener el tipo de la variable
        $tipo = gettype($variable);

        // Mapear el tipo de PHP al tipo de PDO
        switch ($tipo) {
            case 'boolean':
                return PDO::PARAM_BOOL;
            case 'integer':
                return PDO::PARAM_INT;
            case 'double': // 'double' es el tipo que PHP usa para números flotantes
            case 'float':
                return PDO::PARAM_STR; // Se maneja como un string
            case 'string':
                return PDO::PARAM_STR;
            case 'array':
            case 'object':
                return PDO::PARAM_STR; // PDO no soporta array u object como tipos directos
            case 'NULL':
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR; // Tipo por defecto en caso de tipo desconocido
        }
    }
}
