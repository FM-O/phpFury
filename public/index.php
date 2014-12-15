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
        case "profile":
            $controller->profile();
            break;
        case "index":
            $controller->index();
            break;
        case "logout":
            $controller->logout();
            break;
    }
} else {
    $controller->index();
}

// REWRITE URl'S TO DO