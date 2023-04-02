<?php 

namespace Core\Database;

use PDO;
use ReflectionClass;
use App\Traits\StrPlural;

class Database {

    use StrPlural;

    protected PDO $pdo;

    protected $query;

    protected $statement;

    protected string $model;

    protected int $idUser;

    public string $table;

    public string $field;


    public function __construct()
    {
        $this->pdo = $this->getPDO();
        $this->getTableName();
    }

    public function getPDO() :PDO 
    {
        $settings = require ROOT .'app'. DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
            $this->pdo = new PDO('mysql:host='.$settings["db_host"].';dbname='.$settings["db_name"].';',$settings["db_user"],$settings["db_password"],[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
    
        // if(!is_null($this->query)) $this->query->setFetchMode(PDO::FETCH_CLASS,$this->model); 

        return $this->pdo;
    }

    public function select(string|array $column = ['*'])
    {
        $columns = is_array($column) ? implode(',',$column) : $column;
        $this->query = "SELECT $columns FROM ".$this->table;
        return $this;
    }


    public function getTableName()
    {
        $reflection = new ReflectionClass(get_called_class());
        $tableToLower = lcfirst($reflection->getShortName());
        $this->table = $this->strPlural($tableToLower);
    }


    protected function fetchMode()
    {
        return PDO::FETCH_CLASS;
    }
}