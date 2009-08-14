	<script language="JavaScript" type="text/javascript">
	function deleteDisc(){
		if (confirm("Da li zaista želite da obrišete tip proizvoda?"))
			return true;
		else return false;
	}
	</script>
<?	if($error){?>
	<div class="pgsitem">
		<div class="pgsleft">GREŠKA:</div>
		<div class="pgsright">Došlo je do greške, proverite unesene podatke!!!<br><?=$message?></div>
	</div>
<?	}
	if($act=="insert"){?>
		<div class="pgsitem">
			<div class="pgsleft">
				Unos novog tipa proizvoda<br><br>
			</div>
		</div>
	<?	} else if($act != null){?>
	<div class="pgsitem">
		<form action="index.php?id=<?=$ptype->id?>&act=del" method="post" onSubmit="javascript:return deleteDisc();">
			<div class="pgsleft">
				<img src="../img/i.gif" title="Brisanje"/>&nbsp;
			</div>
			<div class="pgsright">
				<input type="submit" value="BRISANJE TIPA PROIZVODA" class="pgsctrlsbtt"/>
			</div>
		</form>
	</div>
	<?	}?>
<form name="unosforma" id="unosforma" onsubmit="javascript:return checkForm(this, 'name', 'ime', 's')" action="index.php?act=<?=$act?>&id=<?=$ptype->id?>" method="post">
	<div class="pgsitem">
		<div class="pgsleft"><img src="../img/i.gif" title="<?=$expl["name"]?>" alt="" style="vertical-align:middle;" />&nbsp;&nbsp;IME:</div>
		<div class="pgsright"><input type="text" name="name" id="name" value="<?=$ptype->name?>" maxlength="255" /></div>
	</div>
	<div class="pgsitem">
		<div class="pgsleft"></div>
		<div class="pgsright"><br><input type="submit" value="UNOS" onClick="javascript: clickSubmit('index.php', 'unosforma', '?act=<?=$act?>');" /></div>
	</div>
</form>