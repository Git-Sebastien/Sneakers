<?php 

namespace App\Traits;


trait StrPlural{

    use SortArray;

    public function strPlural(string|array $str)
    {
        if(is_array($str)){
            $valueToReturn = [];
            foreach($str as $strs){
                $valueToReturn[] = $strs.'s';
            }
        }

        return $str.'s';
    }
}