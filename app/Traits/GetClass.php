<?php 

namespace App\Traits;


trait GetClass {


    public function getClassName()
    {
        return get_called_class();
    }

}