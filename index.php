<?php
require_once './controllers/controller.php';
require_once './model/DataLayer.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$controller = new Controller();
$GLOBALS['datalayer'] = new DataLayer();

// Get project file path relative to root (e.g. "/485/adviseitcapstone")
$PROJECT_DIR = dirname($_SERVER['PHP_SELF']);
//echo "Project Directory: " . $PROJECT_DIR ." ";
//echo "Request URI: " . $_SERVER['REQUEST_URI'] . " ";

// Subtract project directory path from request to get relative request path
$request = substr($_SERVER['REQUEST_URI'], strlen($PROJECT_DIR));
//echo "Request:" . $request;

switch ($request) {
    case '/':
    case '':
        // Handle post (login)
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $controller->login();
        }
        else {
            $controller->home();
        }
        break;
    case '/plan':
        $controller->educationPlan();
        break;
    case '/admin':
        $controller->admin();
        break;
    case '/logout':
        $controller->logout();
        break;
    default:
        http_response_code(404);
        require __DIR__ . ("/views/404.php");
        break;
}