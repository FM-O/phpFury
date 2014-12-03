<?php

require_once '../application/controllers/Controller.php';

$controller = new Controller();

if (isset($_GET['action'])) {
    switch($_GET['action']){
        case "login":
            $controller->login();
            break;
        case "register":
            $controller->register();
            break;
        case "logout":
            $controller->logout();
            break;
        case "index":
            $controller->index();
            break;
    }
} else {
    $controller->index();
}

// REWRITE URl'S TO DO