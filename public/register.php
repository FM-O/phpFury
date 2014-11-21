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

$datas = array(
    'auteur' => 'Nicolas Rigal',
    'auteur2' => 'Floriant Michel',
    'application' => array(
        'name' => 'TP-01-PHP',
        'version' => '1.0'
    ),
    'menu' => array(
        'home' => 'index.php',
        'login' => 'login.php',
        'register' => 'register.php'
    ),
    'current' => 'register',
    'tab' => array('20 ans', '60 kg', '175 cm', 'green lover'),
    'tab2' => array('47 ans', '122 kg', '160 cm', 'french lover')
);

echo $twig->render('register.twig', $datas);
