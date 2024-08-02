<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Services\LoginServices;

class LoginController{

    public static function index (Router $router){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
        $router->render('auth/login',[
            'titulo'=> "Iniciar Sesion"
        ]);
    }
    public static function logout(){

    }
    public static function crear (Router $router){
        $usuario = new Usuario;
        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $usuario->setErroresForServicesLogin();              
            $alertas =  LoginServices::validar();

           if (LoginServices::noErrors()) {
                $usuarioExistente = Usuario::where('email', $usuario->email);
                if ($usuarioExistente) {
                    LoginServices::setAlerta('error', 'El usuario ya existe');
                }else{
                   $usuario->setPasswordEncrypt();
                   $usuario->setToken();
                   $resultado = $usuario->guardar();
                   if($resultado){
                    header("Location: /mensaje");
                   }
                }
           }
           
        }
        $alertas = LoginServices::getErrors();
        $router->render('auth/crear',[
            'titulo'=> "Crea una cuenta",
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function olvide (Router $router){
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $usuario->setErroresForServicesLogin();
            $alertas = LoginServices::EmailValidation();
            if (LoginServices::noErrors()) {
                $usuario = Usuario::where('email', $usuario->email);
                if($usuario && $usuario->confirmado){
                    $usuario->setToken(false);
                    $usuario->guardar();
                    LoginServices::setAlerta('exito', 'hemos enviado las instrucciones a tu E-mail');
                }else{
                    LoginServices::setAlerta('error', 'el usuario no existe o no esta confirmado');
                }
            }

        }
        $alertas = LoginServices::getErrors();
        $router->render('auth/olvide',[
            'titulo' => 'recupera tu password',
            'alertas' => $alertas
        ]);
    }
    public static function restablecer (Router $router){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            # code...
        }
        $router->render('auth/restablecer',[
            "titulo" => "restablece tu password"
        ]);
    }
    public static function mensaje (Router $router){
        
       $router->render('auth/mensaje',[
            'titulo' => 'revisa tu E-mail'
       ]);  
    }
    public static function confirmar (Router $router){
        $token = s($_GET['token']);
        if(!$token) header("Location: /");

        $usuario = Usuario::where('token', $token);

       if (empty($usuario)) {
            LoginServices::setAlerta('error','Token no valido');
            
        }else{
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);
            
           $usuario->guardar();
           LoginServices::setAlerta('exito','Tu cuenta a sido verificada');
         
       }

        $alertas = LoginServices::getErrors();
        $router->render('auth/confirmar',[
            'titulo' => 'confirmada',
            'alertas' => $alertas
        ]);
    }
    

}