<? 
class product{
	var $id;
	var $name;
	var $image_small;
	var $image_big;
	var $type;
	var $bar_code;
	
	function product(){
	}
	
	function getById($id) {
	  	global $DB;

	  	$sql = "SELECT * FROM products WHERE id=".$id;
		$q = new query($DB, $sql);
		if($q->error()){
			$q->free();
			return -1;
		}
		if($r = $q->getrow()){
			$this->id = $r["id"];
			$this->name = $r["name"];
			$this->image_small = $r["image_small"];
			$this->image_big = $r["image_big"];
			$this->type = $r["ptype"];
			$this->bar_code = $r["bar_code"];
		}
		$q->free();
	}
	
	function set($id, $name, $image_small, $image_big, $type, $bar_code){
		$this->id = $id;
		$this->name = $name;
		$this->image_small = $image_small;
		$this->image_big = $image_big;
		$this->type = $type;
		$this->bar_code = $bar_code;
	}

	function getProductsByName($name) {
		global $DB;
	
		$sql = "SELECT VESTI_LOCALE.ID AS ID, NEWS_ID, NAME, TITLE, CONTENT, LOCALE, PUBLISHED, DATUM FROM VESTI, VESTI_LOCALE WHERE NEWS_ID=".$news_id." AND LOCALE = ".$locale_id." AND VESTI.ID = ".$news_id;
	
		$q = new query($DB);
		$q->query($DB, $sql);
		if ($q->error())
			return -1;
		if(!($r = $q->getrow())){
		//if ($q->numrows() == 0){//news doesn't have any locale so take only name and date
			$sql = "SELECT ID AS NEWS_ID, NAME, DATUM FROM VESTI WHERE ID=".$news_id;
			$q = new query($DB);
			$q->query($DB, $sql);
			if ($q->error())
				return -1;
			$r = $q->getrow();
		}
		
		$this->id = $r["ID"];
		$this->news_id = $r["NEWS_ID"];
		$this->name = $r["NAME"];
		$this->title = str_replace("\"", "&quot;", $r["TITLE"]);
		
		$this->content = $r["CONTENT"];
		$this->locale_id = $r["LOCALE"];
		$this->date = $r["DATUM"];
		$this->convertDate();
		
		$this->published = $r["PUBLISHED"];
		if ($this->published == null) $this->published = 0;
		if ($this->locale_id == null) $this->locale_id = $locale_id;
	
		if ($this->locale_id != $this->DEFAULT_LOCALE) {//take serbian values
			$sql = "SELECT TITLE, CONTENT FROM VESTI_LOCALE WHERE NEWS_ID=".$news_id." AND LOCALE= ".$this->DEFAULT_LOCALE;
			$q = new query($DB);
			$q->query($DB, $sql);
			if ($q->error())
				return -1;
			$r = $q->getrow();
			$this->titleDefault = str_replace("\"", "&quot;", $r["TITLE"]);
			$this->contentDefault = $r["CONTENT"];
		}

		$q->free();
	}

	function insert(){
		global $DB;
		
		$q = new query($DB);
		$EXIST_ERROR = -99;
		$name = strtolower($this->name);
		
		$sql = "SELECT * FROM products WHERE lower(name)='".$name."'";
		$q->query($DB, $sql);
		if ($q->getrow()){
			$this->id = -1;
			return $EXIST_ERROR;
		}
	 
		$sql = "INSERT INTO products (name, image_big, image_small, ptype, bar_code) VALUES('"
				.$this->name."', '".$this->image_big."', '".$this->image_small."', '".$this->type."', '".$this->bar_code."')" ;

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
	
		$sql = "UPDATE products SET name='".$this->name."', 
							image_small='".$this->image_small."', 
							image_big='".$this->image_big."', 
							ptype='".$this->type."', 
							bar_code='".$this->bar_code."' 
							WHERE id=".$this->id;
		$q = new query($DB);
		$q->query($DB, $sql);
		if ($q->error())
			return -1;
	
		return 1;
	}

	function delete(){
		global $DB;
	
		$sql = "DELETE FROM product_store WHERE id_product=".$this->id;
			$q = new query($DB);
			$q->query($DB, $sql);
			if ($q->error())
				return -1;
		
		$sql = "DELETE FROM products WHERE id=".$this->id;
			$q = new query($DB);
			$q->query($DB, $sql);
			if ($q->error())
				return -2;
		
		return 1;
	}
	
	function getAllTypeProducts($ptype){
		global $DB;
	
		$result = Array();
		$sql = "SELECT id, name FROM products WHERE ptype=".$ptype." ORDER BY name ASC";
		$q = new query($DB, $sql);
		if($q->error()){
			$q->free();
			return -1;
		}
		
		while($row = $q->getrow()){
			$result[] = $row;
		}
		$q->free();
		return $result;
	}
	
	function getPricesByStore($id){
		global $DB;
		$result = Array();
		$sql = "SELECT products.id, price, id_admin, products.name AS pname, p_type.name AS tname "
				."FROM (products, p_type) "
				."LEFT JOIN product_store ON (id_product = products.id AND id_store = ".$id.") "
				."WHERE products.ptype = p_type.id ORDER BY tname, pname ASC";
		$q = new query($DB, $sql);
		if($q->error()){
			echo("query error: ".$q->error());
			$q->free();
			return -1;
		}
		while($row = $q->getrow()){
			$result[] = $row;
		}
		$q->free();
		return $result;
	}
	
	function getPricesByStoreType($storeid,$typeid) {
		global $DB;
		$result = Array();
		$sql = "SELECT products.id, price, id_admin, products.name AS pname "
				."FROM (products) "
				."LEFT JOIN product_store ON (id_product = products.id AND id_store = ".$storeid.") "
				."WHERE products.ptype = ".$typeid." ORDER BY pname ASC";
		$q = new query($DB, $sql);
		if($q->error()){
			echo("query error: ".$q->error());
			$q->free();
			return -1;
		}
		while($row = $q->getrow()){
			$result[] = $row;
		}
		$q->free();
		return $result;	
}
	
	function getPricesByProduct($id){
		global $DB;
		$result = Array();
		$sql = "SELECT id_store, price "
				."FROM product_store "
				."WHERE id_product=".$id;
		$q = new query($DB, $sql);
		if($q->error()){
			$q->free();
			return -1;
		}
		while($row = $q->getrow()){
			$result[] = $row;
		}
		$q->free();
		return $result;
	}
	
	function enterPrice($productid, $storeid, $price, $adminid){
		global $DB;
		$message = "Cena uspesno unesena";
		
		if (empty($price) || $price == "")
		{
			$sql = "DELETE FROM product_store "
					."WHERE id_store = ".$storeid." AND id_product = ".$productid;
			$q = new query($DB, $sql);
			if($q->error()){
				$message = "Greska prilikom brisanja iz baze podataka, probajte ponovo.";
			}	
		}
		else
		{
			$sql = "SELECT * FROM product_store "
					."WHERE id_store = ".$storeid." AND id_product = ".$productid;
			$q = new query($DB, $sql);
			if($q->error()){
				$message = "Greska prilikom provere u bazi podataka, probajte ponovo.";
			}
			else
			{
				$today = getdate();
				$date = $today['year']."-".$today['mon']."-".$today['mday'];
	
				$row = $q->getrow();
				if (empty($row))
				{
					$sql = "INSERT INTO product_store (id_store, id_product, price, id_admin, date) VALUES ("
								.$storeid.", ".$productid.", '".$price."', ".$adminid.", '".$date."')";
					$q = new query($DB, $sql);
					if($q->error()){
						$message = "Greska prilikom unosa u bazu podataka, probajte ponovo.";
					}
				}
				else
				{
					if ($row["price"] != $price)
					{
						$sql = "UPDATE product_store set "
								."price='".$price."', "
								."id_admin=".$adminid.", "
								."date='".$date."' "
								."WHERE id_store=".$storeid." AND id_product=".$productid;
						$q = new query($DB, $sql);
						if($q->error()){
							$message = "Greska prilikom unosa u bazu podataka, probajte ponovo.";
						}
					}
					else
					{
						$message = "Cena je ista kao prethodna, nije bilo potrebe da se menja.";
					}
				}
			}
		}
		$q->free();
		return $message;
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