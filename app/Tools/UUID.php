<?php
namespace APP\Tools;
 class UUID{
     static function  create()
     {
         $chars = md5(uniqid(mt_rand(), true));
         $uuid = substr ( $chars, 0, 8 ) . '-'
             . substr ( $chars, 8, 4 ) . '-'
             . substr ( $chars, 12, 4 ) . '-'
             . substr ( $chars, 16, 4 ) . '-'
             . substr ( $chars, 20, 12 );
         return $uuid ;
     }
 }