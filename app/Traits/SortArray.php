<?php 

namespace App\Traits;


trait SortArray {

    public function sortArray(array $array)
    {
        $valueToReturn = null;

        foreach($array as $value) {
            if(count($array) > 1){
                $valueToReturn[] = $value;
            }
            else{
                $valueToReturn = $value;
            }
        }

        return $valueToReturn;
    }
}