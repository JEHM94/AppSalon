<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

//***** Definición de Rutas *****

// ******/ Login y Autenticación // ******/ 
// Iniciar Sesión
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);

// Cerrar Sesión
$router->get('/logout', [LoginController::class, 'logout']);

// Recuperación de Contraseña
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

// Crear Cuenta
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

// Confirmar Cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

// Reenviar Verificación de Cuenta
$router->get('/reenviar', [LoginController::class, 'reenviar']);
// ******/ Login y Autenticación FIN // ******/ 

// ******/ |Area Privada| // ******/ 
// Citas
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/cita/ver', [CitaController::class, 'ver']);

// API Citas
$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'guardar']);
$router->post('/api/eliminarCita', [APIController::class, 'eliminarCita']);
$router->post('/api/eliminarServicio', [APIController::class, 'eliminarServicio']);

// CRUD Servicios
$router->get('/servicios', [ServicioController::class, 'index']);
// Crear Servicio
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
// Actualizar Servicio
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);

// Admin
$router->get('/admin', [AdminController::class, 'index']);

// ******/ |Area Privada| FIN// ******/ 


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
