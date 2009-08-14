<?
	include("mainvars.php");
	include("../../classes/ftp.php");
  $fn = $_GET["field_name"];
  $url = $_GET["url"];
  $previewEl = $_GET["preview"];
  $set_lib = $_GET["lib"];

  $errors = false;
  $preview = "";
  if($HTTP_POST_FILES["upfile"]["size"] > 0){
  	if(!($url = uploadImg("upfile"))){
			$errors = true;
  	}
  }
  $paths = explode("/", $url);
  $lib_dir = $paths[count($paths) - 2];
  $file_name = $paths[count($paths) - 1];
  if(preg_match("/\.jpg$|\.jpeg$|\.gif$|\.png$/i", $file_name)){
  	$preview = $www_root."/".$filesDir."/".$lib_dir."/".$file_name;
  }
  if(!$lib_dir){
  	$lib_dir = $set_lib;
  }
  $ftp = new ftp();
  $list = $ftp->nlist($filesDir);
  if($list){
    $i = 0;
		foreach($list as $item){
			$dirs[$i] = basename($item);
			$flist = $ftp->nlist($filesDir."/".$item);
			if($flist){
      	foreach($flist as $fitem){
      		$dirsfiles[$i][] = basename($fitem);
      	}
      }
   		$i++;
		}
	}
	$ftp->quit();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="www.arhel.com , powered by activeZ cms v2.0" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<title>Izaberi file</title>
	<style type="text/css">
		body{
			margin:0px;
			padding:10px;
			font-family:Verdana,Arial;
			font-size:8pt;
			color:#000000;
			background-color:#f0f0ee;
		}
		#dlgwrapp{
			width:482px;
			margin:0px;
			padding:0px;
			border:1px solid #000000;
		}
		#selwrapp{
			width:170px;
			margin:0px;
			padding:0px;
		}
		.items{
			padding-bottom:3px;
		}
		#framewrapp{
			width:295px;
			margin:0px;
			padding:0px;
			position:absolute;
			top:15px;
			left:180px;
		}
		#upwrapp{
			margin:0px;
			padding:0px;
		}
		form{
			margin:0px;
			padding:0px;
			font-size:8pt;
		}
		input{
			margin:0px;
			padding:0px;
			font-size:8pt;
			border:1px solid #000000;
		}
		select{
			margin:0px;
			padding:0px;
			border:1px;
			font-size:8pt;
			width:150px;
			font-family:Verdana,Arial;
		}
		hr{
			height:1px;
		}
		iframe{
			margin:0px;
			border:1px solid black;
			width:300px;
			height:195px;
		}
	</style>
	<script language="javascript" type="text/javascript">
		var www_root = '<?= $www_root ?>';
		var filesdir = '<?= $filesDir ?>';
		var parentEl = '<?= $fn ?>';
		var lib_dir = '<?= $lib_dir ?>';
		var file_name = '<?= $file_name ?>';
		var preview = '<?= $previewEl ?>';
		var dirs = new Array();
		var dirsfiles = new Array();
<?
        for($i = 0; $i < count($dirs); $i++){
            echo("dirs[".$i."] = '".$dirs[$i]."';\n");
            $t_str = "dirsfiles[".$i."] = new Array(";
            $t_cnt = false;
            foreach($dirsfiles[$i] as $dfs){
                $t_str .= "'".$dfs."',";
                $t_cnt = true;
            }
            if($t_cnt){
            	$t_str = substr($t_str, 0, -1);
            }
            $t_str .= ");\n"; 
            echo $t_str;
        }
?>
		function changeImgList(id){
			htmlstr = '<select id="imgsel" name="imgsel" size="10" onChange="javascript: changePreview(this.value);">';
			for(i = 0; i < dirsfiles[id].length; i++){
				htmlstr += '<option value="' + i + '">' + dirsfiles[id][i] + '</option>';
			}
			htmlstr += '</select>';
			obj = document.getElementById('imgseldiv');
			obj.innerHTML = htmlstr;
		}
		function changePreview(id){
			obj = document.getElementById('preview');
			t_libid = document.getElementById('libsel').value;
			if(isImage(dirsfiles[t_libid][id])){
				obj.src = www_root + '/' + filesdir + '/' + dirs[t_libid] + '/' + dirsfiles[t_libid][id];
			}else{
				obj.src = '';
			}
		}
		function isImage(path){
			if(path.search(/\.jpg$|\.jpeg$|\.gif$|\.png$|\.swf$/i) == -1){
				return false;
			}else{
				return true;
			}
		}
		function doselClick(){
			t_libid = document.getElementById('libsel').value;
			t_imgid = document.getElementById('imgsel').value;
			t_win = window.opener.getDlgWin();
			if(t_imgid == null || t_imgid == ""){
				alert('Odaberite file!');
				return;
			}
			if(t_win.document.getElementById(parentEl) != null){
				ret_val = '/' + filesdir + '/' + dirs[t_libid] + '/' + dirsfiles[t_libid][t_imgid];
				t_win.document.getElementById(parentEl).value = ret_val;
				if(preview != '' && ret_val.toLowerCase().indexOf('.swf') < 0){
					t_win.setPreviewImg(ret_val, preview);
				}
				window.close();
				return;
			}
			window.close();
		}
		function clselClick(){
			window.close();
		}
		function submitUpForm(){
			if(document.getElementById('upfile').value){
				t_libid = document.getElementById('libsel').value;
				document.getElementById('lib').value = dirs[t_libid];
				return true;
			}else{
				return false;
			}
		}
	</script>
</head>
<body>
	<div id="dlgwrapp">
		<div style="padding:5px;">
		<div id="selwrapp">
			<div class="items">
				<b>Izaberite biblioteku:</b>
			</div>
			<div class="items">
				<select id="libsel" name="libsel" onChange="javascript: changeImgList(this.value);">
<?
					$lib_dir_id = 0;
					for($i = 0; $i < count($dirs); $i++){
		        $selected = "";
		        if($dirs[$i] == $lib_dir){
					    $selected = "selected='selected'";
					    $lib_dir_id = $i;
					  }
					  echo("<option value='".$i."' ".$selected.">".$dirs[$i]."</option>");
					}
?>
				</select>
			</div>
			<div class="items">
				<b>Izaberite file:</b>
			</div>
			<div class="items" id="imgseldiv">
				<select id="imgsel" name="imgsel" size="10" onChange="javascript: changePreview(this.value);">
<?
					for($i = 0; $i < count($dirsfiles[$lib_dir_id]); $i++){
					  $selected = "";
					  if($dirsfiles[$lib_dir_id][$i] == $file_name){
					    $selected = "selected='selected'";
					  }
					  echo("<option value='".$i."' ".$selected.">".$dirsfiles[$lib_dir_id][$i]."</option>");
					}
?>
				</select>
			</div>
			<div class="items">
				<input type="button" name="dosel" id="dosel" value="Odaberi" onClick="javascript: doselClick();" /> <input type="button" name="clsel" id="clsel" value="Odustani" onClick="javascript: clselClick();" />
			</div>
		</div>
		<div id="upwrapp">
			<hr />
			<div class="items">
				<b>Upload<? if($errors){echo("<span style='color:red;'>(Greska, probajte ponovo!!!)</span> ");} ?>:</b>
			</div>
			<form action="up.php?field_name=<?=$fn?>&url=<?=$url?>" name="upform" id="upform" method="post" enctype="multipart/form-data" onSubmit="javascript: return submitUpForm();">
			<div class="items">
				<input type="file" name="upfile" id="upfile" />
			</div>
			<div class="items">
				<input type="submit" name="doup" id="doup" value="Upload" />
			</div>
			<input type="hidden" name="lib" id="lib" value="" />
			<input type="hidden" name="t_path" id="t_path" value="" />
			</form>
		</div>
		</div>
	</div>
	<div id="framewrapp">
		<iframe id="preview" name="preview" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" src="<?= $preview ?>"></iframe>
	</div>
</body>
</html>
<?
function uploadImg($img) {

  global $doc_root;
	global $www_root;
  global $HTTP_POST_FILES;
  global $_POST;
  global $filesDir;
  
  if ($HTTP_POST_FILES[$img]["size"]>0) {
    $data["type"] = $HTTP_POST_FILES[$img]["type"];
    $data["name"] = $HTTP_POST_FILES[$img]["name"];
    $data["size"] = $HTTP_POST_FILES[$img]["size"];
    $data["tmp_name"] = $HTTP_POST_FILES[$img]["tmp_name"];
    $imglib = $_POST["lib"];

    $ext = strtolower(substr(strrchr($data['name'],'.'), 1));
    $dir_name = $filesDir."/".$imglib;
    $img_name = $data['name'];
    $i = 1;
    while(file_exists($doc_root."/".$dir_name."/".$img_name)){
      $img_name = ereg_replace('(.*)(\.[a-zA-Z]+)$', '\1_'.$i.'\2', $data['name']);
      $i++;
    }
    $ftp = new ftp();
    $fp = fopen($data['tmp_name'], 'r');
    if(!$ftp->fput($dir_name."/".$img_name, $fp)){
      return false;
    }
    fclose($fp);
    $ftp->quit();
    return $dir_name."/".$img_name;
  }
  return false;
}
?>