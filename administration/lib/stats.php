<?
	$referer = $HTTP_SERVER_VARS["HTTP_REFERER"];
	$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
	$query = $HTTP_SERVER_VARS["QUERY_STRING"];

	$pos1 = stristr($referer, $www_root);
	if(!$pos1){
		$sql = "INSERT INTO STATISTICS (ID, REFERER, IP, QUERY, DATE_REQ) VALUES(NULL, '".$referer."', '".$ip."', '".$query."', TO_DATE('".date("m-d-Y")."', 'MM-DD-YYYY'))";
		$q = new query($DB, $sql);
	}

	$uri = $HTTP_SERVER_VARS["REQUEST_URI"];
	$t_pages = explode("/", $uri);
	$t_lc = $t_pages[1];
	$t_sec = $t_pages[3];
	if(!empty($t_sec) && !strpos($t_sec, ".") && !strpos($t_sec, "?")){
		$sql = "SELECT * FROM STATISTICS_SECTIONS WHERE PAGE LIKE '".$t_sec."' AND LOCALE LIKE '".$t_lc."'";
		$q = new query($DB, $sql);
		if($row = $q->getrow()){
			$visits = $row["VISITS"];
			$visits++;
			$sql = "UPDATE STATISTICS_SECTIONS SET VISITS=".$visits." WHERE ID=".$row['ID'];
			$q = new query($DB, $sql);
		}else{
			$sql = "INSERT INTO STATISTICS_SECTIONS (ID, LOCALE, PAGE, VISITS) VALUES(NULL, '".$t_lc."', '".$t_sec."', 1)";
			$q = new query($DB, $sql);
		}
	}
?>