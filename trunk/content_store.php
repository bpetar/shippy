<br>Radnja<br>
<?
	/*get store info*/
	$mstore = new store();
	$mstore->getById($storeid);
	echo($mstore->name); echo(", "); echo($mstore->contact); echo(" "); echo($mstore->url); ?>

	<br><br><a href="index.php?act=show_cities"> << back Home </a> <br><br>
	<table id="StoreTableID" width="650px"><tbody id="StoreTableBodyID">
	
	<?//get prices by store, divided into type sections
	$mptype = new ptype();
	$types = $mptype->getAllTypes();
	$rowcount = 0;
	for ($i = 0; $i<sizeof($types);$i++){?>

		<tr style="cursor:pointer" onclick="CategoryRowClick(this)" id="<?echo($rowcount);?>"> <td id="jezicakCell" width="500px">

		<?/*create type row*/ echo ($types[$i]["name"]);?> 

		</td><td id="jezicakCell"></td><td id="jezicakCell"></td><td id="jezicakCell"></td><td id="jezicakCell"></td></tr>
		
		<?/*write all products under type name*/
		$product = new product();
		
		$prices = $product->getPricesByStoreType($storeid,$types[$i]["id"]);
		for ($j = 0; $j<sizeof($prices);$j++){ $rowcount++;?>
			<tr id="<?echo($rowcount);?>">
			<td class="productNameCell" id="productCell_<?echo($rowcount);?>"> 
			<?echo ($prices[$j]["pname"]); ?>
			</td>
			<td class="productNameCell" id="priceCell_<?echo($rowcount);?>">
			<?if(!$prices[$j]["price"]) {echo("nema");}else{echo($prices[$j]["price"]);}?>
			</td>
			<td id="productCell"><input type="text" size="2" width="30" value="1" id="kolicina_<?echo($rowcount);?>"></td>
			<td id="productCell"><input type="button" style="cursor:pointer" value=" + " onclick="addToBasket(this)" id="<?echo($rowcount);?>"></td>
			<td id="productCell"><input type="text" size="2" value="0" id="amount_<?echo($rowcount);?>"></td>
			</tr>
		<?}?>
	</font></td></tr><? $rowcount++;
	}?>
</tbody></table>


<div id="storeTable" align=center></div>

<div id="floatingBasket">
	Sadrzaj Korpe
	<table id="BasketTableID" cellspacing="0" cellpadding="0" width="100%"><tbody id="BasketTableBodyID">
	<tr>
	<td style="padding-left:3; padding-right:3;">Proizvod</td>
	<td style="padding-left:3; padding-right:3;">Cena</td>
	<td style="padding-left:3; padding-right:3;">Kol</td>
	<td style="padding-left:3; padding-right:3;">-</td>
	</tr>
	<tr>
	<td style="padding-left:3; padding-right:3;">TOTAL</td>
	<td style="padding-left:3; padding-right:3; color:#99FF99" colspan="3">0.00</td>
	</tr>
	</tbody></table>
</div>

<br><br><br>asd<br><br>asd<br><br>asd<br><br><br><br>asd<br><br><br>asd<br><br><br><br>