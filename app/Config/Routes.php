<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

//http://localhost:8080/api
$routes->group('api', ['namespace' => 'App\Controllers\API' ], function($routes){

//   http://localhost:8080/api/Clientes --> GET
$routes->get('clientes', 'Clientes::index');
$routes->post('clientes/create', 'Clientes::create');
$routes->get('clientes/edit/(:num)', 'Clientes::edit/$1');
$routes->put('clientes/update/(:num)', 'Clientes::update/$1');
$routes->delete('clientes/delete/(:num)', 'Clientes::delete/$1');

}) ;

// Cuentas

$routes->get('cuentas', 'CuentasController::index');
$routes->get('cuentas/{id}', 'CuentasController::show');
$routes->post('cuentas', 'CuentasController::create');
$routes->put('cuentas/{id}', 'CuentasController::update');
$routes->delete('cuentas/{id}', 'CuentasController::delete');


// Transacciones

$routes->get('transacciones', 'TransaccionesController::index');
$routes->get('transacciones/{id}', 'TransaccionesController::show');
$routes->post('transacciones', 'TransaccionesController::create');
$routes->put('transacciones/{id}', 'TransaccionesController::update');
$routes->put('transacciones/cliente/{id}', 'TransaccionesController::getTrasaccionesByCliente');
$routes->delete('transacciones/{id}', 'TransaccionesController::delete');




/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
