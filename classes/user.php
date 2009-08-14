<?
class user{
	var $id;
	var $name;
	var $password;
	var $email;
	var $date;
	var $ip;
	var $message = "Morate biti ulogovani da biste gledali ovu stranu."; //message for allowed function

	function login() {
		global $DB;
		$sql = "SELECT * FROM USERS WHERE PASSWORD='".$this->password."' AND NAME='".$this->name."' AND ENABLED = 1";
		$q = new query($DB, $sql);
		if($r = $q->getrow()){
			$this->getById($r["ID"]);
			$q->free();
			return true;
		}else {
			$q->free();
			return false;
		}
	}

	function set($id, $name, $password, $email, $date, $ip){
		$this->id = $id;
		$this->name = $name;
		$this->password = $password;
		$this->email = $email;
		$this->date = $date;
		$this->ip = $ip;
	}

  	function getById($id) {
	  	global $DB;

	  	$sql = "SELECT * FROM USERS WHERE id=".$id;
		$q = new query($DB, $sql);
		if($q->error()){
			$q->free();
			return -1;
		}
		if($r = $q->getrow()){
			$this->id = $r["ID"];;
			$this->name = $r["NAME"];
			$this->password = $r["PASSWORD"];
			$this->email = $r["EMAIL"];
			$this->date = $r["DATE"];
			$this->ip = $r["IP"];
		}
		$q->free();
	}

	function getIdByNamePassword($name, $password) {
		global $DB;

		$sql = "SELECT ID FROM USERS WHERE NAME='".$name."' AND PASSWORD='".$password."'";;
		$q = new query($DB);
		$q->query($DB, $sql);
		if ($q->error())
			return -1;

		$r = $q->getrow();
		if ($q->numrows() > 0)
			return $r["ID"];
		else return -1;

		$q->free();
  	}

	function insertUser(){
		global $DB;
		global $su;
		$q = new query($DB);
		$EXIST_ERROR = -99;
		
		$sql = "SELECT * FROM USERS WHERE NAME='".$this->name."'";
		$q->query($DB, $sql);
		if ($q->getrow()){
			$this->id = -1;
			return $EXIST_ERROR;
		}
		$sql = "INSERT INTO USERS (ID, NAME, PASSWORD, EMAIL, DATE, IP) VALUES (NULL,
										'".$this->name."',
	    								'".$this->password."',
	    								'".$this->email."',
	    								'".$this->date."',
	    								'".$this->ip."')";
		$q->query($DB, $sql, true);

		if ($q->error()){
			$this->id = -1;
			return -1;
		} else {
			return $this->id;
		}
	}

	function update(){
		global $DB;
		global $su;
		$EXIST_ERROR = -99;
		session_start();
		if (isset($_SESSION['userSS'])) {
			$user=new user;
		  	$user=unserialize($_SESSION['userSS']);
		}else {
			header ("Location:../index.php");
		}
		$q = new query($DB);
		$sql = "UPDATE USERS SET PASSWORD='".$this->password."',
		    					EMAIL='".$this->email."',
		    					DATE='".$this->date."',
		    					IP='".$this->ip."'
	    						WHERE ID=".$this->id;

		$q->query($DB, $sql);
		if ($q->error())
			return -1;

		return 1;
	}

	function delete(){
    	global $DB;

	    $sql = "UPDATE USERS SET ENABLED=0 WHERE ID=".$this->id;
		$q->query($DB, $sql);
		if ($q->error())
			return -5;

		return 1;
	}
}
?>