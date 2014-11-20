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
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e){
    die('Erreur:'.$e->getMessage());
}

if(isset($_POST['login']) AND (!empty($_POST['login']))
    AND isset($_POST['password']) AND (!empty($_POST['password']))){

    $log = $_POST['login'];
    $pass = sha1($_POST['password']);

    $query = $bdd->prepare("SELECT COUNT(*) FROM users WHERE login = :login");
    $query->execute(array(
        'login' => $log
    ));
   $result = $query->fetch();

    if($result[0] == 0){
        echo "NO RESULTS";
    }
    else{
         echo "RESULTS FOUND";
    }


}
else{
    header('Location: login.php');
}

$datas = array(
    'auteur' => 'Nicolas Rigal',
    'auteur2' => 'Florian Michel',
    'application' => array(
        'name' => 'TP-01-PHP',
        'version' => '1.0'
    ),
    'menu' => array(
        'login' => 'login.php',
        'register' => 'register.php',
        'home' => 'index.php'
    ),
    'current' => 'home',
    'tab' => array('20 ans', '60 kg', '175 cm', 'green lover'),
    'tab2' => array('47 ans', '122 kg', '160 cm', 'french lover')
);

echo $twig->render('index.twig', $datas);
