<?
	if (isset($_SESSION['userSS'])) {
		$user = new admin;
		$user = unserialize($_SESSION['userSS']);
	}else{
		header("Location: ../index.php");
		exit;
	}
	$locale = $_GET["locale"];
	if($locale == null || $locale == ""){
		$locale = $main_locale;
	}
	$sectionid = $_GET["sectionid"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Cenovnik Content Management System</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css"/>
	<link rel="stylesheet" type="text/css" href="../css/framestyle.css" />
	<script language="JavaScript" type="text/javascript" src="../js/header.js"></script>
	<script language="JavaScript" type="text/javascript" src="../js/js.js"></script>
</head>
<body>
<center>
<div id="wrapper">
	<div id="aztop">
		<div class="spacer" style="height:15px;"></div>
		<h1>Cenovnik</h1>
		<h2>Content Management System</h2>
	</div>
	<div id="vobtop">
		<div class="spacer" style="height:5px;"></div>
		<span class="flleft" style="margin-top:3px;">
<?
	echo "&nbsp;&nbsp;";
	for($i = 0; $i < count($user->sectionsList); $i++){
		echo "<a href=\"../".$user->sectionsListDir[$i]."/?locale=".$locale."&sectionid=".$user->sectionsList[$i]."\" class=\"toplink\">";
		if($sectionid == $user->sectionsList[$i]){
			echo "<u>".$user->sectionsListName[$i]."</u></a>";
		}else{
			echo $user->sectionsListName[$i]."</a>";
		}
		if($i < (count($user->sectionsList) - 1)){
			echo "&nbsp;&nbsp;|&nbsp;&nbsp";
		}else{
			echo "&nbsp;&nbsp;";
		}
	}
?>		</span>
	</div>
<?
?>