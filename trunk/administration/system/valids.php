<?
	include_once("../lib/mainvars.php");
	include_once("../../classes/oraclesql.php");
	include_once("../lib/login.php");
	if ($user->type == $su){
		$act = $_GET["act"];
		$valids_str = $_POST["valids_str"];
		$sectionid = $_GET["sectionid"];
		$locale = $_GET["locale"];
		if($act == "savevalids"){
			$sql = "UPDATE VALIDATORS SET EMAIL='".$valids_str."' WHERE ID=1";
			$q = new query($DB, $sql);
		}else{
			$sql = "SELECT * FROM VALIDATORS WHERE ID=1";
			$q = new query($DB, $sql);
			if($r = $q->getrow()){
				$valids_str = $r["EMAIL"];
			}
		}
		$t_vls = explode(";", $valids_str);
		$act = "savevalids";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/framestyle.css" />
<title>structure</title>
<script language="javascript">
	function delValid(){
		obj = document.getElementById('valids');
		t_in = obj.selectedIndex;
		if(t_in >= 0){
			obj.options[t_in] = null;
		}
		return false;
	}
	function addValid(){
		t_str = document.getElementById('email').value;
		obj = document.getElementById('valids');
		t_in = obj.length;
		obj.options[t_in] = new Option(t_str, t_str);
		document.getElementById('email').value = '';
		return false;
	}
	function sendValids(){
		obj = document.getElementById('valids');
		t_in = obj.length;
		t_str = '';
		for(i = 0; i < t_in; i++){
			t_str += obj.options[i].value + ';';
		}
		document.getElementById('valids_str').value = t_str;
		return true;
	}
</script>
</head>
<body>
	<form name="unosforma" id="unosforma" action="valids.php?act=<?=$act?>&locale=<?=$locale?>&sectionid=<?= $sectionid ?>" method="post">
		<input type="hidden" name="valids_str" id="valids_str" value="" />
		<div class="pgsitem">
			<div class="pgsleft"><img src="../img/i.gif" title="Lista validatora. Selektovanjem i klikom na Izbaci odabranog se brise email iz liste." alt="" style="vertical-align:middle;" />&nbsp;&nbsp;VALIDATORI:</div>
			<div class="pgsright">
				<select name="valids" id="valids" size="10">
				<?
					foreach($t_vls as $item){
						if($item != "" && $item != null){
							echo("<option value=\"".$item."\">".$item."</option>\n");
						}
					}
				?>
				</select>
				<br />
				<input type="submit" name="del_valid" id="del_valid" value="IZBACI ODABRANOG"  class="pgsctrlsbtt" onClick="javascript: return delValid();" />
			</div>
		</div>
		<div class="pgsitem">
			<div class="pgsleft"><img src="../img/i.gif" title="Unosom email adrese i klikom na dugme Dodaj email se vrsi dodavanje email-a u listu." alt="" style="vertical-align:middle;" />&nbsp;&nbsp;UNESI EMAIL:</div>
			<div class="pgsright">
				<input type="text" name="email" id="email" maxlength="150" class="pgsform" />
				<br />
				<input type="submit" name="add_valid" id="add_valid" value="DODAJ EMAIL"  class="pgsctrlsbtt" onClick="javascript: return addValid();" />
			</div>
		</div>
		<div class="pgsctrlsitem">
			<div class="pgsctrlslf"><img src="../img/i.gif" title="Da bi se sacuvale promene u listi potrebno je kliknuti na dugme Snimi promene" alt="" style="vertical-align:middle;" />&nbsp;Snimi promene:</div>
			<div class="pgsctrlsrg"><input type="submit" name="savebt" id="savebt" value="SNIMI VALIDATORE" class="pgsctrlsbtt" onClick="javascript: return sendValids();" /></div>
		</div>
	</form>
</body>
</html>
<?
	}
?>