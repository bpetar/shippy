	<script language="JavaScript" type="text/javascript">
	function deleteStore(){
		if (confirm("Da li zaista želite da obrišete prodavnicu?"))
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
				Unos nove prodavnice<br><br>
			</div>
		</div>
	<?	} else if($act != null){?>
	<div class="pgsitem">
		<form action="index.php?id=<?=$store->id?>&act=del" method="post" onSubmit="javascript:return deleteStore();">
			<div class="pgsleft">
				<img src="../img/i.gif" title="Brisanje"/>&nbsp;
			</div>
			<div class="pgsright">
				<input type="submit" value="BRISANJE PRODAVNICE" class="pgsctrlsbtt"/>
			</div>
		</form>
	</div>
	<?	}?>
<form name="unosforma" id="unosforma" onsubmit="javascript:return checkForm(this, 'name,city,contact', 'ime,grad,kontakt', 's,s,s,e,s,s')" action="index.php?act=<?=$act?>&id=<?=$store->id?>&typeid=<?= $typeid ?>" method="post">
	<div class="pgsitem">
		<div class="pgsleft"><img src="../img/i.gif" title="<?=$expl["name"]?>" alt="" style="vertical-align:middle;" />&nbsp;&nbsp;IME:</div>
		<div class="pgsright"><input type="text" name="name" id="name" value="<?=$store->name?>" maxlength="255" /></div>
	</div>
	<div class="pgsitem">
		<div class="pgsleft"><img src="../img/i.gif" title="<?=$expl["url"]?>" alt="" style="vertical-align:middle;" />&nbsp;&nbsp;URL:</div>
		<div class="pgsright"><input type="text" name="url" id="url" value="<?= $store->url ?>" maxlength="255" /></div>
	</div>
	<div class="pgsitem">
		<div class="pgsleft"><img src="../img/i.gif" title="<?=$expl["img1"]?>" alt="" style="vertical-align:middle;" />&nbsp;&nbsp;SLIKA MALA:</div>
		<div class="pgsright"><input type="text" name="image_small" id="image_small" value="<?=$store->image_small?>" maxlength="255" />&nbsp;<a href="javascript:insertFile('image_small', 'imgimg1', 'discimgs')" class="footlink">Izaberi malu sliku</a>
			<? if (!empty($store->image_small)) { ?>
				<br/><img id="imgimg1" name="imgimg1" src="<?=$store->image_small?>" border="0" />
			<?	} else {/*no image or flash*/ ?>
					<br/><img id="imgimg" name="imgimg1" src="../img/spacer.gif" border="0" style="display: none;"/>
			<? } ?>
		</div>
	</div>
	<div class="pgsitem">
		<div class="pgsleft"><img src="../img/i.gif" title="<?=$expl["img2"]?>" alt="" style="vertical-align:middle;" />&nbsp;&nbsp;SLIKA VELIKA:</div>
		<div class="pgsright"><input type="text" name="image_big" id="image_big" value="<?=$store->image_big?>" maxlength="255" />&nbsp;<a href="javascript:insertFile('image_big', 'imgimg2', 'discimgs')" class="footlink">Izaberi veliku sliku</a>
			<? if (!empty($store->image_big)) { ?>
				<br/><img id="imgimg1" name="imgimg2" src="<?=$store->image_big?>" border="0" />
			<?	} else {/*no image or flash*/ ?>
					<br/><img id="imgimg2" name="imgimg2" src="../img/spacer.gif" border="0" style="display: none;"/>
			<? } ?>
		</div>
	</div>
	<div class="pgsitem">
		<div class="pgsleft"><img src="../img/i.gif" title="<?=$expl["shopcontact"]?>" alt="" style="vertical-align:middle;" />&nbsp;&nbsp;CONTACT:</div>
		<div class="pgsright"><textarea name="contact" id="contact" rows="15" cols="100"><?=$store->contact?></textarea></div>
	</div>
	<div class="pgsitem">
		<div class="pgsleft"><img src="../img/i.gif" title="<?= $expl["city"] ?>" alt="" style="vertical-align:middle;" />&nbsp;&nbsp;GRAD:</div>
		<div class="pgsright">
			<select id="city" name="city">
		<?
			$city = new city();
			$cities = $city->getAllCities();
			foreach($cities as $item){
				$selected = "";
				if($item['id'] == $store->city){
					$selected = "selected";
				}
				echo("<option value=\"".$item['id']."\" ".$selected.">".$item['name']."</option>\n");
			}
		?>
			</select>
		</div>
	</div>
	<div class="pgsitem">
		<div class="pgsleft"></div>
		<div class="pgsright"><br><input type="submit" value="UNOS" onClick="javascript: clickSubmit('index.php', 'unosforma', '?id=<?=$id?>&act=<?=$act?>');" /></div>
	</div>
</form>