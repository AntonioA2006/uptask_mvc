<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
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



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();