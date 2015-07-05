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
        require_once '../application/models/User.php';
        session_start();
        // Compilation et Affichage du template (index.twig)
        // Dans le fichier index.twig, le code {{ name }}
        // sera remplacé par sa valeur dans le tableau ("World")
        if($_SERVER['REQUEST_METHOD'] == 'POST'){


            if(isset($_POST['login']) AND (!empty($_POST['login']))
                AND isset($_POST['password']) AND (!empty($_POST['password']))){

                $log = $_POST['login'];
                $pass = sha1($_POST['password']);

                try{
                    $bdd = $this->db;
                    $_SESSION['user'] = $bdd->getUserFrom($log, $pass);
                    $_SESSION['error_log'] = false;
                    header('Location: profile');
                }
                catch(Exception $e){
                    $_SESSION['error_log'] = true;
                    header('Location: login');
                }
            }
            else{
                header('Location: login');
            }
        }

        if(isset($_SESSION['user'])){

		    $messages = $this->db->getAllMessages();
            $users = $this->db->getAllUsers();

		    $registered = true;

            $datas = array(
                'user' => true,
                'user_name' => $_SESSION['user'],
                'auteur' => 'Nicolas Rigal (Co-fondateur)',
                'auteur2' => 'Florian Michel (Fondateur)',
                'application' => array(
                    'name' => 'Colloc\'DIM',
                    'version' => '1.0'
                ),

				'logged' => $registered,

				'allMessages' => $messages,

                'allUsers' => $users,

                'menu' => array(
                    'home' => 'index',
                    'profile' => 'profile',
                    'logout' => 'logout'
                ),
                'current' => 'home',
                'tab' => array('20 ans', '60 kg', '175 cm', 'green lover'),
                'tab2' => array('47 ans', '122 kg', '160 cm', 'french lover')
            );
        }
        else{
			$registered = false;

            $datas = array(
                'auteur' => 'Nicolas Rigal (Co-fondateur)',
                'auteur2' => 'Florian Michel (Fondateur)',
                'application' => array(
                    'name' => 'Colloc\'DIM',
                    'version' => '1.0'
                ),
                'menu' => array(
                    'home' => 'index',
                    'login' => 'login',
                    'register' => 'register'
                ),
                'current' => 'home',
                'tab' => array('20 ans', '60 kg', '175 cm', 'green lover'),
                'tab2' => array('47 ans', '122 kg', '160 cm', 'french lover')
            );
        }
        $viewer = $this->viewer;
        $viewer->render('index.twig', $datas);
    }

    public function profile(){
        require_once '../application/models/User.php';
        session_start();

        $_SESSION['error_type'] = false;
        $_SESSION['error_hobbies'] = false;

        $log = $_SESSION['user']->getLogin();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (isset($_POST['message'])) {
                if (!empty($_POST['message']) AND strlen(utf8_decode($_POST['message'])) <= 140) {

                    $message = $_POST['message'];

                    $db = $this->db;
                    $db->saveMessage($message, $log);

                } else {
                    $_SESSION['error_type'] = true;
                }
            }
            if (isset($_POST['description'])) {
                if (isset($_POST['collocation'])) {
                    if (isset($_POST['city'])) {
                        if (isset($_POST['company'])) {

                            $description = $_POST['description'];
                            $colloc = $_POST['collocation'];
                            $city = $_POST['city'];
                            $company = $_POST['company'];
                            if (isset($_POST['display-mail'])) {
                                $visible_mail = true;
                            } else {
                                $visible_mail = false;
                            }

                            $this->db->updateDescription($description, trim($city), $colloc, trim($company), $visible_mail, $log);

                            $pass = $_SESSION['user']->getPassword();
                            $_SESSION['user'] = $this->db->getUserFrom($log, $pass);
                        }
                    }
                } else {
                    echo 'ERROR has occurred';
                }
            }
            if (isset($_POST['hobby'])) {
                $hobbies_insert = null;
                $regex_error = array();
                if (!empty($_POST['hobby'])) {
                    foreach ($_POST["hobby"] as $value) {
                        if(!empty($value)) {
                            if (preg_match("#^[a-z0-9 .äàâçùûçéèêëîïöô-]+$#ui", $value)) {
                                array_push($regex_error, false);
                            } else {
                                array_push($regex_error, true);
                            }
                        }
                        $hobbies_insert .= trim($value).',';
                    }
                    if (!in_array(true, $regex_error)) {
                        $this->db->updateComplementary(rtrim($hobbies_insert, ","), $log);
                        $_SESSION['error_hobbies'] = false;
                    } else {
                        echo "REGEX ERROR";
                        $_SESSION['error_hobbies'] = true;
                    }
                }
            }
        }

        if(isset($_SESSION['user'])){

			if($_SESSION['error_type'] == true) {
				$error_type = true;
				unset($_SESSION['error_type']);
			} else {
				$error_type = false;
                unset($_SESSION['error_type']);
			}

            if($_SESSION['error_hobbies'] == true) {
                $error_hobbies = true;
                unset($_SESSION['error_hobbies']);
            } else {
                $error_hobbies = false;
                unset($_SESSION['error_hobbies']);
            }

            $user = $_SESSION['user']->getLogin();

            $messages = $this->db->getMessages($user);

            $datas = array(
				'error_type' => $error_type,
                'error_hobbies' => $error_hobbies,
                'user' => true,
                'user_name' => $user,
                'user_generic' => $_SESSION['user'],
                'auteur' => 'Nicolas Rigal (Co-fondateur)',
                'auteur2' => 'Florian Michel (Fondateur)',
                'application' => array(
                    'name' => 'Colloc\'DIM',
                    'version' => '1.0'
                ),
                'messages' => $messages,

                'menu' => array(
                    'home' => 'index',
                    'profile' => 'profile',
                    'logout' => 'logout'
                ),
                'current' => 'profile',
                'tab' => array('20 ans', '60 kg', '175 cm', 'green lover'),
                'tab2' => array('47 ans', '122 kg', '160 cm', 'french lover')
            );
        }
        else{
            $datas = NULL;
            header('Location: login');
        }
        $viewer = $this->viewer;
        $viewer->render('profile.twig', $datas);
    }

    public function login(){
        session_start();

        // Compilation et Affichage du template (index.twig)
        // Dans le fichier index.twig, le code {{ name }}
        // sera remplacé par sa valeur dans le tableau ("World")

        if(isset($_SESSION['error_log'])){
            if($_SESSION['error_log'] === true){
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
            'auteur' => 'Nicolas Rigal (Co-fondateur)',
            'auteur2' => 'Floriant Michel (Fondateur)',
            'error_log' => $error_log,
            'application' => array(
                'name' => 'Colloc\'DIM',
                'version' => '1.0'
            ),
            'menu' => array(
                'home' => 'index',
                'login' => 'login',
                'register' => 'register'
            ),
            'current' => 'login',
            'tab' => array('20 ans', '60 kg', '175 cm', 'green lover'),
            'tab2' => array('47 ans', '122 kg', '160 cm', 'french lover')
        );

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(isset($_POST['login']) AND (!empty($_POST['login']))
                AND isset($_POST['password']) AND (!empty($_POST['password']))
                AND isset($_POST['email']) AND (!empty($_POST['email']))) {

                if(preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i', trim($_POST['email']))){

                    if($_POST['password'] == $_POST['confirm']){
                        $log = $_POST['login'];
                        $pass = sha1($_POST['password']);
                        $mail = $_POST['email'];

                        $db = $this->db;
                        $db->saveUser($log, $pass, $mail);
                    }
                    else{
                        $_SESSION['confirm_error'] = true;
                        header('Location: register');
                    }

                }
                else{
                    $_SESSION['mail_error'] = true;
                    header('Location: register');
                }

            }
            else{
                $_SESSION['empty_fields'] = true;
                header('Location: register');
            }
        }

        $viewer = $this->viewer;
        $viewer->render('login.twig', $datas);

        if($error_log == true){
            session_destroy();
        }
    }

    public function register(){
        session_start();


            if(isset($_SESSION['empty_fields']) AND $_SESSION['empty_fields'] === true){
                $empty_fields = true;
                $mail_error = false;
                $confirm_error = false;
                $error_register = true;
            }
            elseif(isset($_SESSION['mail_error']) AND $_SESSION['mail_error'] === true){
                $mail_error = true;
                $empty_fields = false;
                $confirm_error = false;
                $error_register = true;
            }
            elseif(isset($_SESSION['confirm_error']) AND $_SESSION['confirm_error'] === true){
                $confirm_error = true;
                $empty_fields = false;
                $mail_error = false;
                $error_register = true;
            }
            else{
                $empty_fields = false;
                $mail_error = false;
                $confirm_error = false;
                $error_register = false;
            }


        session_destroy();
        // Compilation et Affichage du template (index.twig)
        // Dans le fichier index.twig, le code {{ name }}
        // sera remplacé par sa valeur dans le tableau ("World")
        $datas = array(
            'error_register' => array(
                'error' => $error_register,
                'empty_fields' => $empty_fields,
                'mail_error' => $mail_error,
                'confirm_error' => $confirm_error
            ),
            'auteur' => 'Nicolas Rigal (Co-fondateur)',
            'auteur2' => 'Floriant Michel (Fondateur)',
            'application' => array(
                'name' => 'Colloc\'DIM',
                'version' => '1.0'
            ),
            'menu' => array(
                'home' => 'index',
                'login' => 'login',
                'register' => 'register'
            ),
            'current' => 'register',
            'tab' => array('20 ans', '60 kg', '175 cm', 'green lover'),
                    'tab2' => array('47 ans', '122 kg', '160 cm', 'french lover')
        );

        $viewer = $this->viewer;
        $viewer->render('register.twig', $datas);
    }

    public function logout(){
        session_start();
        session_destroy();

        header('Location: index');
    }
}
