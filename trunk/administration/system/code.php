<?
	include("vars_inc.php");

	$q = new query($DB);
	//check if admin has right to work in this page
	$admin = new admin();
	$store = new store();
	$allowed = false;
	
  	if ($user->type == $su) 
		$allowed = true;
	if($allowed){	
		switch($act){
			case "publishStores":
				include("stores.php");
				break;
			case "publishProducts":
				include("products.php");
				break;
			case "select":
				$admin->getById($id);
print_r($admin);
				$act = "update";
				break;
			case "insert":
				$stores=array_keys($stores);
				$admin->set(null, $name, $password, $email, $type, $stores);
print_r($admin);
				$res = $admin->insert();
				if ($res == -99)
					$message = "Administrator sa tim imenom vec postoji. Odaberite drugo ime.";
				if($admin->id == -1){
					$act = "insert";
					$error = 1;
				}else{
					$act = "select";
					$reload = true;
				}
				break;
			case "update":
				$stores=array_keys($stores);
				$admin->set($id, $name, $password, $email, $type, $stores);
print_r($admin);
				$error = $admin->update();
				if ($error == -99)
					$message = "Administrator sa tim imenom vec postoji. Odaberite drugo ime.";
				$act = "select";
				if ($error > 0){
					$reload = true;
					$error = false;
				}
				else $error = true;
				break;
			case "del":
				$act = " ";
				$admin->id = $id;
				$result = $admin->delete();
				//echo "rezultat brisanja:".$result;
				if ($result > 0)
					$reload = true;
				else $error = true;
				break;
			default:
				$act = "insert";
		}
	}
?>