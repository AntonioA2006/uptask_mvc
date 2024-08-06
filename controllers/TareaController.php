<?php
namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController{
    public static function index(){
        session_start();
        $proyectoId = $_GET['id'];

        if (!$proyectoId) {
            header("Location: /dashboard");
            return ;
        }
        $proyecto = Proyecto::where('url', $proyectoId);
        if(!$proyecto || $proyecto->propietario_id !== $_SESSION['id']){
            header("Location: /404");
            return;
        }
        $tareas = Tarea::belongsTo('proyecto_id', $proyecto->id);
        
        echo json_encode([
            'tareas' => $tareas
        ]);
    }
    public static function crear(){
         if($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
            $proyecto_id = $_POST['proyecto_id'];
            $proyecto = Proyecto::where('url', $proyecto_id);
            if (!$proyecto || $proyecto->propietario_id !== $_SESSION['id']) {
                $respueste = [
                    'tipo' => 'error',
                    'mensaje' => 'hubo un error al agregar la tarea',
                    'exito' => 'false'
                ];
                echo json_encode($respueste);
                return; 
            }

                $tarea = new Tarea($_POST);
                $tarea->proyecto_id = $proyecto->id;
                $resultado = $tarea->guardar();

                $respueste = [
                    'tipo' => 'success',
                    'mensaje' => 'Tarea Agregada correctamente',
                    'exito' => 'true',
                    'id' => $resultado['id'],
                    'proyecto_id' => $proyecto->id
                ];
                echo json_encode($respueste);
                
            

           
        }
        
    }
    public static function actualizar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $proyecto  = Proyecto::where("url", $_POST['proyecto_id']);
           session_start();
           if (!$proyecto || $proyecto->propietario_id !== $_SESSION['id']) {
            $respueste = [
                'tipo' => 'error',
                'mensaje' => 'hubo un error al actualizar la tarea',
                'exito' => 'false'
            ];
       
            echo json_encode($respueste);
            return; 
        }

        $tarea = new Tarea($_POST);
        $tarea->proyecto_id = $proyecto->id;
        $resultado = $tarea->guardar();

                $respueste = [
                    'tipo' => 'success',
                    'mensaje' => 'Tarea Actualizada correctamente',
                    'exito' => 'true',
                    'id' => $tarea->id,
                    'proyecto_id' => $proyecto->id,
                    'nombre' => $tarea->nombre,
                    'estado' => $tarea->estado
                ];
                echo json_encode($respueste);
        }
    }
    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto  = Proyecto::where("url", $_POST['proyecto_id']);
           session_start();
           if (!$proyecto || $proyecto->propietario_id !== $_SESSION['id']) {
            $respueste = [
                'tipo' => 'error',
                'mensaje' => 'hubo un error al eliminar la tarea',
                'exito' => 'false'
            ];
       
            echo json_encode($respueste);
            return; 
        }

        $tarea = new Tarea($_POST);
         $resultado = $tarea->eliminar();
                if ($resultado) {
                    $respueste = [
                        'tipo' => 'success',
                        'mensaje' => 'Tarea eliminada correctamente',
                        'exito' => 'true'
                    ];
                    echo json_encode($respueste);
                }
               
        }
    }


}