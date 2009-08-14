<?
class ptype{
	var $id;
	var $name;

	function set($id, $name){
		if ($id != null)
			$this->id = $id;
		$this->name = $name;
	}

  	function getById($id) {
	  	global $DB;

	  	$sql = "SELECT * FROM p_type WHERE id=".$id;
		$q = new query($DB, $sql);
		if($q->error()){
			$q->free();
			return -1;
		}
		if($r = $q->getrow()){
			$this->id = $r["id"];
			$this->name = $r["name"];
		}
		$q->free();
	}

	function insert(){
		global $DB;

		$q = new query($DB);
		$EXIST_ERROR = -99;
		$name = strtolower($this->name);
		
		$sql = "SELECT * FROM p_type WHERE lower(name)='".$name."'";
		$q->query($DB, $sql);
		if ($q->getrow()){
			$this->id = -1;
			return $EXIST_ERROR;
		}
		$sql = "INSERT INTO p_type (id, name) VALUES (NULL,
										'".$this->name."')";
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
		$sql = "UPDATE p_type SET name='".$this->name."' WHERE id=".$this->id;
		$q->query($DB, $sql);
		if ($q->error())
			return -1;

		return 1;
	}

	function delete(){
    	global $DB;
    	$q = new query($DB);
    	$sql = "SELECT id FROM products WHERE ptype=".$this->id." LIMIT 1";
    	$q->query($DB, $sql);
		if ($q->error())
		{
			$q->free();
			return -1;
		}
		$row = $q->getrow();
		if (empty($row))
		{
			$sql = "DELETE FROM p_type WHERE id=".$this->id;
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
	
	function getAllTypes(){
		global $DB;

		$result = Array();
		$sql = "SELECT id, name FROM p_type ORDER BY name ASC";
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