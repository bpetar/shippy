<?
	//$doc_root = "F:/projekti/cene/www";
	//$www_root = "http://localhost:8093";
	//$ftp_host = "arhel";
	//$ftp_user = "administrator";
	//$ftp_pass = "";
	//$db_service	= "localhost";//used on oracle DB
	$db_name="mystic-peanut_com_-_cene";
	$db_host="localhost";
	$db_user = "pera";
	$db_pwd = "pera";
	//$filesDir = "files";
	$cms_dir = "/admininistration";
	//$structure_dir = "/structure";
	$su = "superadmin";
	$editor = "editor";
	$runError = "";
	//$sendnotice = 0;
	//$sendpublished = 0;
	//$vobanemail = "pribi@neobee.net";
	//$crypt_str = "oxklsopacbhryemzx";
	//$emails_to_send = 10;

	/*function escOraChrs($str){
		//return str_replace("'", "''", $str);// used on oracle DB
		return str_replace("k", "k", $str);
	}
	function unescOraChrs($str){
		//return str_replace("''", "'", $str);// used on oracle DB
		return str_replace("k", "k", $str);
	}*/
	$old_error_handler = set_error_handler("siteErrorHandler");
	function siteErrorHandler($errno, $errstr, $errfile, $errline){
		global $runError;
		switch($errno){
			case E_USER_WARNING:
		    $runError .= "<div class='errorTxt'><b>Greska:</b> ".$errstr."</div>\n";
		    break;
	  }
	}
	function mkCode($text, $crypt_str) {
    	$cryptedtext = md5($crypt_str.$text.$crypt_str);
    	return $cryptedtext;
    }
?>