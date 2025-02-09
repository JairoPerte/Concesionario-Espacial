<?php

namespace Jairo\ConcesionarioEspacial\Models;

use Jairo\ConcesionarioEspacial\Core\BaseModel;
use Jairo\ConcesionarioEspacial\Core\Database;
use PDO;
use PDOException;

class CompanyModel extends BaseModel
{
    public function __construct()
    {
        $this->table = "company";
    }
}
