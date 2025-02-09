<?php

namespace Jairo\ConcesionarioEspacial\Models;

use Jairo\ConcesionarioEspacial\Core\BaseModel;
use Jairo\ConcesionarioEspacial\Core\Database;
use PDO;
use PDOException;

class PlanetModel extends BaseModel
{
    public function __construct()
    {
        $this->table = "planet";
    }
}
