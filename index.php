<?php
require_once './controllers/controller.php';
require_once './model/DataLayer.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$request = $_SERVER['REQUEST_URI'];
$controller = new Controller();
$GLOBALS['datalayer'] = new DataLayer();

switch ($request) {
    case '/AdviseItCapstone/':
        $controller->home();
        break;
    case '/AdviseItCapstone/educationPlan':
        $controller->educationPlan();
        break;
    case '/AdviseItCapstone/admin':
        $controller->admin();
        break;
    case '/AdviseItCapstone/login':
        $controller->login();
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}