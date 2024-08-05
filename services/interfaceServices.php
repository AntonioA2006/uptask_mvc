<?php
namespace Services;

interface interfaceServices{
    public static function  validar();
    public static function noErrors():bool;
    public static function getInfo($args = []);
    public static function getErrors(): Array;
}
