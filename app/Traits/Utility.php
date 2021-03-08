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

    public function filterEntity($request){
      $user='';
      if($request->entity != 'service'){
        $user= array_filter($request->users);
      }
      if($request->entity == 'service'){
        if(isset($request->services)){
          $user= array_filter($request->services);
        }
        if(isset($request->category) && !isset($request->services)){
          $user= array_filter($request->category);
        }

      }
      return  $user;
    }
}
