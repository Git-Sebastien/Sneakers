<?php 

namespace Core\Model;

use PDO;
use App\Models\User;
use Core\Database\Database;

class Model extends Database{

    public function __construct(){

        parent::__construct();
    }


    public function find(int $id)
    {
        // dd($this->fetchMode());
       return $this->statement = $this->pdo->query("SELECT * FROM users WHERE id=$id")->fetchAll($this->fetchMode(),$this->model);
        
    }
}