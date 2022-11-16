<?php
require_once 'route.php';
require_once './Controller/apiVuelingController.php';
require_once './Controller/apiVentasController.php';


// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('vuelo', 'GET', 'ApiVuelingController', 'getVuelos');
$router->addRoute('vuelo/:ID', 'GET', 'ApiVuelingController', 'getVuelo');
$router->addRoute('vuelo/:ID', 'DELETE', 'ApiVuelingController', 'deleteVuelo');
$router->addRoute('vuelo', 'POST', 'ApiVuelingController', 'insertVuelo'); 

$router->addRoute('venta', 'GET', 'ApiVentasController', 'getVentas');
$router->addRoute('venta/:ID', 'GET', 'ApiVentasController', 'getVenta');
$router->addRoute('venta/:ID', 'DELETE', 'ApiVentasController', 'deleteVenta');
$router->addRoute('venta', 'POST', 'ApiVentasController', 'insertVenta'); 


// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);