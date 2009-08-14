<?
class city{
	var $id;
	var $name;
	var $zip;

	function set($id, $name, $zip){
		if ($id != null)
			$this->id = $id;
		$this->name = $name;
		$this->zip = $zip;
	}

  	function getById($id) {
	  	global $DB;

	  	$sql = "SELECT * FROM city WHERE id=".$id;
		$q = new query($DB, $sql);
		if($q->error()){
			$q->free();
			return -1;
		}
		if($r = $q->getrow()){
			$this->id = $r["id"];;
			$this->name = $r["name"];
			$this->zip = $r["zip"];
		}
		$q->free();
	}

	function insert(){
		global $DB;

		$q = new query($DB);
		$EXIST_ERROR = -99;
		$name = strtolower($this->name);
		
		$sql = "SELECT * FROM city WHERE lower(name)='".$name."'";
		$q->query($DB, $sql);
		if ($q->getrow()){
			$this->id = -1;
			return $EXIST_ERROR;
		}
		$sql = "INSERT INTO city (id, name, zip) VALUES (NULL,
										'".$this->name."',
										".$this->zip.")";
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
		$EXIST_ERROR = -99;
		$q = new query($DB);
		$sql = "UPDATE city SET name='".$this->name."',
		    					zip=".$this->zip." 
	    						WHERE id=".$this->id;

		$q->query($DB, $sql);
		if ($q->error())
			return -1;

		return 1;
	}

	function delete(){
    	global $DB;
    	$q = new query($DB);
    	$sql = "SELECT id FROM stores WHERE city_id=".$this->id." LIMIT 1";
    	$q->query($DB, $sql);
		if ($q->error())
		{
			$q->free();
			return -1;
		}
		$row = $q->getrow();
		if (empty($row))
		{
			$sql = "DELETE FROM city WHERE id=".$this->id;
			$q->query($DB, $sql);
			if ($q->error())
			{
				$q->free();
				return -1;
			}
	
			$q->free();
			return 1;
		}
		
		$q->free();
		return -2;
	}
	
	function getAllCities(){
		global $DB;

		$result = Array();
		$sql = "SELECT id, name FROM city ORDER BY name ASC";
		$q = new query($DB, $sql);
		$q->query($DB, $sql);
		if ($q->error())
			return $result;
		while($row = $q->getrow()){
			$result[] = $row;
		}

		return $result;
	}
}
?>