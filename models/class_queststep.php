<?php

class Queststep {
	
	public $id;
	public $name;
	public $xp;
	public $token;
	public $status;
	public $finishedBy;

	function __construct($id, $name, $xp, $token, $status, $finishedBy) {
		
		$this->id = $id;
		$this->name = $name;
		$this->xp = $xp;
		$this->token = $token;
		$this->status = $status;
		$this->finishedBy = $finishedBy;

	}
}
