<?php
namespace Services;

interface interfaceServices{
    public static function  validar();
    public static function noErrors():bool;
    public static function getInfo(string $nombre,string $email, string $password, string $password2);
    public static function getErrors(): Array;
}