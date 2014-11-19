<?php
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

try{
    $bdd = new PDO('mysql:host=localhost;dbname=mycroblog', 'root', '');
}
catch (Exception $e){
    die('Erreur:'.$e->getMessage());
}

if(isset($_POST['login']) AND (!empty($_POST['login']))
    AND isset($_POST['password']) AND (!empty($_POST['password']))
    AND isset($_POST['email']) AND (!empty($_POST['email']))) {

    if(preg_match('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$', 'flo69001@hotmail.fr')){

        if($_POST['password'] == $_POST['confirm']){
            $log = $_POST['login'];
            $pass = $_POST['password'];
            $mail = $_POST['email'];

            $bdd->exec("INSERT INTO users(id, email, login, password) VALUES('1', '$mail', '$log', '$pass')");
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
echo $twig->render('login.twig');
