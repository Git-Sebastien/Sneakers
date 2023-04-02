<?php 

namespace App\Models;

use App\Traits\ArrayShift;
use App\Traits\ObjectKeys;
use App\Traits\SortArray;
use Core\Model\Model;

class User extends Model {

    private int $id;
    private string $email;
    private string $password;

    use ArrayShift,SortArray,ObjectKeys;

    /**
     * Get the value of password
     */ 
    public function getPassword() :string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword(string $password) :self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail() :string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail(string $email) :self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId() :int 
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id) :self
    {
        $this->id = $id;

        return $this;
    }

    public function getVars()
    {
        return get_object_vars($this);
    }
}