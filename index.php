<?php
// Session Variablen aktivieren:
session_start();

// Errors aktivieren:
ini_set('display_errors',"1");
error_reporting(E_ALL & ~E_NOTICE);

// include always: DB, View, Libraries
include(__DIR__.'/config/config.php');
include(__DIR__.'/controllers/view_controller.php');


// Debug Session:
debug($_SESSION);

// check for controllers:
if (isset($_GET['controller']) && isset($_GET['action'])) {
	$controller = $_GET['controller'];
	$action = $_GET['action'];
}
else {
	$controller = 'user';
	$action = 'login';
}

// Which Controller needs to be created:
require_once('controllers/' .$controller . '_controller.php');
switch ($controller) {
	
	case "user":
	debug("erzeugt neuen Controller:<br>");
	$controller = new UserController();
	break;
	
	case "questlog":
	debug("erzeuge Questlog controller");
	$controller = new QuestlogController();
	$controller->check_login();
	break;

	case "troop":
	debug("erzeuge Troop controller");
	$controller = new TroopController();
	$controller->check_login();
	break;
	
	default: #Erzeuge UserController mit Login Action
	debug("erzeugt neuen Controller:<br>");
	$controller = new UserController();
	$action = 'login';
	break;
}
	include(__DIR__.'/views/head.php');
	if($action != 'login' && $action != 'register' && $action != 'logout' && $action != 'firstlogin') {
		include(__DIR__.'/views/navigation.php');
	}
	debug("Führt " . $action . " aus:");
		$controller->$action();
	include(__DIR__.'/views/footer.php');
?>