<br>
<?
	/*get store info*/
	$mstore = new store();
	$mstore->getById($storeid);
	if($mstore->id) {?>
	
	<div id="printinfodiv">
		<h2>Print Preview</h2>
		*Napomena: Jos uvek ste na istoj internet strani, pritisak na Back dugme vaseg browsera ce vas vratiti dve strane u nazad. Koristite dugme 'Close' za gasenje print preview prozora.
		<br><br>
		<input type="button" style="cursor:pointer" value="Close" onMouseDown="unprintBasket()">
		<input type="button" style="cursor:pointer" value="Print" onMouseDown="window.print()">
	</div>
		
	<div id="infodiv">
	<?echo("Prodavnica ".$mstore->name.", ".$mstore->contact." ".$mstore->url); ?>
	<br><br>Dodaj prodavnicu za poredjenje cena: 
	
		<select name="stores" name="Odaberi prodavnicu" onChange="addStore(this,<?echo($storeid)?>)">
		  <option value="-1">Odaberi prodavnicu</option>
		  <?$mcity = new city();
			$mcities = $mcity->getAllCities();
			for ($i = 0; $i<sizeof($mcities);$i++){?>
				<OPTGROUP LABEL="<?echo ($mcities[$i]["name"]);?>"> 
				<?$mstore = new store();
				$mstores = $mstore->getAllStoresByCity($mcities[$i]["id"]);
				/*get all stores under city name*/
				for ($j = 0; $j<sizeof($mstores);$j++){
					if($storeid!=$mstores[$j]["id"]) {?>
						<option value="<?echo ($mstores[$j]["id"]);?>"><?echo ($mstores[$j]["name"]);?></option>
					<?}?>
				<?}?>
				</OPTGROUP>
			<?}?>
		</select>

	
	<br><br><a href="index.php?act=show_cities"> << back Home </a> <br><br>
	
	<input type="text" id="searchBox" onclick="selectText(this)" value="Unesi rec za pretragu"> 
	<input type="button" style="cursor:pointer" value="Trazi" onMouseDown="waitCursor(this)" onMouseUp="searchOnClick(this)">
	<input type="button" style="cursor:pointer" value="Ponisti" onClick="removeSearchTable()">
	<br><br>
	</div>
	
	<div id="searchTableDiv">
	</div><br><br>
<div id="storeTable">
	<table id="StoreTableID" width="100%"><tbody id="StoreTableBodyID">
	
	<?//get prices by store, divided into type sections
	$mptype = new ptype();
	$types = $mptype->getAllTypes();
	$rowcount = 0;
	for ($i = 0; $i<sizeof($types);$i++){?>

		<tr style="cursor:pointer" onMouseOut="highlightCategoryRowOut(this)" onMouseOver="highlightCategoryRow(this)" onMouseDown="waitCursor(this)" onMouseUp="CategoryRowClick(this)" id="<?echo($rowcount);?>"> <td id="jezicakCell" width="500px">

		<?/*create type row*/ echo ($types[$i]["name"]);?> 
		</td>
		<td id="jezicakSmallCell">cena</td>
		<td id="jezicakSmallCell">kolicina</td>
		<td id="jezicakSmallCell">dodaj</td>
		<td id="jezicakSmallCell">ukupno</td></tr>

		<?/*write all products under type name*/
		$product = new product();
		
		$prices = $product->getPricesByStoreType($storeid,$types[$i]["id"]);
		for ($j = 0; $j<sizeof($prices);$j++){ $rowcount++;?>
			<tr id="<?echo($rowcount);?>">
			<td class="productNameCell" id="productCell_<?echo($rowcount);?>"> 
			<?echo ($prices[$j]["pname"]);?>
			</td>
			<td class="productNameCell" id="priceCell_<?echo($rowcount);?>">
			<?if(!$prices[$j]["price"]) {echo("nema");}else{echo($prices[$j]["price"]);}?>
			</td>
			<td id="productCell"><input type="text" size="2" width="30" value="1" id="kolicina_<?echo($rowcount);?>"></td>
			<td id="productCell"><input type="button" style="cursor:pointer" value=" + " onclick="addToBasket(this)" id="<?echo($rowcount);?>"></td>
			<td id="productCell"><input type="text" size="2" value="0" disabled="disabled" id="amount_<?echo($rowcount);?>"></td>
			</tr>
		<?}?>
	</font></td></tr><? $rowcount++;
	}?>
</tbody></table></div>

<div class="transparent09" id="floatingBasket">
	<div class='noprint'>Sadrzaj Korpe</div>
	<table id="BasketTableID" cellspacing="0" cellpadding="0" width="100%"><tbody id="BasketTableBodyID">
	<tr>
	<td class='printBold' style="padding-left:3; padding-right:3; min-width:200;" nowrap>Proizvod</td>
	<td class='printBold' style="padding-left:3; padding-right:3;">Cena</td>
	<td class='printBold' style="padding-left:3; padding-right:3;">Kol</td>
	<td class='noprint' style="padding-left:3; padding-right:3;">-</td>
	</tr>
	<tr>
	<td id="totalText" style="padding-left:3; padding-right:3;">TOTAL</td>
	<td id="totalCell" style="padding-left:3; padding-right:3;" colspan="3">0.00</td>
	</tr>
	</tbody></table>
	<a class='noprint' style="cursor:pointer" onClick="saveBasketToCookie()"> sacuvaj </a>
	<a class='noprint' style="cursor:pointer" onClick="loadBasketFromCookie()"> ucitaj </a>
	<a class='noprint' style="cursor:pointer" onClick="emptyBasket()"> izprazni </a>
	<a class='noprint' style="cursor:pointer" onClick="printBasket()"> stampaj </a>
	<a class='noprint' style="cursor:pointer" onClick="sendBasket()"> posalji </a>
	<a class='noprint' id="sazminjkoID" style="cursor:pointer" onClick="collapseBasket()"> sazmi </a>
</div>

<div class="transparent09" class='noprint' id="floatingBasketMinimized">
	
	<table id="BasketTableMinimizedID" cellspacing="0" cellpadding="0" width="100%"><tbody id="BasketTableBodyMinimizedID">
	<tr>
	<td colspan="2" style="padding-left:3; padding-right:3; min-width:200;" nowrap>U korpi nema proizvoda</td>
	</tr>
	<tr>
	<td style="padding-left:3; padding-right:3;">TOTAL</td>
	<td style="padding-left:3; padding-right:3; color:#99FF99">0.00</td>
	</tr>
	</tbody></table>
	<a style="cursor:pointer" onClick="saveBasketToCookie()"> sacuvaj </a>
	<a class='noprint' style="cursor:pointer" onClick="loadBasketFromCookie()"> ucitaj </a>
	<a style="cursor:pointer" onClick="emptyBasket()"> izprazni </a>
	<a style="cursor:pointer" onClick="printBasket()"> stampaj </a>
	<a style="cursor:pointer" onClick="sendBasket()"> posalji </a>
	<a id="sazminjkoID" style="cursor:pointer" onClick="expandBasket()"> rasiri </a>
</div>
<br>

<?} else {?> nije pronadjena<?}?>
