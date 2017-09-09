<?php

	# benötigte Models laden:	
	include($_SERVER['DOCUMENT_ROOT'].'/questlog/models/class_users.php');
	#include('__DIR__');
	
	class UserController extends ViewController {
		
		public $view;
		public $output;
		public $user;
		public $error;
		public $nameadd;
		
		function __construct() {
			global $DB_con;
			$this->user = new User($DB_con);
			// User hat vielleicht einen Namen:
			if ($_SESSION[user_id] != NULL) {
				$this->user->get_name();
			}
		}
		
		function check_value($val) {
		return (($val != NULL) && (strlen($val) >=3 ) && (strlen($val) <= 60))? NULL : 1 ;
		}
		
		public function check_login () {
			// Weiterleitung bei eingeloggtem User
			debug("Prüft Loginstatus");
			debug($this->user->is_loggedin());
			if ($this->user->is_loggedin()) {
				header("location:index.php?controller=user&action=logout");
				exit;
			}
			debug("Tatsächlicher Wert: ".$_SESSION['user_id']);
		}
		
		public function login() {
			$this->check_login ();
			$this->nameadd = "placeholder='Your Nickname'";
			echo $this->loadtemplate('login_mask.php');

		}
		
			public function firstlogin() {
			$this->title = "<span style=color:red>Bitte zuerst einloggen!</span>";
			$this->login();

		}	
		
		public function validatelogin() {
			$this->check_login ();
			if(($this->user->login($_POST['uname'], $_POST['uname'], $_POST['upass'])) != FALSE){
				$this->user->redirect($_SERVER["PHP_SELF"].'?controller=questlog&action=draw');
			}
			else {
				$this->error =  "User not found or password incorrect.";
				$this->nameadd = "value= ".$_POST['uname'];
				echo $this->loadtemplate('login_mask.php');
			}
		}

		public function register() {
			$this->check_login ();
			echo $this->loadtemplate('register_mask.php');
		}		

		public function validateregister() {
			$errlog = NULL;
			$this->check_login ();
			debug($this->user);
			if ($this->check_value($_POST['uname'])) $errlog['name'] = "<br>Your Username is not valid.";
			if ($this->check_value($_POST['umail'])) $errlog['mail'] = "<br>Your Mail is not valid.";
			if ($this->check_value($_POST['upass'])) $errlog['pass'] =  "<br>Your Password is not valid.";
			if ($this->check_value($_POST['timg'])) $errlog['timg'] =  "<br>Your selected image is not valid.";
			if ($this->check_value($_POST['tform'])) $errlog['tform'] =  "<br>Your selected shape is not valid.";
			if ($this->check_value($_POST['tcolor'])) $errlog['tcolor'] =  "<br>Your selected token color is not valid.";
			if ($this->check_value($_POST['tborder'])) $errlog['tborder'] =  "<br>Your border color is not valid.";
			
			if ($errlog == NULL) {
				debug($this->user, __LINE__, "Debugge User: ");
				$id = ($this->user->register($_POST['uname'], $_POST['umail'], $_POST['upass'], $_POST['timg'], $_POST['tform'], $_POST['tcolor'], $_POST['tborder']));
				if( $id != FALSE){
					$_SESSION['user_id'] = $id;
					header("location:index.php?controller=user&action=intern");
				}
				$errlog['given']= "<br>Nickname or Mail already registered.";
			}
			echo ("Debugging Errors:");
			debug($errlog);
			$this->error =  "Fehler bei Anmeldung.".$errlog['given'].$errlog['name'].$errlog['mail'].$errlog['pass'].$errlog['timg'].$errlog['tform'].$errlog['tcolor'].$errlog['tborder'];
			echo $this->loadtemplate('register_mask.php');
			
			}
	
		public function intern() {
			$this->user->get_name();
			debug($this->user);
			debug($_SESSION);
			$this->namead = "Registrierung erfolgreich.";
			echo $this->loadtemplate('login_mask.php');
		}	
		public function logout() {
			$this->user->logout();
			$this->nameadd = $this->user->name;
			echo $this->loadtemplate('logout_mask.php');
		}	
		

	}



?>