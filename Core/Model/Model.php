<?php 

namespace Core\Model;

use App\Models\User;
use App\Traits\SortArray;
use Core\Database\Database;

class Model extends Database{
    protected $data;

    use SortArray;

    public function find(int $id)
    {
        $this->query = $this->pdo->query("SELECT * FROM users WHERE id = $id");
        $this->data =  $this->sortArray($this->query->fetchAll($this->fetchMode(),User::class));
        return $this->data;
    }
}