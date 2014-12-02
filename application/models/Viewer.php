<?php
/**
 * Created by IntelliJ IDEA.
 * User: flo
 * Date: 02/12/14
 * Time: 10:37
 */

class Viewer{
    private $twig;

    public function __construct(){
        // Auto chargement des dépendences Composer
        require_once '../vendor/autoload.php';
        // Création d'un loader TWIG,
        // pour qu'il recherche les templates dans le répertoire application/views
        $loader = new Twig_Loader_Filesystem('../application/views');
        // Création d'une instance de Twig
        $this->twig = new Twig_Environment($loader);
    }
    public function render($page, $datas){
        echo $this->twig->render($page, $datas);
    }
}