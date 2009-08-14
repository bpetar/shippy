<?
	$name = $_POST["name"];

	$act = $_GET["act"];

	if(isset($_SESSION['userSS'])){
		$user=new admin;
		$user=unserialize($_SESSION['userSS']);
	}else{
		header("Location:../index.php");
	}

	$ptype = new ptype();
	if (isset($id))
		$ptype->getById($id);
	switch($act){
		case "select":
			$act = "update";
			break;
		case "insert":
			$ptype->set($id, $name);
			$res = $ptype->insert();
			if ($res == -99)
				$message = "Tip proizvoda sa tim imenom vec postoji. Odaberite drugo ime.";
			if($ptype->id == -1){
				$act = "insert";
				$error = 1;
			}else{
				$act = "select";
			}
			break;
		case "update":
				case "update":
				$ptype->name = $name;
				$error = ($ptype->update() < 0);
				break;
		case "del":
			$result = $ptype->delete();
			$error = ($result < 0);
			if (!$error) {
				$ptype = new ptype();
				$act = "insert";
			} else {
				$act = "select";
				if ($result == -2)
				{
					$message = "Postoje proizvodi pod ovim tipom proizvoda. Obrisite prvo njih.";
				}
			}
			break;
		default:
			$act = "insert";
	}
?>