<?php

namespace Controllers;

use MVC\Router;

class LoginController{

    public static function index (Router $router){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
        echo 'desee login';
    }
    public static function logout(){

    }
    public static function crear (Router $router){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
        echo 'desee crear';
    }
    public static function olvide (Router $router){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
        echo 'desee olvide';
    }
    public static function restablecer (Router $router){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
        echo 'desee restablecer';
    }
    public static function mensaje (Router $router){
        
        echo 'desee mensaje';
    }
    public static function confirmar (Router $router){
        
        echo 'desee confirmar';
    }

}