<?php 

namespace Core\Database;

use PDO;

class Database {

    public PDO $pdo;

    public string  $table;

    public string $field;

    public string $query;

    protected $statement;

    protected $model;

    public function __construct()
    {
        $this->getPDO();
    }

    public function getPDO() :PDO 
    {
        $settings = require ROOT .'app'. DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
        $this->pdo = new PDO('mysql:host='.$settings["db_host"].';dbname='.$settings["db_name"].';',$settings["db_user"],$settings["db_password"],[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);

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

    public function get()
    {
        $this->statement =  $this->pdo->prepare($this->query);
        return $this->statement->execute();
    }

    protected function fetchMode()
    {
        return PDO::FETCH_CLASS;
    }


       
        
}