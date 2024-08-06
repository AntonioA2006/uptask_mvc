<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TareaController;
use MVC\Router;
$router = new Router();
    //login
    $router->get('/',[LoginController::class, 'index']);
    $router->post('/',[LoginController::class, 'index']);
    $router->get('/logout',[LoginController::class, 'logout']);
    //crear cuenta
    $router->get('/crear',[LoginController::class, 'crear']);
    $router->post('/crear',[LoginController::class, 'crear']);
    
    //recuperar password
    $router->get('/olvide',[LoginController::class, 'olvide']);
    $router->post('/olvide',[LoginController::class, 'olvide']);

    //restablcer password
    $router->get('/restablecer',[LoginController::class, 'restablecer']);
    $router->post('/restablecer',[LoginController::class, 'restablecer']);

    $router->get('/mensaje',[LoginController::class, 'mensaje']);
    $router->get('/confirmar',[LoginController::class, 'confirmar']);
//zona de proyectos

    $router->get('/dashboard', [DashboardController::class, 'index']);
    $router->get('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
    $router->post('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
    $router->get('/proyecto', [DashboardController::class, 'proyecto']);
    $router->get('/perfil', [DashboardController::class, 'perfil']);

    //API para tarea

    $router->get('/api/tareas',[TareaController::class, 'index']);
    $router->post('/api/tarea', [TareaController::class, 'crear']);
    $router->post('/api/tarea/actualizar', [TareaController::class, 'actualizar']);
    $router->post('/api/tarea/eliminar', [TareaController::class, 'eliminar']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();

?>

