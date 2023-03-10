<?php
require_once('./model/Formatter.php');
require_once('./model/Validator.php');
require_once('./model/DataLayer.php');
require_once('./controllers/controller.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$controller = new Controller();
$GLOBALS['datalayer'] = new DataLayer();

// Get project file path relative to root (e.g. "/485/adviseitcapstone")
$PROJECT_DIR = dirname($_SERVER['PHP_SELF']);

// Subtract project directory path from request to get relative request path
$request = substr($_SERVER['REQUEST_URI'], strlen($PROJECT_DIR));

// Parse token if passed in URL
if (substr($request, 0, 5) === "/plan") {
    // Extract token from "/plan/123ABC"
    $token = substr($request, 6);
    // Remove token for switch -> "/plan"
    $request = substr($request, 0, 5);
}

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
        $controller->educationPlan($token);
        break;
    case '/admin':
        $controller->admin();
        break;
    case '/admin-footer-links':
        $controller->adminFooterLinks();
        break;
    case '/logout':
        $controller->logout();
        break;
    default:
        http_response_code(404);
        require __DIR__ . ("/views/404.php");
        break;
}