<?php

namespace Services;
use Services\interfaceServices;
class LoginServices implements interfaceServices{
    private static $nombre = '';
    private static $email = '';
    private static $password = '';
    private static $password2 = '';
    private static $errors = [];

    public static function getInfo(string $nombre,string $email, string $password, string $password2)
    {
            self::$nombre = $nombre;
            self::$email = $email;
            self::$password = $password;
            self::$password2 = $password2;
    }
    public static function validar():array
    {   
        if (!self::$email) {
            self::$errors['error'][] = 'El email es obligatorio';
        }   
        
        if(!filter_var(self::$email,FILTER_VALIDATE_EMAIL)){
            self::$errors['error'][] = 'El email debde der ser valido';
        }
        if (!self::$nombre) {
            self::$errors['error'][] = 'El nombre es oobligatorio';
        }
        if (preg_match(self::$nombre,"/^[a-zA-ZáéíóúñÁÉÍÓÚÑ\s'-]+$/u")) {
            self::$errors['error'][] = 'El nombre es oobligatorio';
        }
        if(!self::$password){
            self::$errors['error'][] = 'El password es oobligatorio';
        }else if(strlen(self::$password) < 5){
            self::$errors['error'][] = 'El password debe ser mayor a 6 caracteres';
        }
        if(!self::$password2){
            self::$errors['error'][] = 'confirma tu password';
        }else if (self::$password !== self::$password2) {
            self::$errors['error'][] = 'los passwords no coinciden';
            # code...
        }

        return self::$errors;
    }
    public static function EmailValidation():array{
        if(!self::$email){
            self::$errors['error'][] = 'el email es obligatorio';
            
        }
        if(!filter_var(self::$email, FILTER_VALIDATE_EMAIL)){
            self::$errors['error'][] = 'el email debe de ser valido';

        }
        return self::$errors;
    }

    public static function password_encrypt():string{

        return password_hash(self::$password,PASSWORD_BCRYPT);
    }

    public static function GenerateToken():string{
        return md5(uniqid());
    }


    public static function noErrors(): bool
    {
        if (!empty(self::$errors)) {
           return false;
        }
        return true;
    }
    public static function getErrors():array{
        return self::$errors;

    }
    public static function setAlerta($tipo,$msg){
        self::$errors[$tipo][] = $msg;
    }
}