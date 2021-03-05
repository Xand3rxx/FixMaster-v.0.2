<?php
 
namespace App\Traits;
 
 
trait Utility
 {
 
    public function entityArray()
    {  
        $objects=[];
        $names =['User', 'Service', 'Estate'];
        for ($i=0; $i< Count($names); $i++) {
          $objects[] = (object) [
            "id" => $i+1,
            "name" => $names[$i],
          ];
        }
    
        return $objects;
    
    }

  

}
