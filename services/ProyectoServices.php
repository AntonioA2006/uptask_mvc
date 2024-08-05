<?php

namespace Services;
use Services\interfaceServices;
class ProyectoServices implements interfaceServices{
    protected static $id = '';
    protected static $proyecto = '';
    protected static $url = '';
    protected static $propietario_id = '';
    private static $errors = [];

    public static function getInfo($options = []){
        foreach($options as $key => $value){
            self::$$key = $value;
        }

    }       

    public static function  validar(){
        if (!self::$proyecto) {
           self::$errors['error'][] = 'el nombre del proyecto es obligatorio';
        }
        return self::$errors;
    }
    public static function noErrors():bool{
        if (empty(self::$errors)) {
            return true;
        }
        return false;
    }
    
    public static function getErrors(): Array{
            return self::$errors;
    }


}