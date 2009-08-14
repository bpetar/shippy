<script language="javascript" type="text/javascript">
	var parent_folder = '<?= $parent_folder ?>';
	function contentCheckBt(hascontent){
		if(hascontent){
			document.getElementById('contwrapp').style.display = 'block';
		}else{
			document.getElementById('contwrapp').style.display = 'none';
		}
	}
</script>
<?
	echo $runError;

	if(!$act){
		if($user->type == $su){
?>
		<div>Kliknite na neku stavku u levom meniju.</div>
<?
		}
	}else{
?>

<script language="JavaScript" type="text/javascript">

	var categoriesSelected = <? echo sizeof($admin->categoryList); ?>;
	var pagesSelected = <? echo sizeof($admin->pagesList); ?>;
	var localesSelected = <? echo sizeof($admin->localesList); ?>;
	var sectionsSelected = <? echo sizeof($admin->sectionsList); ?>;
	
	function checkContent(){
		var emailExpr = /^.+\@.+\..+$/;
		if (document.forms['adminForm'].elements['name'].value == ""){
			alert ('Morate uneti korisnicko ime administratora!');
			document.forms['adminForm'].elements['name'].focus();
			return false;
		}
		if (document.forms['adminForm'].elements['password'].value == ""){
			alert ('Morate uneti šifru adminstratora!');
			document.forms['adminForm'].elements['password'].focus();
			return false;
		}
		if (document.forms['adminForm'].elements['email'].value == ""){
			alert ('Morate uneti email administratora!');
			document.forms['adminForm'].elements['email'].focus();
			return false;
		}
		if (document.forms['adminForm'].elements['email'].value != "" && !emailExpr.test(document.forms['adminForm'].elements['email'].value) ){
      	alert("Format email adrese ne valja!");
      	document.forms['adminForm'].elements['email'].focus();
      	return false;
		}
		if (document.forms['adminForm'].elements['type'].value != "<?=$su ?>"){
			/*if (sectionsSelected == 0){
				alert ("Morate odabrati barem jednu sekciju za administratora!");
				return false;
			}
			if (localesSelected == 0){
				alert ("Morate odabrati barem jedan jezik za administratora!");
				return false;
			}
			if (document.forms['adminForm'].elements['sections[1]'].checked && pagesSelected == 0){
				alert ("Morate odabrati barem jednu stranu za administriranje ili onemogucite administriranje strukture!");
				return false;
			}*/
		}
	}
	
	function deleteAdmin(){
		if (confirm("Da li zaista želite da obrišete administratora?"))
			return true;
		else return false;
	}

	function displayEditor(type){
		if (type == "<?=$su ?>")
			document.getElementById("editorLayout").style.visibility = "hidden";
		else 
			document.getElementById("editorLayout").style.visibility = "visible";
	}
 
 	function updateVar(name, add) {
 		if (add) eval (name + "++");
 		else eval (name+"--");
	}	
</script>
<script language="JavaScript" type="text/javascript" src="../js/js.js"></script>
<? 
if($allowed){
	if($act=="insert"){?>
		<div class="pgsleft">
			Unos novog administratora<br><br>
		</div>
	<?	}?>
		<?	if($act != null && $act != "insert"){?>
				<form action="index.php?id=<?=$admin->id?>&act=del&locale=<?=$locale_id?>&sectionid=<?= $sectionid ?>" method="post" onSubmit="javascript:return deleteAdmin();">
					<div class="pgsitem">
						<img src="../img/i.gif" title="Brisanje"/>&nbsp;
						<input type="submit" value="BRISANJE ADMINISTRATORA" class="pgsctrlsbtt"/>
					</div>
				</form>
			<?	}?>
			<form name="adminForm" action="index.php?id=<?=$admin->id?>&act=<?=$act?>&locale=<?=$locale_id?>&sectionid=<?= $sectionid ?>" method="post" onSubmit="javascript:return checkContent();">
			<?	if($error){?>
			<div class="pgsitem">
				<div class="pgsleft">GREŠKA:</div>
				<div class="pgsright">Došlo je do greške, proverite unesene podatke!!!<br><?=$message?></div>
			</div>
			<?	}?>
			<div class="pgsitem">
				<div class="pgsleft"><img src="../img/i.gif" title="Unesite ime administratora maksimalne dužine 50 znakova."/>
				&nbsp;Ime:</div>
				<div class="pgsright"><input type="text" name="name" maxlength="50" value="<?=$admin->name?>" class="pgsform" /></div>
			</div>
			<div class="pgsitem">
				<div class="pgsleft"><img src="../img/i.gif" title="Unesite šifru administratora maksimalne dužine 50 znakova."/>
				&nbsp;Šifra:</div>
				<div class="pgsright"><input type="text" name="password" maxlength="50" value="<?=$admin->password?>" class="pgsform" /></div>
			</div>
			<div class="pgsitem">
				<div class="pgsleft"><img src="../img/i.gif" title="Unesite email administratora maksimalne dužine 250 znakova, ostaviti prazno ako nema email"/>
				&nbsp;Email:</div>
				<div class="pgsright"><input type="text" name="email" maxlength="250" value="<?=$admin->email?>" class="pgsform" /></div>
			</div>
			<div class="pgsitem">
				<div class="pgsleft"><img src="../img/i.gif" title="Tip administratora."/>
				&nbsp;Tip:</div>
				<div class="pgsright">
					<select name="type" class="text" onChange="javascript:displayEditor(this.value);">
					<?
					$types = $admin->getTypes();
					for($i = 0; $i < sizeof($types); $i++){
						$selected = "";
						if($admin->type  == $types[$i])
							$selected = "selected";
						?>
						<option value="<?=$types[$i]?>" <?=$selected?>><?=$types[$i]?></option>
					<?
					}
					?>
					</select>
				</div>
			</div>
			<div class="pgsitem">
				&nbsp;
			</div>
			<div name="editorLayout" id="editorLayout" style="visibility:<? if($admin->type == $su )echo "hidden"; else echo "visible";?>;">
				<div class="pgsitem">
					<div class="pgsleft"><img src="../img/i.gif" title="Za koje prodavnice administrator ima prava da menja sadrt¿½aj."/>
					&nbsp;Strane:</div>
					<div class="pgsright">
						<?$stores = $store->getAllStores();
						for($i = 0; $i < sizeof($stores); $i++){?>
							<input type="checkbox" name="stores[<?=$stores[$i]['id']?>]" <? if (in_array($stores[$i]['id'], $admin->stores_list)) echo "checked";?>>
								<?=$stores[$i]['name']?>, <?=$stores[$i]["city_name"]?><br>
						<?}?>
					</div>
				</div>
				<div class="pgsitem">
					<img src="../img/graydot.gif" width="450" height="1" />
				</div>
			</div>
			<div class="pgsitem">
				<div class="pgsleft">&nbsp;</div>
				<div class="pgsright"><input type="submit" value="UNOS    ADMINISTRATORA" class="pgsctrlsbtt"/></div>
			</div>
		</form>
<?
} else {/*not allowed*/?>
<div class="pgsitem">
	<?=$user->message?>
</div>
<?
	}
}
?>