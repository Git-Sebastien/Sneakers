<?php 

namespace App\Traits;


trait ArrayShift{

    public function arrayShiftWithLevel(array $array, int $level)
    {
        for($i = 0; $i < $level; $i++){
            array_shift($array);
        }

        return $array;
    }

}