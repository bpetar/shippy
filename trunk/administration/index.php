<?
	session_start();

	include("lib/mainvars.php");
	include("../classes/dbsql.php");
	include("../classes/admin.php");
	include("../classes/locale.php");
	
	if(isset($_POST['name'])){
		$name = $_POST['name'];
	}
	if(isset($_POST['password'])){
		$password = $_POST['password'];
	}
	if($name != null && $password != null){
		$admin = new admin;
		$admin->name = $name;
		$admin->password = $password;
		if($admin->login()){
			$s = serialize($admin);
			$_SESSION['userSS'] = $s;
			//header("Location: ".$admin->sectionsListDir[0]."/index.php?locale=".$admin->localesList[0]."&sectionid=".$admin->sectionsList[0]);
			header("Location: system/index.php");
			exit;
		} else {
			echo "nije se ulogovo".$name.$password."<br>";
		}
		if(isset($_GET['logout'])){
			if($_GET['logout'] == "true"){
			 	$_SESSION['userSS'] = null;
			}
		}
	}
	$locale=1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Cenovnik Content Management System</title>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<script language="JavaScript" type="text/javascript" src="js/header.js"></script>
</head>
<body bgcolor="#000000">
<center>
<div id="wrapper">
	<div id="aztop">
		<div class="spacer" style="height:15px;"></div>
		<h1>Cenovnik</h1>
		<h2>Content Management System</h2>
	</div>
	<div id="vobtop">
		<div class="spacer" style="height:5px;"></div>
		<h2>cenovnik</h2>
	</div>
	<form method="post" name="loginForm" action="index.php">
	<div id="login">
		<div class="spacer" style="height:50px;"></div>
		<div class="loginform">
			Unesite korisnièko ime i šifru
		</div>
		<br />
		<br />
		<div class="loginform">
			<div class="flleft">Korisnièko ime</div>
			<div class="flright"><input type="text" name="name" class="loginput" size="20" maxlength="50" /></div>
		</div>
		<div class="loginform">
			<div class="flleft">Šifra</div>
			<div class="flright"><input type="password" name="password" class="loginput" size="20" maxlength="50" /></div>
		</div>
		<div class="loginform">
			<div class="flleft">&nbsp;</div>
			<div class="flright"><input type="submit" value="Login" class="loginput" /></div>
		</div>
	</div>
	</form>
	<div id="foot">
	</div>
</div>
</center>
</body>
</html>