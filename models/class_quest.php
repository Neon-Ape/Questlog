<?php

class Quest {
	
	public $id;
	public $name;
	public $text;
	public $xp;
	public $token;
	public $due;
	public $creator;
	public $steps;



	function __construct($qid, $qname, $qtext, $qxp, $qtoken, $qdue, $qcreator, $qsteps) {
		
		$this->id = $qid;
		$this->name = $qname;
		$this->text = $qtext;
		$this->xp = (int)$qxp;
		$this->token = (int)$qtoken;
		$this->due = $qdue;
		$this->creator = $qcreator;
		$this->steps = $qsteps;

	}
}
