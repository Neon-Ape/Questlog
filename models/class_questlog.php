<?php

# benötigt Felder:
include($_SERVER['DOCUMENT_ROOT'].'/questlog/models/class_quest.php');
include($_SERVER['DOCUMENT_ROOT'].'/questlog/models/class_queststep.php');


class Questlog
{
    private $db;
    private $user_id;
    private $openQuests;
    private $activeQuests;
    private $finishedQuests;


    private $STATUS_DEFAULT = "open";
    private $STATUS_PROGRESS = "active";
    private $STATUS_DONE = "finished";
	
    function __construct($DB_con, $user_id) {
      $this->db = $DB_con;
      $this->user_id = (int)$user_id;
	  $this->openQuests = array();
	  $this->activeQuests = array();
	  $this->finishedQuests = array();
    }
 


    public function get_quests() {
        $queststeps = $this->get_queststeps();
        $stmt = $this->db->prepare("SELECT q.quest_id, q.quest_name, q.quest_text, q.quest_xp, q.quest_token, q.quest_due, s.quest_start, s.quest_status, u.user_name 
                                    FROM quests q, quest_status s, users u 
                                    WHERE s.user_id = '$this->user_id' AND s.quest_id = q.quest_id AND s.user_id = u.user_id
                                    ORDER BY q.quest_due DESC;");

        $stmt->execute(); 
        $this->sort_quests($stmt, $queststeps);
    }

    public function get_queststeps() {
        debug(NULL, "starting get_queststeps");
        $stmt = $this->db->prepare("SELECT s.quest_id, q.queststep_id, q.queststep_name, q.queststep_xp, q.queststep_token, q.queststep_status, u.user_name 
                                    FROM quest_steps q
                                    INNER JOIN quest_status s
                                    ON s.quest_id = q.quest_id 
                                    LEFT OUTER JOIN users u
                                    ON q.finished_by = u.user_id
                                    WHERE s.user_id = '$this->user_id' 
                                    ORDER BY q.quest_id, q.queststep_id ASC;");
        $stmt->execute(); 

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            debug($data, "Raw SQL data from get_quests()");
            $queststeps[$data['quest_id']][$data['queststep_id']] = 
            new Queststep($data['queststep_id'], 
                        $data['queststep_name'], 
                        $data['queststep_xp'],
                        $data['queststep_token'],
                        $data['queststep_status'], 
                        $data['user_name']); 
        }

        return $queststeps;   
    }

    public function get_users() {
        $stmt = $this->db->prepare("SELECT user_id, user_name
                                    FROM users
                                    ORDER BY user_name ASC;");
        $stmt->execute(); 

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            debug($data, "Raw SQL data from get_users()");
            $users[$data['user_id']] = $data["user_name"];
        }

        return $users;   
    }

	private function sort_quests($stmt, $queststeps) {
		while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
			debug($data, "Raw SQL data from get_quests()");
            debug($queststeps, "Queststep data from get_queststeps()");
			$quest = new Quest($data['quest_id'],
								$data['quest_name'], 
								$data['quest_text'], 
								$data['quest_xp'], 
								$data['quest_token'], 
								$data['quest_due'],
                                $data['user_name'],
                                $queststeps[$data['quest_id']]);
			debug($quest,"Neue Quest erstellt"); 

			switch ($data['quest_status']) {
				case 'open':
					$this->openQuests[] = $quest;
					debug($this->openQuests,"openQuests:");
					break;
				case 'active':
					$this->activeQuests[] = $quest;
					debug($this->activeQuests);
					break;
				case 'finished':
					$this->finishedQuests[] = $quest;
					debug($this->finishedQuests);
					break;
			}
		}
	}

	public function add_quest($unames,$qname,$qtext,$qxp,$qtoken,$qdue,$qsteps) {

		// Add the quest to the quests table

		$stmt = $this->db->prepare("INSERT INTO quests(quest_name, quest_text, quest_xp, quest_token, quest_due, quest_creator) 
                                    VALUES(:qname, :qtext, :qxp, :qtoken, :qdue, :qcreate)");
        $stmt->bindparam(":qname", $qname);
        $stmt->bindparam(":qtext", $qtext);
        $stmt->bindparam(":qxp", $qxp);  
        $stmt->bindparam(":qtoken", $qtoken);
        $stmt->bindparam(":qdue", $qdue); 
        $stmt->bindparam(":qcreate", $this->user_id); 
        debug($stmt, "INSERT INTO quests");   
        $stmt->execute();

        // Add the quest to quest_status once for each user in $unames

        $qid = (int)$this->db->lastInsertId();
        debug($qid);
        $uid = 2;
   		$stmt = $this->db->prepare("INSERT INTO quest_status(quest_id, user_id, quest_status) 
                                	VALUES(:qid, :uid, :qstat)");
   		$stmt->bindparam(":qid", $qid);
        
        $stmt->bindparam(":qstat", $this->STATUS_DEFAULT);    
        debug($unames);
        foreach ($unames as &$uid) {
        	$uid = (int)$uid;
        	debug($stmt, "INSERT INTO quest_status");
        	debug($uid, "user_id");
        	$stmt->bindparam(":uid", $uid);
        	$stmt->execute();
        }

        // Add quest steps to quest_steps

        $stmt = $this->db->prepare("INSERT INTO quest_steps(quest_id, queststep_id, queststep_name, queststep_xp, queststep_token) 
                                    VALUES(:qid, :qsid, :qsname, :qsxp, :qstoken)");
        $stmt->bindparam(":qid", $qid);

        for ($i=0; $i < sizeof($qsteps); $i++) { 
            $stmt->bindparam(":qsid", $i);
            $stmt->bindparam(":qsname", $qsteps[$i]['name']);
            $stmt->bindparam(":qsxp", $qsteps[$i]['xp']);
            $stmt->bindparam(":qstoken", $qsteps[$i]['token']);
            $stmt->execute();
        }

	}

	public function update_quest($qid, $qstat) {
		$stmt = $this->db->prepare("UPDATE quest_status 
                                	SET quest_status = :qstat
                                	WHERE user_id = :uid AND quest_id = :qid");
   		$stmt->bindparam(":qid", $qid);
        $stmt->bindparam(":uid", $this->user_id);
        $stmt->bindparam(":qstat", $qstat);  
        $stmt->execute();
	}

    public function update_queststep($qid, $qsid, $qsstat) {
        $empty = NULL;
        $stmt = $this->db->prepare("UPDATE quest_steps
                                    SET queststep_status = :qsstat, finished_by = :fb
                                    WHERE queststep_id = :qsid AND quest_id = :qid");
        $stmt->bindparam(":qid", $qid);
        $stmt->bindparam(":qsid", $qsid);
        if ($qsstat == 1) {
            $stmt->bindparam(":fb", $this->user_id);
        } else {
            $stmt->bindparam(":fb", $empty);
        } 
        $stmt->bindparam(":qsstat", $qsstat);  
        $stmt->execute();
    }

	public function decline_quest($qid) {
   		$stmt = $this->db->prepare("DELETE FROM quest_status 
                                	WHERE user_id = :uid AND quest_id = :qid");
   		$stmt->bindparam(":qid", $qid);
        $stmt->bindparam(":uid", $this->user_id); 
        $stmt->execute();
	}

	
	public function draw_quests() {
		$quests = array(
					'open' => $this->openQuests, 
					'active' => $this->activeQuests, 
					'finished' => $this->finishedQuests
					);
		debug($quests,"draw_quest() return value");
		return $quests;
	}

	public function redirect($url)
    {
       header("Location: $url");
    }

    public function statusDefault() {
    	return $this->STATUS_DEFAULT;
    }

    public function statusActive() {
    	return $this->STATUS_PROGRESS;
    }

    public function statusDone() {
    	return $this->STATUS_DONE;
    }
}


?>