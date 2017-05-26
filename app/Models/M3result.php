<?php
namespace App\Models;
 class M3result{
     public $status;
     public $message;


     public function toJson(){
         return json_encode($this,JSON_UNESCAPED_UNICODE);
     }

 }