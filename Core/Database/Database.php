<?php 

namespace Core\Database;

use PDO;

class Database {

    protected PDO $pdo;

    public string  $table;

    public string $field;

    protected $query;

    protected string $model;

    public function __construct()
    {
        $this->pdo = $this->getPDO();
    }

    public function getPDO() :PDO 
    {
            $settings = require ROOT .'app'. DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
                $this->pdo = new PDO('mysql:host='.$settings["db_host"].';dbname='.$settings["db_name"].';',$settings["db_user"],$settings["db_password"],[
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]);
        
            if(!is_null($this->query)) $this->query->setFetchMode(PDO::FETCH_CLASS,$this->model); 

            return $this->pdo;
    }

    public function select(string|array $column = ['*'])
    {
        $columns = is_array($column) ? implode(',',$column) : $column;
        $this->query = "SELECT $columns FROM ".$this->table;
        return $this;
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }


    protected function fetchMode()
    {
        return PDO::FETCH_CLASS;
    }
}