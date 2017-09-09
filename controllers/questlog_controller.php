<?php

	# benötigte Models laden:	
	include($_SERVER['DOCUMENT_ROOT'].'/questlog/models/class_questlog.php');
	#include('__DIR__');
	
	class QuestlogController extends ViewController {

		private $questLog;
		public $quests;
		public $view;
		public $users;
		private $db;

		public $armydata;
		public $newaction;
		
		//Style Variablen:
		private $stylestart;
		private $styleend;
	
		function __construct() {
			global $DB_con;
			$this->db = $DB_con;
			$this->questLog = new Questlog($this->db, $_SESSION['user_id']);		
			$this->questLog->get_quests();
			$this->quests = $this->questLog->draw_quests();
			debug($this->quests,"Questlog Controller has quests now");
			// Aktion wenn auf der Karte geklickt wird:
			//$this->newaction =  "controller=map&action=details";
		}
		
		public function draw() {
			$template = 'questlog_mask.php';
			$draw = $this->loadtemplate($template);
			
			echo $draw;
			return $this->quests;
		}

		public function input() {
			$this->users = $this->questLog->get_users();
			debug($this->users);
			
			$template = 'questinput_mask.php';
			$draw = $this->loadtemplate($template);
			
			echo $draw;
			return $this->users;
		}

		public function get_date() {
			return date("d-m-Y",time());
		}

		public function get_users() {
			return $questLog->get_users();
		}

		public function add() {
			$qdue = $_POST['qdue_date']." ".$_POST['qdue_time'];
			$this->questLog->add_quest($_POST['unames'],$_POST['qname'],$_POST['qtext'],$_POST['qxp'],$_POST['qtoken'],$qdue,$_POST['steps']);

			$this->questLog->redirect($_SERVER["PHP_SELF"].'?controller=questlog&action=draw');
		}

		public function setStepStatus() {
			$qid = $_POST['qid'];
			$qsid = $_POST['qsid'];
			if ($_POST['qsstat'] == 0) {
				$qsstat = 1;
			} else {
				$qsstat = 0;
			}
			$this->questLog->update_queststep($qid, $qsid, $qsstat);
		}

		public function button() {
			$qid = (int)$_POST['qid'];

			switch ($_POST['btn_accept']) {
				case 'Accept':
					$this->questLog->update_quest($qid,$this->questLog->statusActive());
					break;
				case 'Decline':
					$this->questLog->decline_quest($qid);
					break;
				case 'I´m done':
					$this->questLog->update_quest($qid,$this->questLog->statusDone());
					break;
				case 'I give up':
					$this->questLog->update_quest($qid,$this->questLog->statusDefault());
					break;
				case 'Retry':
					$this->questLog->update_quest($qid,$this->questLog->statusActive());
					break;
				case 'setStepStatus':
					$this->setStepStatus();
					break;
				default:
					# code...
					break;
			}
			$this->questLog->redirect($_SERVER["PHP_SELF"].'?controller=questlog&action=draw');	
		}
		
	}



?>