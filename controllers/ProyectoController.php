<?php

namespace Controllers;

use Model\Proyecto;

class ProyectoController{
    public static function deleted(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $url  = $_POST['url'];
            $proyecto  = Proyecto::where('url', $url);
            $resultado = $proyecto->eliminar();

            if ($resultado) {
               $respuesta = [
                    'result' => 'success',
                    'mensaje' => 'eliminado correctamente'
               ];
            }else{
                $respuesta = [
                    'result' => 'error',
                    'mensaje' => 'no se pudo elimnar prurbe mas tarde'
               ];
            }

            echo json_encode($respuesta);

        }   
    }
}