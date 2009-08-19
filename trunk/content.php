<br>Gradovi<br><br>
odaberi radnju u gradu u kojem zivis
<br><br><br>
<?
	/*get all cities from database*/
	$mcity = new city();
	$mcities = $mcity->getAllCities();
	?><table id="CityStoresTableID" border="1"><tbody><?
	
	for ($i = 0; $i<sizeof($mcities);$i++){
		/*create city row*/?>
		<tr> <td id="jezicakCell">
		<?echo ($mcities[$i]["name"]);?> 
		</td><td id="jezicakCell"></td></tr>
		<?$mstore = new store();
		$mstores = $mstore->getAllStoresByCity($mcities[$i]["id"]);
		/*get all stores under city name*/
		for ($j = 0; $j<sizeof($mstores);$j++){?>
			<tr> <td id="cityCell"> <a href="index.php?act=show_store&storeid=<?echo ($mstores[$j]["id"]);?>">
			<?echo ($mstores[$j]["name"]);?>
			,&nbsp;
			<?echo ($mstores[$j]["contact"]);?> 
			</a></td>
			<td id="cityCell"><input type="checkbox" id="storecheckbox"></td></tr>
		<?}?>
	</font></td></tr><?
	}
	
?>
</tbody></table>

<div id="storeTable" align=center></div>

<br><br><br>asd<br><br>asd<br><br>asd<br><br><br><br>asd<br><br><br>asd<br><br><br><br>