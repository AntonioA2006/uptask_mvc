<?php
namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;
use Services\LoginServices;
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
        isAuth();
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            /*  en esta oarte utilize el modelo para validar en vez de un service ya que es*/
                     $alertas =  $usuario->validarPerfil();
             /*   una validacion algo corta y no em valia la pena poner otro services '(;' ) */
            
            if(empty($alertas)){
                $existeUsuario = Usuario::where('email', $usuario->email);
                if($existeUsuario && $existeUsuario->id !== $usuario->id){
                    Usuario::setAlerta('error', 'el usuario ya existe');
                    
                }else{

                    $_SESSION['nombre'] = $usuario->nombre;
                    Usuario::setAlerta('exito', 'guardado correcatamente');
                   $usuario->guardar();


                }  
            }
        }



        $alertas = Usuario::getAlertas();
        $router->render('dashboard/perfil',[
            'titulo' => "tu perfil",
            'usuario' => $usuario,
            'alertas' => $alertas
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
    public static function cambiar_password(Router $router){
        session_start();
        isAuth();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $usuario = Usuario::find($_SESSION['id']);
                $usuario->sincronizar($_POST);
                $alertas = $usuario->nuevo_password();
                if(empty($alertas)){
                    
                    $resultado = $usuario->comprobar_password();
                    
                   if ($resultado) {
                    unset($usuario->password_actual);
                    $usuario->password = password_hash($usuario->password_nuevo,PASSWORD_BCRYPT);
                    unset($usuario->password_nuevo);
                   $resultado =  $usuario->guardar();
                   if ($resultado) {
                        Usuario::setAlerta('exito', 'tu password se a cambiado exitosamente');
                   }
                   }else{
                    Usuario::setAlerta('error', 'el password actual no es el correcto');
                   }
                }
        }
        $alertas = Usuario::getAlertas();
        $router->render('dashboard/cambiar-password',[
            'titulo' => 'cambiar password',
            'alertas' => $alertas
        ]);

    }
    
}
