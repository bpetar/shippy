<? 
class store{
	var $id;
	var $name;
	var $city;
	var $url;
	var $contact;
	var $image_small;
	var $image_big;
	
	function store(){
	}
	
	function getById($id) {
	  	global $DB;

	  	$sql = "SELECT * FROM stores WHERE id=".$id;
		$q = new query($DB, $sql);
		if($q->error()){
			$q->free();
			return -1;
		}
		if($r = $q->getrow()){
			$this->id = $r["id"];
			$this->name = $r["name"];
			$this->city = $r["city_id"];
			$this->url = $r["url"];
			$this->contact = $r["contact"];
			$this->image_small = $r["image_small"];
			$this->image_big = $r["image_big"];
		}
		$q->free();
	}
	
	function set($id, $name, $city, $url, $contact, $image_small, $image_big){
		$this->id = $id;
		$this->name = $name;
		$this->city = $city;
		$this->url = $url;
		$this->contact = $contact;
		$this->image_small = $image_small;
		$this->image_big = $image_big;
	}

	function insert(){
		global $DB;
	 
		$sql = "INSERT INTO stores (name, city_id, url, contact, image_big, image_small) VALUES('"
				.$this->name."', '".$this->city."', '".$this->url."', '".$this->contact
				."', '".$this->image_big."', '".$this->image_small."')" ;

		$q = new query($DB);
		$q->query($DB, $sql, true);
		if ($q->error()){
			$this->id = -1;
			return -1;
		}
		else
		{
			$this->id = $q->last_id();
		}
		return $this->id;
	}

	function update(){
		global $DB;
	
		$sql = "UPDATE stores SET name='".$this->name."', 
							city_id='".$this->city."', 
							url='".$this->url."', 
							contact='".$this->contact."', 
							image_small='".$this->image_small."', 
							image_big='".$this->image_big."'
							WHERE id=".$this->id;
	
		$q = new query($DB);
		$q->query($DB, $sql);
		if ($q->error())
			return -1;
	
		return 1;
	}

	function delete(){
		global $DB;
	
		$q = new query($DB);
    	$sql = "SELECT id_store FROM product_store WHERE id_store=".$this->id." LIMIT 1";
    	$q->query($DB, $sql);
		if ($q->error())
		{
			$q->free();
			return -1;
		}
		$row = $q->getrow();
		if (empty($row))
		{
			$sql = "DELETE FROM product_store WHERE id_store=".$this->id;
			$q = new query($DB);
			$q->query($DB, $sql);
			if ($q->error())
			{
				$q->free();
				return -1;
			}
			
			$sql = "DELETE FROM stores WHERE id=".$this->id;
			$q = new query($DB);
			$q->query($DB, $sql);
			if ($q->error())
			{
				$q->free();
				return -3;
			}
			
			$q->free();
			return 1;
		}
		
		$q->free();
		return -2;
		
	}
	
	function getAllStores(){
		global $DB;

		$result = Array();
		$sql = "SELECT stores.id as id, stores.name as name, city.name as city_name FROM stores, city where city_id = city.id "
				."ORDER BY city_id";
		$q = new query($DB, $sql);
		$q->query($DB, $sql);
		if ($q->error())
			return $result;
		while($row = $q->getrow()){
			$result[] = $row;
		}
		return $result;
	}
	
	function getAllStoresByCity($id)
	{
		global $DB;

		$result = Array();
		$sql = "SELECT id, name, contact FROM stores where city_id=".$id
				." ORDER BY name";
		$q = new query($DB, $sql);
		$q->query($DB, $sql);
		if ($q->error())
			return $result;
		while($row = $q->getrow()){
			$result[] = $row;
		}
		return $result;
	} 

	function sendNoticeEmail(){
		global $DB;
		global $su;
		global $sendnotice;
		
		if($sendnotice){
			$sql = "SELECT NAME FROM LOCALE WHERE ID=".$this->locale_id;
			$q = new query($DB);
			$q->query($DB, $sql);
			$r = $q->getrow();
			$subject = "Obavestenje www.voban.co.yu - izmene u modulu vesti";
			$message = "<html>";
			$message .= "<head>";
			$message .= "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
			$message .= "</head>";
			$message .= "<body>";
			$message .= "Obavestenje<br/>";
			$message .= "Vreme izmena: ".date("d.m.y , H:i")."<br/>";
			$message .= "Dodata je nova vest - ".$this->name."<br/>";
			$message .= "Za jezik - ".$r["NAME"]."<br/>";
			$message .= "ID vesti je - ".$this->news_id."<br/>";
			$message .= "Potrebno je da verifikujete i publikujete izmene.<br/>";
			$message .= "www.voban.co.yu";
			$message.="</body>";
			$message.="</html>";
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: Voban <admin@voban.co.yu>\r\n";
			$sql = "SELECT EMAIL FROM ADMINS WHERE TYPE='".$su."'";
			$q = new query($DB, $sql);
			while($r = $q->getrow()){
				@mail($r["EMAIL"], $subject, $message,$headers);
			}
		}
	}
}
?>