<?php

class Controller{


    /**
    * @var Viewer
    */
    private $viewer;

    /**
    * @var Database
    */
    private $db;

    public function __construct(){
        require_once '../application/models/Viewer.php';
        require_once '../application/models/Database.php';
        $this->viewer = new Viewer();
        $this->db = new Database();
    }

    public function index(){
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
        $viewer = new Viewer();
        $viewer->render('index.twig', $datas);
    }

    public function login(){
        session_start();

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

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(isset($_POST['login']) AND (!empty($_POST['login']))
                AND isset($_POST['password']) AND (!empty($_POST['password']))
                AND isset($_POST['email']) AND (!empty($_POST['email']))) {

                if(preg_match('#^[_a-z0-9._-]+@[_a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['email'])){

                    if($_POST['password'] == $_POST['confirm']){
                        $log = $_POST['login'];
                        $pass = sha1($_POST['password']);
                        $mail = $_POST['email'];

                        require_once '../application/models/Database.php';
                        $db = new Database();
                        $db->saveUser($log, $pass, $mail);
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

        require_once '../application/controllers/Controller.php';

        $viewer = new Viewer();
        $viewer->render('login.twig', $datas);

        if($error_log == true){
            session_destroy();
        }
    }

    public function register(){
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

        $viewer = new Viewer();
        $viewer->render('register.twig', $datas);
    }

    public function logout(){
        session_start();
        session_destroy();

        header('Location: index.php');
    }
}