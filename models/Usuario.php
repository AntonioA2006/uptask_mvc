<?php

namespace Model;

use Services\EmailServices;
use Services\LoginServices;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado' ];
    
    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password_actual;
    public $password_nuevo;
    public $password2;
    public $token;
    public $confirmado;
    public function __construct($args = [])
    {       
        $this->password2 = $args['password2'] ??'';
        $this->id = $args['id']?? null;
        $this->nombre = $args['nombre']??'';
        $this->email = $args['email']??'';
        $this->password = $args['password']??'';
        $this->password_actual = $args['password_actual']??'';
        $this->password_nuevo = $args['password_nuevo']??'';
        $this->password = $args['password']??'';
        $this->token = $args['token']??'';
        $this->confirmado = $args['confirmado']?? 0 ;
        
    }
    public function comprobar_password(){
        return password_verify($this->password_actual, $this->password);
    }
    public function nuevo_password(){
        if (!$this->password_actual) {
            self::$alertas['error'][] = 'ocupas ingresar tu password actual';
        }
        if (!$this->password_nuevo) {
            self::$alertas['error'][] = 'ocupas ingresar un password nuevo';
        }
        if (strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'ocupas ingresar un password con mas de 6 caracteres';
        }
        return self::$alertas;
    }
    public function validarPerfil()
    {
            if (!$this->nombre) {
                self::$alertas['error'][]  = 'el nombre es obligatorio';
            }
            if (!$this->email) {
                self::$alertas['error'][]  = 'el E-mail es obligatorio';
            }
            return self::$alertas;
        
    }
    public function setErroresForServicesLogin(){
        $options = [
            'nombre' => $this->nombre,
            'email' =>$this->email,
            'password' => $this->password,
            "password2" => $this->password2

        ];
        
        LoginServices::getInfo($options);
    }
    public  function setPasswordEncrypt(){
        $this->password = LoginServices::password_encrypt();
        unset( $this->password2);
      
    }
    public function setToken($e = true){
        $EmailServices = new EmailServices;
        //cuando enviamos el token seteamos de una ves el correo
        $this->token = LoginServices::GenerateToken();
        $SendEmail = [
            "nombre" => $this->nombre,
            "email" => $this->email,
            "token" => $this->token
        ];
       $EmailServices->SendEmailToUser($SendEmail, $e);
    }

}