<?php

class User
{
    private $db;
	public $name;
	
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
 
	public function get_name() {
		$stmt = $this->db->prepare("SELECT user_name FROM  users WHERE user_id=:uid;");
        $stmt->bindparam(":uid", $_SESSION['user_id']);
        $stmt->execute(); 
		$user=$stmt->fetch(PDO::FETCH_ASSOC);
		$this->name = $user['user_name'];
	}
 
    public function register($uname,$umail,$upass,$timg,$tform,$tcolor,$tborder)
    {
       try
       {
           $new_password = password_hash($upass, PASSWORD_DEFAULT);
		   $uname = htmlspecialchars($uname);		   
		   $umail = htmlspecialchars($umail);		   
           $stmt = $this->db->prepare("INSERT INTO users(user_name,user_mail,user_pass) 
                                                       VALUES(:uname, :umail, :upass)");
              
           $stmt->bindparam(":uname", $uname);
           $stmt->bindparam(":umail", $umail);
           $stmt->bindparam(":upass", $new_password);            
           $stmt->execute(); 
   
		   $user_id = $this->db->lastInsertId();
       

       $stmt = $this->db->prepare("INSERT INTO tokens(user_id,token_img,token_color,token_border,token_form) 
                                                       VALUES(:uid, :timg, :tcolor, :tborder, :tform)");
           $stmt->bindparam(":uid", $user_id);
           $stmt->bindparam(":timg", $timg);
           $stmt->bindparam(":tcolor", $tcolor);
           $stmt->bindparam(":tborder", $tborder);            
           $stmt->bindparam(":tform", $tform);
           $stmt->execute(); 

        return $user_id;
       }
       catch(PDOException $e)
       {
           return FALSE;
       }    
    }
 
    public function login($uname,$umail,$upass)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM users WHERE user_name=:uname OR user_mail=:umail LIMIT 1");
          $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
             if(password_verify($upass, $userRow['user_pass']))
             {
                $_SESSION['user_name'] = $userRow['user_name'];
                $_SESSION['user_id'] = $userRow['user_id'];
                $stmt = $this->db->prepare("SELECT * FROM tokens WHERE user_id=:uid LIMIT 1");
                $stmt->execute(array(':uid'=>$userRow['user_id']));
                $tokenRow=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0){
                  $_SESSION['token_img'] = $tokenRow['token_img'];
                  $_SESSION['token_color'] = $tokenRow['token_color'];
                  $_SESSION['token_border'] = $tokenRow['token_border'];
                  $_SESSION['token_form'] = $tokenRow['token_form'];
                }
                
                return true;
             }
             else
             {
                return false;
             }
          }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
 
   public function is_loggedin() {
      if($_SESSION['user_id']!= NULL) {
         return 1;
      }
	  return 0;
   }
 
   public function redirect($url)
   {
       header("Location: $url");
   }
 
   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }
}


?>