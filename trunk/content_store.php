<br>Radnja<br>
<?
	/*get store info*/
	$mstore = new store();
	$mstore->getById($storeid);
	echo($mstore->name); echo(", "); echo($mstore->contact); echo(" "); echo($mstore->url); ?>

	<br><br><a href="index.php?act=show_cities"> << back Home </a> <br><br>
	<table id="CityStoresTableID" border="1"><tbody>
	
	<?//get prices by store, divided into type sections
	$mptype = new ptype();
	$types = $mptype->getAllTypes();
	$rowcount = 0;
	for ($i = 0; $i<sizeof($types);$i++){ $rowcount++;?>

		<tr style="cursor:pointer" onclick="CategoryRowClick(this)" id="<?echo($rowcount);?>"> <td id="jezicakCell">

		<?/*create type row*/ echo ($types[$i]["name"]);?> 

		</td><td id="jezicakCell"></td><td id="jezicakCell"></td></tr>
		
		<?/*write all products under type name*/
		$product = new product();
		
		$prices = $product->getPricesByStoreType($storeid,$types[$i]["id"]);
		for ($j = 0; $j<sizeof($prices);$j++){ $rowcount++;?>
			<tr id="<?echo($rowcount);?>">
			<td id="productCell"> 
			<?echo ($prices[$j]["pname"]); ?>
			</td>
			<td>
			<?echo ($prices[$j]["price"]);?>
			</td>
			<td id="cityCell"><input type="checkbox" onclick="addToBasket(this)" id="<?echo($rowcount);?>"></td>
			</tr>
		<?}?>
	</font></td></tr><?
	}

?>
</tbody></table>


<div id="storeTable" align=center></div>

<br><br><br>asd<br><br>asd<br><br>asd<br><br><br><br>asd<br><br><br>asd<br><br><br><br>