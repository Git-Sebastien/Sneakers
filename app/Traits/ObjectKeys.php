<?php 

namespace App\Traits;

trait ObjectKeys{

    public function object_keys(object $object)
    {
        $array_keys = [];
        foreach($object as $key => $value){
            $array_keys[] = $key;
        }

        return $array_keys;
    }
}