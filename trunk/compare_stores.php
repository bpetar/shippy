<br>
<?
	/*get store info*/
	
	$idArray = explode(',',$storeid);
	if($idArray)
	{
		$storesArray = array();?>
		
		<div id="printinfodiv">
			<h2>Print Preview</h2>
			*Napomena: Jos uvek ste na istoj internet strani, pritisak na Back dugme vaseg browsera ce vas vratiti dve strane u nazad. Koristite dugme 'Close' za gasenje print preview prozora.
			<br><br>
			<input type="button" style="cursor:pointer" value="Close" onMouseDown="unprintBasket()">
			<input type="button" style="cursor:pointer" value="Print" onMouseDown="window.print()">
		</div>
		
		<div id="infodiv">
		Prodavnice: 
		<?for($idIndex=0; $idIndex<sizeof($idArray); $idIndex++)
		{
			$mstore = new store();
			$mstore->getById($idArray[$idIndex]);
			$storesArray[$idIndex] = $mstore;
			echo($mstore->name); echo(", ");
		}?>

		<br><br>Dodaj prodavnicu za poredjenje cena: 
		
		<select name="stores" name="Odaberi prodavnicu" onChange="addStore(this,'<?echo($storeid);?>')">
		  <option value="-1">Odaberi prodavnicu</option>
		  <?$mcity = new city();
			$mcities = $mcity->getAllCities();
			for ($i = 0; $i<sizeof($mcities);$i++){?>
				<OPTGROUP LABEL="<?echo ($mcities[$i]["name"]);?>"> 
				<?$mstore = new store();
				$mstores = $mstore->getAllStoresByCity($mcities[$i]["id"]);
				/*get all stores under city name*/
				for ($j = 0; $j<sizeof($mstores);$j++){
					$foundInCompare = false;
					for($stid = 0; $stid<sizeof($idArray);$stid++) {
						if($idArray[$stid]==$mstores[$j]["id"]) {
							$foundInCompare = true;
						}
					}
					if(!$foundInCompare) {?>
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
		
		
		<div id="searchTableDiv">
		</div><br><br>

		<input type=text id="newProductText" size="81" onclick="selectText(this)" value="Ovde mozete dodati proizvoljnu stvar na spisak">
		<input type=text id="newPriceText" size="6" onclick="selectText(this)" value="Cena">
		<input type=text id="newAmountText" size="2" onclick="selectText(this)" value="Kol">
		<input type="button" style="cursor:pointer" value=" + " onMouseDown="AddUserInputToBasket()">
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
			<?for($stid = 0; $stid<sizeof($idArray);$stid++) {?>
			<td id="jezicakSmallCell"><?echo($storesArray[$stid]->name);?></td>
			<?}?>
			<td id="jezicakSmallCell">kolicina</td>
			<td id="jezicakSmallCell">dodaj</td>
			<td id="jezicakSmallCell">ukupno</td></tr>

			
			<?/*write all products under type name*/
			
			$product = new product();
			for($stid = 0; $stid<sizeof($idArray);$stid++) {
				$prices[$stid] = $product->getPricesByStoreType($idArray[$stid],$types[$i]["id"]);
			}
			for ($j = 0; $j<sizeof($prices[0]);$j++){ $rowcount++;?>
				<tr id="<?echo($rowcount);?>">
				<td class="productNameCell" id="productCell_<?echo($rowcount);?>">
				<?echo ($prices[0][$j]["pname"]); ?>
				</td>
				<?for($stid = 0; $stid<sizeof($idArray);$stid++) {?>
					<td class="productNameCell" id="priceCell_<?echo($stid);?>_<?echo($rowcount);?>">
					<?if(!$prices[$stid][$j]["price"]) {echo("nema");}else{echo($prices[$stid][$j]["price"]);}?>
					</td>
				<?}?>
				<td id="productCell"><input type="text" size="2" width="30" value="1" id="kolicina_<?echo($rowcount);?>"></td>
				<td id="productCell"><input type="button" style="cursor:pointer" value=" + " onclick="addToBasketMulti(this,<?echo(sizeof($idArray));?>)" id="<?echo($rowcount);?>"></td>
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
		<?for($stid = 0; $stid<sizeof($idArray);$stid++) {?>
			<td class='printBold' style="padding-left:3; padding-right:3"><?echo($storesArray[$stid]->name);?></td>
		<?}?>
		<td class='printBold' style="padding-left:3; padding-right:3;">Najjeftinije u</td>
		<td class='printBold' style="padding-left:3; padding-right:3;">Kol</td>
		<td class='noprint' style="padding-left:3; padding-right:3;">-</td>
		</tr>
		<tr>
		<td id="totalText" style="padding-left:3; padding-right:3;">TOTAL</td>
		<?for($stid = 0; $stid<sizeof($idArray);$stid++) {?>
		<td id="totalCell" style="padding-left:3; padding-right:3;">0.00</td>
		<?}?>
		</tr>
		</tbody></table>
		<a class='noprint' style="cursor:pointer" onClick="saveBasketToCookie()"> sacuvaj </a>
		<a class='noprint' style="cursor:pointer" onClick="emptyMultiBasket(<?echo(sizeof($idArray));?>)"> izprazni </a>
		<a class='noprint' style="cursor:pointer" onClick="printBasket()"> stampaj </a>
		<a class='noprint' style="cursor:pointer" onClick="sendBasket()"> posalji </a>
		<a class='noprint' id="sazminjkoID" style="cursor:pointer" onClick="collapseBasket()"> sazmi </a>
</div>

<div class='noprint' class="transparent09" id="floatingBasketMinimized">
		
		<table id="BasketTableMinimizedID" cellspacing="0" cellpadding="0" width="100%"><tbody id="BasketTableBodyMinimizedID">
		<tr>
		<td colspan="3" style="padding-left:3; padding-right:3; min-width:200;" nowrap>U korpi nema proizvoda</td>
		</tr>
		<tr>
		<td style="padding-left:3; padding-right:3; min-width:200;"></td>
		<?for($stid = 0; $stid<sizeof($idArray);$stid++) {?>
			<td style="padding-left:3; padding-right:3"><?echo($storesArray[$stid]->name);?></td>
		<?}?>
		</tr>
		<tr>
		<td style="padding-left:3; padding-right:3;">TOTAL</td>
		<?for($stid = 0; $stid<sizeof($idArray);$stid++) {?>
		<td style="padding-left:3; padding-right:3; color:#99FF99">0.00</td>
		<?}?>
		</tr>
		</tbody></table>
		<a style="cursor:pointer" onClick="saveBasketToCookie()"> sacuvaj </a>
		<a style="cursor:pointer" onClick="emptyMultiBasket(<?echo(sizeof($idArray));?>)"> izprazni </a>
		<a style="cursor:pointer" onClick="printBasket()"> stampaj </a>
		<a style="cursor:pointer" onClick="sendBasket()"> posalji </a>
		<a id="sazminjkoID" style="cursor:pointer" onClick="expandBasket()"> rasiri </a>
</div>
<br>

<?} else {?> nisu pronadjene<?}?>

<?
/*
Korisni parcadi koda:

href="<?echo($_SERVER["REQUEST_URI"]."&print=true");?>"

<a onMouseOver="this.style.color = '#FF0000'" onMouseOut="this.style.color = '#000000'" style="cursor:pointer" OnClick="unprintBasket()"> << Nazad </a>

*/
?>
