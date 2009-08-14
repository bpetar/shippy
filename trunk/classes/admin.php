<?
class admin{

	var $id;
	var $name;
	var $password;
	var $email;
	var $type;
	var $stores_list = Array();
	var $message = "Morate biti ulogovani i sa pravom administracije da biste gledali ovu stranu."; //message for allowed function

	function login() {
		global $DB;
		$sql = "SELECT * FROM admins WHERE password='".$this->password."' AND name='".$this->name."'";
		$q = new query($DB, $sql);
		if($r = $q->getrow()){
			$this->getById($r["id"]);
			$q->free();
			return true;
		}else {
			$q->free();
			return false;
		}
	}

	function set($id, $name, $password, $email, $type, $stores_list){
		$this->id = $id;
		$this->name = $name;
		$this->password = $password;
		$this->email = $email;
		$this->type = $type;
		$this->stores_list = $stores_list;
	}

  	function getById($id) {
	  	global $DB;
	  	global $su;

	  	$sql = "SELECT * FROM admins WHERE id=".$id;
		$q = new query($DB, $sql);
		if($q->error()){
			$q->free();
			return -1;
		}
		if($r = $q->getrow()){
			$this->id = $r["id"];;
			$this->name = $r["name"];
			$this->password = $r["password"];
			$this->email = $r["email"];
			$this->type = $r["type"];
			$this->stores_list = unserialize($r["stores_list"]);
		}
		$sections = $this->getSections();
		if($r["type"] == $su)
		{
			for($i=0; $i < count($sections); $i++){
				$this->sectionsList[] = $sections[$i]["id"];
				$this->sectionsListName[] = $sections[$i]["name"];
				$this->sectionsListDir[] = $sections[$i]["dir"];
			}
		}
		else
		{
			$this->sectionsList[] = $sections[5]["id"];
			$this->sectionsListName[] = $sections[5]["name"];
			$this->sectionsListDir[] = $sections[5]["dir"];
		}		
		$q->free();
	}

	function getIdByNamePassword($name, $password) {
		global $DB;

		$sql = "SELECT id FROM admins WHERE name='".$name."' AND password='".$password."'";;
		$q = new query($DB);
		$q->query($DB, $sql);
		if ($q->error())
			return -1;

		$r = $q->getrow();
		if ($q->numrows() > 0)
			return $r["id"];
		else return -1;

		$q->free();
  	}

	function insert(){
		global $DB;
		global $su;
		$q = new query($DB);
		$EXIST_ERROR = -99;
		
		$sql = "SELECT * FROM admins WHERE name='".$this->name."'";
		$q->query($DB, $sql);
		if ($q->getrow()){
			$this->id = -1;
			return $EXIST_ERROR;
		}
		$sql = "INSERT INTO admins (id, name, password, email, stores_list, type) VALUES (NULL,
										'".$this->name."',
	    								'".$this->password."',
	    								'".$this->email."',
    									'".serialize($this->stores_list)."',
	    								'".$this->type."')";
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
			$user=new admin;
		  	$user=unserialize($_SESSION['userSS']);
		}else {
			header ("Location:../index.php");
		}
		$q = new query($DB);
		$sql = "SELECT * FROM admins WHERE name='".$this->name."'";
			$q->query($DB, $sql);
			if ($q->numrows()>0){
				$found = $q->getrow();
				if ($found['id'] != $this->id) 
					//$this->id = -1;
					return $EXIST_ERROR;
					
		}
		$sql = "UPDATE admins SET name='".$this->name."',
	    						password='".$this->password."',
		    					email='".$this->email."',
		    					stores_list='".serialize($this->stores_list)."',
		    					type='".$this->type."'
	    						WHERE id=".$this->id;

		$q->query($DB, $sql);
		if ($q->error())
			return -1;

		return 1;
	}

	function delete(){
    	global $DB;
    	$q = new query($DB);

		session_start();
		if (isset($_SESSION['userSS'])) {
		  	$user=new admin;
		  	$user=unserialize($_SESSION['userSS']);
		}else {
			header ("Location:../index.php");
		}
		if ($user->id == $this->id)
			return -1; //admin can't delete self

	    $sql = "DELETE FROM admins WHERE id=".$this->id;
		$q->query($DB, $sql);
		if ($q->error())
			return -5;

		return 1;
	}

	function getTypes(){
		global $su;
		global $editor;

		$types = Array();
		$types[] = $editor;
		$types[] = $su;
		return $types;
	}
	
	function getSections(){
		$sections = Array();
		
		$sect["id"] = 1;
		$sect["name"] = "SISTEM";
		$sect["dir"] = "system";
		$sections[] = $sect;
		
		$sect["id"] = 2;
		$sect["name"] = "PROIZVODI";
		$sect["dir"] = "products";
		$sections[] = $sect;
		
		$sect["id"] = 3;
		$sect["name"] = "PRODAVNICE";
		$sect["dir"] = "stores";
		$sections[] = $sect;
		
		$sect["id"] = 4;
		$sect["name"] = "GRADOVI";
		$sect["dir"] = "city";
		$sections[] = $sect;
		
		$sect["id"] = 5;
		$sect["name"] = "TIPOVI PROIZ.";
		$sect["dir"] = "type";
		$sections[] = $sect;
		
		$sect["id"] = 6;
		$sect["name"] = "CENE";
		$sect["dir"] = "prices";
		$sections[] = $sect;
		
		//$sect["id"] = 7;
		//$sect["name"] = "KORISNICI";
		//$sect["dir"] = "users";
		//$sections[] = $sect;
		
		//$sect["id"] = 8;
		//$sect["name"] = "STATISTIKA";
		//$sect["dir"] = "stats";
		//$sections[] = $sect;

		return $sections;
	}
	
	function isAllowed($sectionId, $storeID) {
	  	global $DB;
	  	global $su;
	  	global $editor;

	  	if ($this->type == $su)
	  		return true;
	  		
		//if(!in_array($sectionId, $this->sectionsList) )
		if($sectionId != 6)
		{
			$this->message = "Nemate prava pristupa administraciji ove sekcije!";
			return false;
		}
		if(!in_array($storeID, $this->stores_list) )
		{
			$this->message = "Nemate prava pristupa administraciji ove prodavnice!";
			return false;
		}
		$this->message = "Odaberite stranu sajta koju imate prava da administrirate.";
		return true;
	}
}
?>