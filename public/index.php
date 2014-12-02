<?php
session_start();

// Compilation et Affichage du template (index.twig)
// Dans le fichier index.twig, le code {{ name }}
// sera remplacé par sa valeur dans le tableau ("World")
if($_SERVER['REQUEST_METHOD'] == 'POST'){


    if(isset($_POST['login']) AND (!empty($_POST['login']))
        AND isset($_POST['password']) AND (!empty($_POST['password']))){

        $log = $_POST['login'];
        $pass = sha1($_POST['password']);

        require_once '../application/models/Database.php';

        try{
            $bdd = new Database();
            $_SESSION['user'] = $bdd->getUserFrom($log, $pass);
            $_SESSION['error_log'] = false;
        }
        catch(Exception $e){
            $_SESSION['error_log'] = true;
            header('Location: login.php');
        }
    }
    else{
        header('Location: login.php');
    }
}

if(isset($_SESSION['user'])){
    $datas = array(
        'user' => true,
        'user_name' => $_SESSION['user'][0],
        'auteur' => 'Nicolas Rigal',
        'auteur2' => 'Florian Michel',
        'application' => array(
            'name' => 'TP-01-PHP',
            'version' => '1.0'
        ),
        'menu' => array(
            'home' => 'index.php',
            'logout' => 'logout.php'
        ),
        'current' => 'home',
        'tab' => array('20 ans', '60 kg', '175 cm', 'green lover'),
        'tab2' => array('47 ans', '122 kg', '160 cm', 'french lover')
    );
}
else{
    $datas = array(
        'auteur' => 'Nicolas Rigal',
        'auteur2' => 'Florian Michel',
        'application' => array(
            'name' => 'TP-01-PHP',
            'version' => '1.0'
        ),
        'menu' => array(
            'home' => 'index.php',
            'login' => 'login.php',
            'register' => 'register.php'
        ),
        'current' => 'home',
        'tab' => array('20 ans', '60 kg', '175 cm', 'green lover'),
        'tab2' => array('47 ans', '122 kg', '160 cm', 'french lover')
    );
}

require_once '../application/models/Viewer.php';

$viewer = new Viewer();
$viewer->render('index.twig', $datas);


