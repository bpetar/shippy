<?
	$name = $_POST["name"];
	$zip = $_POST["zip"];

	$act = $_GET["act"];

	if(isset($_SESSION['userSS'])){
		$user=new admin;
		$user=unserialize($_SESSION['userSS']);
	}else{
		header("Location:../index.php");
	}

	$city = new city();
	if (isset($id))
		$city->getById($id);
	switch($act){
		case "select":
			$act = "update";
			break;
		case "insert":
			$city->set($id, $name, $zip);
			$res = $city->insert();
			if ($res == -99)
				$message = "Grad sa tim imenom vec postoji. Odaberite drugo ime.";
			if($city->id == -1){
				$act = "insert";
				$error = 1;
			}else{
				$act = "select";
			}
			break;
		case "update":
				case "update":
				$city->name = $name;
				$city->zip = $zip;
				$error = ($city->update() < 0);
				break;
		case "del":
			$result = $city->delete();
			$error = ($result < 0);
			if (!$error) {
				$city = new city();
				$act = "insert";
			} else {
				$act = "select";
				if ($result == -2)
				{
					$message = "Postoje prodavnice u ovom gradu. Obrisite prvo njih.";
				}
			}
			break;
		default:
			$act = "insert";
	}
?>