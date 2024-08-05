<?php
namespace Controllers;

use Model\Proyecto;
use MVC\Router;
use Services\ProyectoServices;

class DashboardController{
    public static function index(Router $router){
        session_start();
        isAuth();

        $id = $_SESSION['id'];

       $proyectos = Proyecto::belongsTo('propietario_id', $id);
        


        $router->render('dashboard/index',[
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }
    public static function crear_proyecto(Router $router){
     
        session_start();
        isAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            
               $proyecto = new Proyecto($_POST);
               $proyecto->setErroresForProjectServices();
               $alertas = ProyectoServices::validar();
                if (ProyectoServices::noErrors()) {
                     $proyecto->url = md5(uniqid()); 
                     $proyecto->propietario_id = $_SESSION['id'];
                    $proyecto->guardar();
                    header("Location: /proyecto?id=". $proyecto->url);
                }   
        }
        $alertas= ProyectoServices::getErrors();
        

        $router->render('dashboard/crear-proyecto',[
            'titulo' => "Crea tu proyecto",
            'alertas' => $alertas
        ]);
    }
    public static function perfil(Router $router){
        session_start();
       

        $router->render('dashboard/perfil',[
            'titulo' => "tu perfil"
        ]);
    }
    public static function proyecto(Router $router){
        session_start();
        isAuth();
        $token = $_GET['id'];
        if (!$token) {
           header("Location: /proyectos");
        }
        $proyecto = Proyecto::where('url', $token);
        if ($proyecto->propietario_id !== $_SESSION['id']) {
            header("Location: /proyectos");
        }

        $router->render("dashboard/proyecto",[
            'titulo' => $proyecto->proyecto
        ]);
    }
    
}
