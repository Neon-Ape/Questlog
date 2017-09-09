<?php

class ViewController{

	public $output;

	#Login-Kontrolle
	public function check_login() {
		if ($_SESSION['user_id'] == NULL) header("Location:index.php?controller=user&action=firstlogin");
	}
	
	// Konstruktor:
	public function loadtemplate($template) {
		debug("<br>includiert: views/main/".$template."");
		ob_start();
		// Template einbinden (in Buffer):
		include 'views/main/'.$template.'';
		// jetzt ist das Template im Buffer, speichern:
		$output = ob_get_contents();
		//Buffern beenden:
		ob_end_clean();
		debug("Gibt Template aus:", __LINE__);
		return $output;
	}
	
}

?>