<?php

namespace App\Exception;
use \Exception;

class EntityNotFoundException extends Exception{

    public function __construct(int $id,string $entity){
     parent::__construct("{$entity} with id{$id} not found");
     

    }


}