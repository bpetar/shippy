
//test
function test1(pthis)
{
	alert("evo me " + pthis.id);
}

//removes html tags from string (replaces things like &amp; with just '&')
function clearString(str)
{
	return str.replace(/\&amp;/g,'&');
}

function waitCursor(pthis)
{
	pthis.style.cursor = 'wait';
}

var HIGHLIGHT_ROW_COLOR = '#CCCCCC';
var ROW_COLOR = '#AAAAAA';


function addSearchRow( row , productID, name, categoryName)
{
	if(productID == -1)
	{
		var td = document.createElement("TD");
		td.appendChild(document.createTextNode("Ime Proizvoda"));
		td.width = 260;
		row.appendChild(td);
		
		td = document.createElement("TD");
		td.appendChild(document.createTextNode("Kategorija"));
		td.width = 100;
		row.appendChild(td);
		
		for (var storeIndex = 0; storeIndex < numStores; storeIndex++)
		{
			td = document.createElement("TD");
			td.appendChild(document.createTextNode(storeNames[storeIndex]));
			td.width = 80;
			row.appendChild(td);
		}

		td = document.createElement("TD");
		td.appendChild(document.createTextNode("Dodaj"));
		td.width = 120;
		row.appendChild(td);
		
		return;

	}
	
	var arrayID = productID.split("_"); //why split("_")? because ID is in the form: cell_1_42, cell_2_435, etc. so split will make two strings: "cell" and remaining numbers
	var prodID = arrayID[1]; //we take the number from id

	//get product name input and add this cell
	var td = document.createElement("TD");
 	td.id = productID;
 	td.appendChild(document.createTextNode(name));
	row.appendChild(td);
	
	var td = document.createElement("TD");
 	td.appendChild(document.createTextNode(categoryName));
//	td.style.textIndent = "20px";
	row.appendChild(td);
	
	for (var storeIndex = 0; storeIndex < numStores; storeIndex++)
	{
		var cellId = "cell_" + prodID + "_" + storeIDs[storeIndex];//this id will be used when removing is made
		var value = document.getElementById(cellId).firstChild.data;
		td = document.createElement("TD");
		td.appendChild(document.createTextNode(value));
		actionImg = document.getElementById(cellId).childNodes[1];
		if(actionImg)
		{
			var oImg=document.createElement("img");
			oImg.id = actionImg.id + "_";
			oImg.setAttribute('src', 'action.gif');
			oImg.onmouseover = function() {priceOnActionHover(this)};
			oImg.onmouseout = function() {priceOnActionHoverOut(this)};
			td.appendChild(oImg);
		}
		row.appendChild(td);
	}

	//create add buttons
	td = document.createElement("td");
	td.align = "right";
	var inp_add = document.createElement("input");
	inp_add.style.width = 47;
	inp_add.value = 1;
	inp_add.id = "searchAddToBasketInput_" + prodID;
	td.appendChild(inp_add);
	var btnAdd = document.createElement("input");
	btnAdd.id = "searchAddToBasketButton_" + prodID;
	btnAdd.value = 'Dodaj';
	btnAdd.type = 'button';
	btnAdd.onclick = function(){addToBasket(this)};
	td.appendChild(btnAdd);
	td.width = 108;
	row.appendChild(td);
}

function searchOnClick(pthis)
{

	var searchTableDiv = document.getElementById("searchTable");
	//remove previous search table
	while(searchTableDiv.lastChild)
	{
		searchTableDiv.removeChild(searchTableDiv.lastChild);
	}
	
	var searchTable = document.createElement("table");
	var searchTableBody = document.createElement("tbody");
	var found = false;
	
	//create header row: -1 is crucial parameter here
	var row = document.createElement("tr");
	addSearchRow(row, -1, "", "");
	row.style.background = "rgb(105,205,210)";
	searchTableBody.appendChild(row);
	searchTable.width = 360 + 120 + numStores*80;
	
	var productsRows = tblBody.getElementsByTagName('tr');	//add Product cell to the list table
	var category = 0;
	var categoryName = productsRows[0].getElementsByTagName('td')[0].innerHTML;
	for(var i = 1; i < productsRows.length -1; i++)
	{
		if(categoryRowsID[category+1] == i)
		{
			categoryName = productsRows[i].getElementsByTagName('td')[0].innerHTML;
			category++;
			continue;
		}
		if(i == categoryRowsID[category] + 1)
		{
			continue;
		}
		if(i == categoryRowsID[category+1] - 1)
		{
			continue;
		}

		var cells = productsRows[i].getElementsByTagName('td');
		var str = cells[0].innerHTML;
		lowerStr = str.toLowerCase();
		var phrase = document.getElementById("searchBox").value;
		if(lowerStr.match(phrase.toLowerCase()))
		{
			found = true;
			var row = document.createElement("tr");
			addSearchRow(row, cells[0].id, str, categoryName);
			searchTableBody.appendChild(row);
		}
	}

	// put the <tbody> in the <table>
	searchTable.appendChild(searchTableBody);
	// sets the border attribute of tbl to1;
	searchTable.setAttribute("border", "1");

	if(found)
	{
		cellText = document.createTextNode("Pronadjeni proizvodi:");
		searchTableDiv.appendChild(cellText);
		searchTableDiv.appendChild(document.createElement("br"));
		searchTableDiv.appendChild(document.createElement("br"));
		searchTableDiv.appendChild(searchTable);
	}
	else
	{
		cellText = document.createTextNode("Nije pronadjen ni jedan proizvod.");
		searchTableDiv.appendChild(cellText);
		searchTableDiv.appendChild(document.createElement("br"));
	}
	
	searchTableDiv.appendChild(document.createElement("br"));
	
	pthis.style.cursor = 'pointer';
}


function selectText(pthis)
{
	pthis.select();
}

function highlightCategoryRow(pthis)
{
	var children = pthis.getElementsByTagName('td');
	for(var i = 0; i < children.length; i++)
	{
		children[i].style.backgroundColor = HIGHLIGHT_ROW_COLOR;
	}
}

function highlightCategoryRowOut(pthis)
{
	var children = pthis.getElementsByTagName('td');
	for(var i = 0; i < children.length; i++)
	{
		children[i].style.backgroundColor = ROW_COLOR;
	}
}

//user clicked the category - expand/colapse it
function CategoryRowClick(pthis)
{
	var rowid = parseInt(pthis.id) + 1;
	var rows = document.getElementById("StoreTableBodyID").getElementsByTagName('tr');
	var row = rows[rowid];
	
	while (row.style.cursor != 'pointer')
	{
		if(row.style.display == 'none')	{
			row.style.display = '';
		} else {
			row.style.display = 'none';
		}
		
		rowid++;
		row = rows[rowid];
	}
	
	rows[pthis.id].style.cursor = 'pointer';
}

//create table cell with given text, fontsize and color
function createBasketCell(text, fontsize, fontcolor)
{
	var td = document.createElement("td");
	var cellText = document.createTextNode(text);
	td.appendChild(cellText);
	td.style.margin = "-1";
	td.style.paddingLeft = 3;
	td.style.paddingRight = 3;
	td.border = "0";
	td.style.color = fontcolor;
	td.style.fontSize = fontsize;
	return td;
}

//Remove 1 product from basket
function removeFromBasket(rowIndex)
{
	//get price from given row
	var basketRow = document.getElementById("basketRow_"+rowIndex);
	var price = parseFloat(basketRow.getElementsByTagName('td')[1].innerHTML);
	var amountCell = basketRow.getElementsByTagName('td')[2];
	var amount = parseInt(amountCell.innerHTML);
	
	//get total cell
	var basketTableBody = document.getElementById("BasketTableBodyID");
	var basketRows = basketTableBody.getElementsByTagName('tr');
	var totalCell = basketRows[basketRows.length-1].getElementsByTagName('td')[1];
	
	//subtract price from total amout
	if(price)
	{
		var total = parseFloat(totalCell.innerHTML) - price;
		totalCell.innerHTML = total.toFixed(2);
	}
		
	if(amount>1) {
		//just reduce the amount by 1
		amountCell.innerHTML = amount-1;
	} else {
		//remove given row
		basketTableBody.removeChild(basketRow);
	}
}

//Adds product to the basket table
function addToBasket(pthis)
{
	var basketTableBody = document.getElementById("BasketTableBodyID");
	var basketRows = basketTableBody.getElementsByTagName('tr');
	var found = false;
	var rowID = pthis.id;
	var amount = parseInt(document.getElementById("kolicina_"+rowID).value);
	
	//get product price and name
	var productCellID = "productCell_" + rowID;
	var priceCellID = "priceCell_" + rowID;
	var productName = clearString(document.getElementById(productCellID).innerHTML);
	var price = document.getElementById(priceCellID).innerHTML;

	//add price to total amout
	if(!price.match("nema"))
	{
		var totalCell = basketRows[basketRows.length-1].getElementsByTagName('td')[1];
		var total = parseFloat(totalCell.innerHTML) + amount*parseFloat(price);
		totalCell.innerHTML = total.toFixed(2);
	}

	//find if added product already exists in the selectedTable
	var productFromSelectedList;
	for(index = 0; index < basketRows.length; index++)
	{
		productFromSelectedList = clearString(basketRows[index].getElementsByTagName('td')[0].innerHTML);

		if (productName == productFromSelectedList)
		{
			var totalAmount = parseInt(basketRows[index].getElementsByTagName('td')[2].innerHTML);
			//product already exists in the basket, just increase the amount
			totalAmount += amount;
			basketRows[index].getElementsByTagName('td')[2].innerHTML = totalAmount;
			document.getElementById("amount_"+rowID).value = totalAmount;
			found = true;
			break;
		}
	}
	
	if(!found)
	{
		//create new product row, insert it at the bottom of table (but above last table line with TOTAL amount)
		var basketTable = document.getElementById("BasketTableID");
		var row = basketTable.insertRow(basketTable.rows.length-1);
		row.id = 'basketRow_'+rowID;
		
		//add Product cell to the list selectedTable
		row.appendChild(createBasketCell(productName, '12px', '#EEEEEE'));
		//add Price cell to the selectedTable
		row.appendChild(createBasketCell(price, '12px', '#EE8888'));
		//add Amount cell to the selectedTable
		row.appendChild(createBasketCell(amount, '12px', '#EEEEEE'));
				
		//add "remove" link
		var td = createBasketCell(" - ", '12px', '#888888')
		td.style.cursor = 'pointer';
		td.onclick = function(){removeFromBasket(rowID)};
		row.appendChild(td);
		
		//update amount in table line
		document.getElementById("amount_"+rowID).value = amount;
		document.getElementById("amount_"+rowID).style.backgroundColor="#FFFF44";
	}

}