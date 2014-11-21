<?php
session_start();
// Auto chargement des dépendences Composer
require_once '../vendor/autoload.php';

// Création d'un loader TWIG,
// pour qu'il recherche les templates dans le répertoire application/views
$loader = new Twig_Loader_Filesystem('../application/views');

// Création d'une instance de Twig
$twig = new Twig_Environment($loader);

// Compilation et Affichage du template (index.twig)
// Dans le fichier index.twig, le code {{ name }}
// sera remplacé par sa valeur dans le tableau ("World")

if(isset($_SESSION['error_log'])){
    if($_SESSION['error_log'] == true){
        $error_log = true;
    }
    else{
        $error_log = false;
    }
}
else{
    $error_log = false;
}

$datas = array(
    'auteur' => 'Nicolas Rigal',
    'auteur2' => 'Floriant Michel',
    'error_log' => $error_log,
    'application' => array(
        'name' => 'TP-01-PHP',
        'version' => '1.0'
    ),
    'menu' => array(
        'home' => 'index.php',
        'login' => 'login.php',
        'register' => 'register.php'
    ),
    'current' => 'login',
    'tab' => array('20 ans', '60 kg', '175 cm', 'green lover'),
    'tab2' => array('47 ans', '122 kg', '160 cm', 'french lover')
);

try{
    $bdd = new PDO('mysql:host=localhost;dbname=mycroblog', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e){
    die('Erreur:'.$e->getMessage());
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['login']) AND (!empty($_POST['login']))
        AND isset($_POST['password']) AND (!empty($_POST['password']))
        AND isset($_POST['email']) AND (!empty($_POST['email']))) {

        if(preg_match('#^[_a-z0-9._-]+@[_a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['email'])){

            if($_POST['password'] == $_POST['confirm']){
                $log = $_POST['login'];
                $pass = sha1($_POST['password']);
                $mail = $_POST['email'];

                $req = $bdd->prepare("INSERT INTO users(email, login, password) VALUES(:email, :log, :pass)");
                $req->execute(array(
                    'email' => $mail,
                    'log' => $log,
                    'pass' => $pass
                ));
            }
            else{
                header('Location: register.php');
            }

        }
        else{
            header('Location: register.php');
        }

    }
    else{
        header('Location: register.php');
    }
}

echo $twig->render('login.twig', $datas);

if($error_log == true){
    session_destroy();
}

