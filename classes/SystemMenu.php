<?
class SystemMenu {
	var $localeId;
	var $spacer = "&nbsp;&nbsp;&nbsp;";

	function show($locale){
		global $sectionid;
		global $main_locale;
		global $DB;
		$q = new query($DB);
	
		if ($locale == null)
			$this->localeId = $main_locale;
		else 
			$this->localeId = $locale;
		  	
		echo "<div class='menuItem'>";
	
		echo "\n	<a href='index.php?locale=".$this->localeId."&sectionid=".$sectionid."' class='leftLink'><b>Unos novog administratora</b></a><br><br>";
		echo "\n	<a href='index.php?act=publishStores&locale=".$this->localeId."&sectionid=".$sectionid."' class='leftLink'><b>Publikuj prodavnice</b></a><br><br>";
		echo "\n	<a href='index.php?act=publishProducts&locale=".$this->localeId."&sectionid=".$sectionid."' class='leftLink'><b>Publikuj proizvode</b></a><br><br>";
		  	
		$sql = "SELECT id, name FROM admins ORDER BY type DESC";
		$q->query($DB, $sql);
		while($row = $q->getrow()){
			echo "\n	<a href='index.php?id=".$row['id']."&act=select&locale=".$this->localeId."&sectionid=".$sectionid."' class='leftLink'>".$row['name']."</a><br>";
		}
		echo "\n</div>";
  }
}
?>