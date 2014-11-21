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
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    try{
        $bdd = new PDO('mysql:host=localhost;dbname=mycroblog', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e){
        die('Erreur:'.$e->getMessage());
    }

    if(isset($_POST['login']) AND (!empty($_POST['login']))
        AND isset($_POST['password']) AND (!empty($_POST['password']))){

        $log = $_POST['login'];
        $pass = sha1($_POST['password']);

        $query = $bdd->prepare("SELECT COUNT(*) FROM users WHERE login = :login AND password = :password");
        $query->execute(array(
            'login' => $log,
            'password' => $pass
        ));
       $result = $query->fetch();

        if($result[0] == 0){
            header('Location: login.php');
            $_SESSION['error_log'] = true;
        }
        else{
            $request = $bdd->prepare("SELECT login, password FROM users WHERE login = :login AND password = :password");
            $request->execute(array(
                'login' => $log,
                'password' => $pass
            ));
            $logs_result = $request->fetch();
            $_SESSION['login'] = $logs_result['login'];
            $_SESSION['password'] = $logs_result['password'];
            $_SESSION['error_log'] = false;
        }


    }
    else{
        header('Location: login.php');
    }
}

if(isset($_SESSION['login']) AND isset($_SESSION['password'])){
    $datas = array(
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

echo $twig->render('index.twig', $datas);
