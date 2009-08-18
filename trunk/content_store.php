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
	for ($i = 0; $i<sizeof($types);$i++){?>

		<tr> <td id="jezicakCell">

		<?/*create type row*/ echo ($types[$i]["name"]);?> 

		</td><td id="jezicakCell"></td><td id="jezicakCell"></td></tr>
		
		<?/*write all products under type name*/
		$product = new product();
		
		$prices = $product->getPricesByStoreType($storeid,$types[$i]["id"]);
		for ($j = 0; $j<sizeof($prices);$j++){?>
			<tr>
			<td id="productCell"> 
			<?echo ($prices[$j]["pname"]);?>
			</td>
			<td>
			<?echo ($prices[$j]["price"]);?>
			</td>
			<td id="cityCell"><input type="checkbox" id="storecheckbox"></td>
			</tr>
		<?}?>
	</font></td></tr><?
	}

?>
</tbody></table>

<script type="text/javascript">

//create and display table with data from xml file
function CreateStoreTable()
{
	var tableWidth = 400;
	
	// creates a <table> element and a <tbody> element
	storesTable = document.createElement("table");
	tblBody = document.createElement("tbody");
	var rowCount = 0;

	xmlDoc=loadXMLDoc("stores.xml");

	// get stores node tree
	var storeData = xmlDoc.getElementsByTagName("stores")[0];
	
	//get names of the stores from stores XML
	var cityIndex = 0;
	var cityRowIndex = 0;
	for (cityIndex = 0; cityIndex < storeData.childNodes.length; cityIndex++) 
	{
		//get city node list
		var cityNode = storeData.childNodes[cityIndex];
		if (cityNode.nodeType == 1)
		{
			var cityName = cityNode.getAttribute("name");
			//storesDiv.appendChild(document.createTextNode(cityName));
			
			var nameRow = document.createElement("tr");
			//nameRow.style.paddingLeft = "20px";
			//nameRow.id = typeName;
			var nameCell = document.createElement("td");
			//nameCell.style.background = "rgb(235,235,140)";
			nameCell.style.backgroundImage="url('jezicak.gif')";
			nameCell.style.textIndent = "30px";
			nameCell.style.color= '#ffffff';
			nameCell.style.fontFamily = 'Arial'
			nameCell.style.fontWeight = 'bold';
			nameCell.style.fontSize = 30;
			
			nameCell.id = cityRowIndex;
			nameCell.onclick = function(){CategoryRowClick(this)};
			nameCell.onmouseover = function(){tabMouseOver(this)};
			nameCell.onmouseout = function(){tabMouseOut(this)};
			nameCell.colSpan = 3;//number of stores + 2 info cols
			cellText = document.createTextNode(cityName);
			nameCell.appendChild(cellText);
			nameRow.appendChild(nameCell);
			tblBody.appendChild(nameRow);
			
			categoryRowsID[cityRowIndex] = rowCount;
			numCategories++;
			rowCount++;
			cityRowIndex++

			//get all stores from this city
			var storeIndex = 0;
			for (storeIndex = 0; storeIndex < cityNode.childNodes.length; storeIndex++) 
			{
				// get store record
				var storeRecord = cityNode.childNodes[storeIndex];
				if (storeRecord.nodeType == 1)
				{

					var storeName = storeRecord.getElementsByTagName("name")[0].firstChild.nodeValue;
					var storeId = storeRecord.getElementsByTagName("id")[0].firstChild.nodeValue;
					var storeAddress = storeRecord.getElementsByTagName("address")[0].firstChild.nodeValue;
					var row = document.createElement("tr");
					
					//create store name cell
					var storeCell = document.createElement("td");
					storeCell.id = "store_" + storeId;
					cellText = document.createTextNode(storeName);
					storeCell.appendChild(cellText);
					storeCell.style.textDecoration='underline';
					storeCell.style.textIndent = "20px";
					storeCell.onclick = function(){StoreClick(this)};
					storeCell.onmouseover = function(){storeMouseOver(this)};
					storeCell.onmouseout = function(){storeMouseOut(this)};
					row.appendChild(storeCell);
					
					//create address cell
					storeCell = document.createElement("td");
					cellText = document.createTextNode(storeAddress);
					storeCell.appendChild(cellText);
					storeCell.id = "store_" + storeId;
					storeCell.style.textDecoration='underline';
					storeCell.onclick = function(){StoreClick(this)};
					storeCell.onmouseover = function(){storeMouseOver(this)};
					storeCell.onmouseout = function(){storeMouseOut(this)};
					row.appendChild(storeCell);
					
					//create check box
					storeCell = document.createElement("td");
					storeCell.align="center";
					var chkBox = document.createElement("input");
					chkBox.id = "checkBox_" + numStores;
					chkBox.type = 'checkbox';
					chkBox.onclick = function(){checkBoxClick(this)};
					storeCell.appendChild(chkBox);
					row.appendChild(storeCell);
		
					if(expandCollapseMode == "ONE_CATEGORY_AT_THE_THE_TIME")
					{
						if(cityRowIndex>1)
						{
							row.style.display = 'none';
						}
					}
					
					tblBody.appendChild(row);
					rowCount++;

					storeIDs[numStores] = storeId;
					storeNames[numStores] = storeName;
					numStores++;
					
					//tableWidth += 130;
					
					
				}
			}
		}
	}
	
	// creates last table row
	var lastRow = document.createElement("tr");
	var lastCells = document.createElement("td");
	lastCells.style.backgroundImage="url('bottom_jezicak.gif')";
	lastCells.colSpan = 2;
	var lastText = document.createTextNode("dancing with the badgers!");
	lastCells.appendChild(lastText);
	lastCells.style.color= '#ff0000';
	lastCells.style.fontFamily = 'Arial'
	lastCells.style.fontWeight = 'normal';
	lastCells.style.textIndent = "30px";
	lastCells.style.fontSize = 31;
	lastRow.appendChild(lastCells);

	//compare button
	lastCells = document.createElement("td");
	lastCells.style.backgroundImage="url('bottom.gif')";
	var cmpBtn = document.createElement("input");
	cmpBtn.value = 'Uporedi';
	cmpBtn.type = 'button';
	cmpBtn.onclick = compareStores;
	lastCells.appendChild(cmpBtn);
	lastCells.style.color= '#ff0000';
	lastCells.style.fontFamily = 'Arial'
	lastCells.style.fontWeight = 'normal';
	lastCells.style.fontSize = 31;
	
	lastRow.appendChild(lastCells);
	tblBody.appendChild(lastRow);
	//rowCount++;

	oldStartIndex = categoryRowsID[0]; //this will be first category opened
	oldEndIndex = categoryRowsID[1];
	categoryRowsID[cityRowIndex] = rowCount;
	
	// put the <tbody> in the <table>
	storesTable.appendChild(tblBody);
	// sets the border attribute of tbl to1;
	storesTable.setAttribute("border", "0");
	// appends <table> into <storesDiv>
	storesDiv.appendChild(storesTable);
}	
</script>

<div id="storeTable" align=center></div>

<br><br><br>asd<br><br>asd<br><br>asd<br><br><br><br>asd<br><br><br>asd<br><br><br><br>