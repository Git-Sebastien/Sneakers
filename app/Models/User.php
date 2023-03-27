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
    public function setPassword(string $password) :User
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
    public function setEmail(string $email) :User
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
    public function setId(int $id) :User
    {
        $this->id = $id;

        return $this;
    }

    public function save() :bool
    {
        $arrayProperty = $this->arrayShiftWithLevel(get_object_vars($this),3);
        // dd($arrayProperty);
        $arrayPropertyModified = [];
        $accumulateProperty = null;
        $propertyName = null;
        $propertyValue = null;


        if(count($arrayProperty) > 1 ){
            foreach($arrayProperty as $property => $value){
                $arrayPropertyModified[$property] = [$property.'="'.$value.'"'];
            }
            foreach($this->sortArray($arrayPropertyModified) as $key => $value){
                $accumulateProperty .= $value[0].',';   
            }
        }

        // dd($accumulateProperty);
 
        $propertyName = array_keys($arrayProperty)[0];
        $propertyValue = '"'.array_values($arrayProperty)[0].'"';

        if(!empty($arrayProperty) && count($arrayProperty) > 1){
            $porpertyTrim = rtrim($accumulateProperty,',');
            
            $query = "UPDATE users SET $porpertyTrim WHERE  id = 1 ";
            // dd($this->pdo->query($query)->execute());
            return $this->pdo->query($query)->execute();
        }
        else{
            $query = "UPDATE users SET $propertyName = $propertyValue WHERE id = 1 ";
            // dd($this->pdo->query($query)->execute());
            return $this->pdo->query($query)->execute();
        }
    }
}