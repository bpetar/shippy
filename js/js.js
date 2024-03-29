
//alert test
function test1(pthis)
{
	alert("evo me " + pthis.id);
}

//removes html tags from string (replaces things like &amp; with just '&')
function clearString(str)
{
	var newstr = str.replace(/^\s+|\s+$/g,"");
	return newstr.replace(/\&amp;/g,'&');
}

function waitCursor(pthis)
{
	pthis.style.cursor = 'wait';
	mousepresed = true;
}

var HIGHLIGHT_ROW_COLOR = '#CCCCCC';
var ROW_COLOR = '#AAAAAA';


function selectText(pthis)
{
	pthis.select();
}

function addStore(select,ids)
{
	var storeid = select.options[select.selectedIndex].value;
	if(storeid >= 0)
	{
		var url = "index.php?act=compare_stores&storeid=" + ids + "," + storeid;
		window.location = url;
	}
}

function expandBasket()
{
	document.getElementById("floatingBasket").style.display = 'block';
	document.getElementById("floatingBasketMinimized").style.display = 'none';
}

function collapseBasket()
{
	document.getElementById("floatingBasket").style.display = 'none';
	document.getElementById("floatingBasketMinimized").style.display = 'block';
}

function onUnload()
{
	var basketTable = document.getElementById("BasketTableID");
	for(var i = 1; i < basketTable.rows.length-1; i++)
	{
		//remove yellow marker in main table
		var rowIDstring = basketTable.rows[i].id;
		var strArray = rowIDstring.split("_");
		var productRowID = strArray[1];
		document.getElementById("amount_"+productRowID).value = 0;
		document.getElementById("amount_"+productRowID).style.backgroundColor="#DDDDDD";
	}
}

function emptyBasket()
{
	var basketTable = document.getElementById("BasketTableID");
	while(basketTable.rows.length > 2)
	{
		//remove yellow marker in main table
		var rowIDstring = basketTable.rows[1].id;
		var strArray = rowIDstring.split("_");
		var productRowID = strArray[1];
		if(productRowID>0)
		{
			document.getElementById("amount_"+productRowID).value = 0;
			document.getElementById("amount_"+productRowID).style.backgroundColor="#DDDDDD";
		}
		//delete the basket row
		basketTable.deleteRow(1);
	}
	basketTable.rows[1].getElementsByTagName('td')[1].innerHTML = '0.00';
	
	var basketTableMinimized = document.getElementById("BasketTableMinimizedID");
	basketTableMinimized.rows[1].getElementsByTagName('td')[1].innerHTML = '0.00';
	basketTableMinimized.rows[0].getElementsByTagName('td')[0].innerHTML = 'U korpi nema proizvoda';
}

function emptyMultiBasket(numStores)
{
	var basketTable = document.getElementById("BasketTableID");
	while(basketTable.rows.length > 2)
	{
		//remove yellow marker in main table
		var rowIDstring = basketTable.rows[1].id;
		var strArray = rowIDstring.split("_");
		var productRowID = strArray[1];
		if(productRowID>0)
		{
			document.getElementById("amount_"+productRowID).value = 0;
			document.getElementById("amount_"+productRowID).style.backgroundColor="#DDDDDD";
		}
		//delete the basket row
		basketTable.deleteRow(1);
	}
	var basketTableMinimized = document.getElementById("BasketTableMinimizedID");
	for(i=0; i<numStores; i++) {
		basketTable.rows[1].getElementsByTagName('td')[1+i].innerHTML = '0.00';
		basketTableMinimized.rows[2].getElementsByTagName('td')[1+i].innerHTML = '0.00';
	}
	basketTableMinimized.rows[0].getElementsByTagName('td')[0].innerHTML = 'U korpi nema proizvoda';
}

function AddUserInputToBasket(numStores)
{
	var prices = new Array();
	var amount = "";
	alert(numStores);
	for(var i=0; i<numStores; i++)
	{
		prices[i] = "nema";
		if((document.getElementById("newPriceText").value != "Cena")&&(document.getElementById("newPriceText").value != ""))
		{
			prices[i] = document.getElementById("newPriceText").value;
		}
	}
	if(document.getElementById("newProductText").value == "")
	{
		alert("Unesite neki proizvod koji zelite dodati u korpu");
		return;
	}
	if(document.getElementById("newProductText").value == "Ovde mozete dodati proizvoljnu stvar na spisak")
	{
		alert("Unesite neki proizvod koji zelite dodati u korpu");
		return;
	}
	
	if(document.getElementById("newAmountText").value == "Kol")
	{
		amount = 1;
	}
	else
	{
		amount = document.getElementById("newAmountText").value;
	}

	feedBasketWithAllData(document.getElementById("newProductText").value, prices, amount, -1);
}

function setCookie(c_name,value,expiredays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" + escape(value) + ((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

function getCookie(c_name)
{
	if (document.cookie.length>0)
  {
  	c_start=document.cookie.indexOf(c_name + "=");
  	if (c_start!=-1)
    { 
    	c_start=c_start + c_name.length+1; 
    	c_end=document.cookie.indexOf(";",c_start);
    	if (c_end==-1) c_end=document.cookie.length;
    		return unescape(document.cookie.substring(c_start,c_end));
    } 
  }
	return "";
}

function saveBasketToCookie()
{
	var cookieValue = "";
	var amountCookieValue = "";
	var basketTable = document.getElementById("BasketTableID");
	
	//var row = basketTable.insertRow(basketTable.rows.length-1);
	for (var i=1; i< basketTable.rows.length-1; i++)
	{
		if(i!=1)
		{
			cookieValue += ",";
			amountCookieValue += ",";
		}
		var rowID = basketTable.rows[i].id;
		var idArray = rowID.split("_");
		var ID = idArray[1];
		cookieValue += ID;
		var rowCells = basketTable.rows[i].getElementsByTagName('td');
		amountCookieValue += rowCells[rowCells.length-2].innerHTML;
	}

	setCookie("items",cookieValue,45);
	setCookie("amounts",amountCookieValue,45);
	alert("Korpa je sacuvana \nu kolacicu na vasem racunaru." + cookieValue);
}

function loadBasketFromCookie()
{
	emptyBasket();
	var items = getCookie('items');
	var amounts = getCookie('amounts');
	if (items!=null && items!="" && items!="undefined")
	{
		var itemIDs = items.split(",");
		var itemAmounts = amounts.split(",");
		for(var a=0; a < itemIDs.length; a++)
		{
			feedBasket(itemIDs[a],itemAmounts[a]);
		}
	}
}

function sendBasket()
{
	var message = "Evo mog spiska:\n\n";
	var basketTable = document.getElementById("BasketTableID");
	
	var longestName = 0;
	var longestPrice = 0;
	
	for (var i=1; i< basketTable.rows.length-1; i++)
	{
		var rowCells = basketTable.rows[i].getElementsByTagName('td');
		var product = clearString(rowCells[0].innerHTML);
		var price = clearString(rowCells[1].innerHTML);
		
		if(longestName < product.length)
		{
			longestName = product.length;
		}
		if(longestPrice < price.length)
		{
			longestPrice = price.length;
		}
	}
	
	//var row = basketTable.insertRow(basketTable.rows.length-1);
	for (var i=1; i< basketTable.rows.length-1; i++)
	{
		var rowCells = basketTable.rows[i].getElementsByTagName('td');
		var product = clearString(rowCells[0].innerHTML);
		var price = clearString(rowCells[1].innerHTML);
		var amount = rowCells[rowCells.length-2].innerHTML;
		message += product;
		for(var space=0; space < longestName-product.length; space++)
		{
			message += " ";
		}
		message += "\t";
		message += amount;
		message += "kom.\n";
	}
	var total = basketTable.rows[basketTable.rows.length-1].getElementsByTagName('td')[1].innerHTML;
	message += "\nTOTAL: " 
	message += total;

	self.location="mailto:?&subject=Spisak za prodavnicu&body="+encodeURIComponent(message);

}

function printBasket()
{
	if(document.getElementById("floatingBasket").style.display == 'none')
	{
		expandBasket();
	}
	document.getElementById("cssprint").href = 'css/print_style1.css';
	document.getElementById("css1").href = 'css/print_preview_style.css';
}

function unprintBasket()
{
	document.getElementById("cssprint").href = 'css/style.css';
	document.getElementById("css1").href = 'css/style.css';
}

function removeSearchTable()
{
	var searchTableDiv = document.getElementById("searchTableDiv");
	
	//remove previous search table
	while(searchTableDiv.lastChild)
	{
		searchTableDiv.removeChild(searchTableDiv.lastChild);
	}
	
	document.getElementById("searchBox").value = 'Unesi rec za pretragu';
}

//create table cell with given text, fontsize and color
function createSearchCell(text, fontsize, background)
{
	var td = document.createElement("td");
	var cellText = document.createTextNode(text);
	td.appendChild(cellText);
	td.style.margin = "-1";
	td.style.paddingLeft = 3;
	td.style.paddingRight = 3;
	td.border = "0";
	td.style.color = '#DDDDDD';
	td.style.backgroundColor=background;
	td.style.fontSize = fontsize;
	return td;
}

function createSearchRow( productID, name, categoryName, price)
{
	var row = document.createElement("tr");
	row.appendChild(createSearchCell(name, 16, '#222222'));
	row.appendChild(createSearchCell(categoryName, 16, '#222222'));
	row.appendChild(createSearchCell(price, 16, '#222222'));
	
	var td = document.createElement("td");
	var inputKolicina = document.createElement("input");
	inputKolicina.id = productID;
	inputKolicina.value = document.getElementById("kolicina_"+productID).value;
	inputKolicina.size = '2';
	inputKolicina.type = 'text';
	inputKolicina.onchange = function(){document.getElementById("kolicina_"+this.id).value = this.value};
	td.appendChild(inputKolicina);
	row.appendChild(td);
	
	td = document.createElement("td");
	var inputAdd = document.createElement("input");
	inputAdd.id = productID;
	inputAdd.value = ' + ';
	inputAdd.type = 'button';
	inputAdd.onclick = function(){addToBasket(this)};
	td.appendChild(inputAdd);
	row.appendChild(td);
	
	return row;
}

function createSearchHeaderRow()
{
	var row = document.createElement("tr");
	row.appendChild(createSearchCell("Ime Proizvoda", 16, '#666666'));
	row.appendChild(createSearchCell("Kategorija", 16, '#666666'));
	row.appendChild(createSearchCell("Cena", 16, '#666666'));
	row.appendChild(createSearchCell("Kol", 16, '#666666'));
	row.appendChild(createSearchCell("Kupi", 16, '#666666'));
	return row;
}

function fillSearchTable(searchTableBody)
{
	searchTableBody.appendChild(createSearchHeaderRow());
	var found = false;
	var productsRows = document.getElementById("StoreTableBodyID").getElementsByTagName('tr');
	var categoryName = clearString(productsRows[0].getElementsByTagName('td')[0].innerHTML);
	var productName = "";
	var productPrice = 0;
	var searchTerm = document.getElementById("searchBox").value.toLowerCase();
	
	for(var i = 1; i < productsRows.length -1; i++)
	{
		if(productsRows[i].style.cursor == 'pointer') 
		{
			categoryName = productsRows[i].getElementsByTagName('td')[0].innerHTML;
			continue;
		}
		
		productName = clearString(productsRows[i].getElementsByTagName('td')[0].innerHTML);
		
		if(productName.toLowerCase().match(searchTerm)) 
		{
			productPrice = productsRows[i].getElementsByTagName('td')[1].innerHTML;
			searchTableBody.appendChild(createSearchRow(i,productName,categoryName,productPrice));
			found = true;
		}
	}
	return found;
}

function searchOnClick(pthis)
{
	var searchTableDiv = document.getElementById("searchTableDiv");
	
	//remove previous search table
	while(searchTableDiv.lastChild)
	{
		searchTableDiv.removeChild(searchTableDiv.lastChild);
	}
	
	var searchTable = document.createElement("table");
	var searchTableBody = document.createElement("tbody");
	var found = false;
	
	found = fillSearchTable(searchTableBody);
	
	searchTable.appendChild(searchTableBody);
	
	if(found)
	{
		searchTableDiv.appendChild(document.createTextNode("Pronadjeni proizvodi:"));
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
	
	//fix one bug here, if mouse is pressed over the row, and moved away, then mouse up event will not be handled by the row, so pointer will remain 'wait'
	pthis.style.cursor = 'pointer';
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
function createBasketCell(text, className)
{
	var td = document.createElement("td");
	var cellText = document.createTextNode(text);
	td.appendChild(cellText);
	td.border = "0";
	td.className  = className;
	return td;
}

//Remove 1 product from basket
function removeFromBasketMulti(rowIndex, numStores)
{
	var basketTableMinimized = document.getElementById("BasketTableMinimizedID");
	var basketTable = document.getElementById("BasketTableID");
	
	//get price from given row
	var basketRow = document.getElementById("basketRow_"+rowIndex);
	var cells = basketRow.getElementsByTagName('td');
	var price = parseFloat(cells[1].innerHTML);
	var amountCell = cells[cells.length-2];
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
		basketTableMinimized.rows[basketTableMinimized.rows.length-1].getElementsByTagName('td')[1].innerHTML = total.toFixed(2);
	}

	if(amount>1) {
		//just reduce the amount by 1
		amountCell.innerHTML = amount-1;
	} else {
		//remove given row
		basketTableBody.removeChild(basketRow);
		
		var numProducts = basketTable.rows.length-2;
		if(numProducts == 0) {
			basketTableMinimized.rows[0].getElementsByTagName('td')[0].innerHTML = 'U korpi nema proizvoda';
		} else if (numProducts == 1){
			basketTableMinimized.rows[0].getElementsByTagName('td')[0].innerHTML = 'U korpi ima ' + 1 + ' proizvod';
		} else {
			basketTableMinimized.rows[0].getElementsByTagName('td')[0].innerHTML = 'U korpi ima ' + numProducts + ' proizvoda';
		}
		
		//remove yellow marker
		document.getElementById("amount_"+rowIndex).value = 0;
		document.getElementById("amount_"+rowIndex).style.backgroundColor="#DDDDDD";
	}
}

function feedBasketWithAllData(productName, prices, amount, rowID)
{
	var basketTableMinimized = document.getElementById("BasketTableMinimizedID");
	var basketTableBody = document.getElementById("BasketTableBodyID");
	var basketRows = basketTableBody.getElementsByTagName('tr');
	var found = false;

	for(var stNum = 0; stNum<prices.length; stNum++) {
		//add prices to total amout
		if(!prices[stNum].match("nema"))
		{
			var totalCell = basketRows[basketRows.length-1].getElementsByTagName('td')[1+stNum];
			
			var total = parseFloat(totalCell.innerHTML) + amount*parseFloat(prices[stNum]);
			totalCell.innerHTML = total.toFixed(2);
			
			basketTableMinimized.rows[basketTableMinimized.rows.length-1].getElementsByTagName('td')[1+stNum].innerHTML = total.toFixed(2);
		}
	}

	//find if added product already exists in the selectedTable
	var productFromSelectedList;
	for(index = 0; index < basketRows.length; index++)
	{
		productFromSelectedList = clearString(basketRows[index].getElementsByTagName('td')[0].innerHTML);

		if (productName == productFromSelectedList)
		{
			var cells = basketRows[index].getElementsByTagName('td');
			var totalAmount = parseInt(cells[cells.length-2].innerHTML);
			//product already exists in the basket, just increase the amount
			totalAmount += amount;
			cells[cells.length-2].innerHTML = totalAmount;
			document.getElementById("amount_"+rowID).value = totalAmount;
			found = true;
			break;
		}
	}

	if(basketRows.length>30)
	{
		var divBasket = document.getElementById("floatingBasket");
		divBasket.style.height = 530;
		divBasket.style.overflow = 'auto';
	}

	if(!found)
	{
		//create new product row, insert it at the bottom of table (but above last table line with TOTAL amount)
		var basketTable = document.getElementById("BasketTableID");
		var row = basketTable.insertRow(basketTable.rows.length-1);
		row.id = 'basketRow_'+rowID;
		
		//add Product cell to the list selectedTable
		row.appendChild(createBasketCell(productName, 'productBasketCellText'));
		var cheapest = 100000000000;
		var cheapestStore = 'Svugde isto';
		for(var stNum = 0; stNum<prices.length; stNum++) 
		{
			if((cheapest > prices[stNum])&&(!prices[stNum].match("nema")))
			{
				cheapest = prices[stNum];
				cheapestStore = basketRows[0].getElementsByTagName('td')[1+stNum].innerHTML;
			}
			//add Price cell to the selectedTable
			row.appendChild(createBasketCell(prices[stNum], 'productBasketCellNumber'));
		}
		if(prices.length>1) 
		{
			//add Cheapest cell to the selectedTable
			row.appendChild(createBasketCell(cheapestStore, 'productBasketCellText'));
		}
		//add Amount cell to the selectedTable
		row.appendChild(createBasketCell(amount, 'productBasketCellText'));
				
		//add "remove" link
		var td = createBasketCell(" - ", 'productBasketCellText')
		td.className  = 'noprint';
		td.style.cursor = 'pointer';
		td.onclick = function(){removeFromBasketMulti(rowID,prices.length)};
		row.appendChild(td);
		
		//update amount in table line
		document.getElementById("amount_"+rowID).value = amount;
		document.getElementById("amount_"+rowID).style.backgroundColor="#FFFF44";
		
		var numProducts = basketTable.rows.length-2;
		if(numProducts == 1) {
			basketTableMinimized.rows[0].getElementsByTagName('td')[0].innerHTML = 'U korpi ima ' + 1 + ' proizvod';
		} else {
			basketTableMinimized.rows[0].getElementsByTagName('td')[0].innerHTML = 'U korpi ima ' + numProducts + ' proizvoda';
		}
	}
}

function feedBasket(rowID, amount, numStores)
{
	//get product price and name
	var prices = new Array();
	var productCellID = "productCell_" + rowID;
	var productName = clearString(document.getElementById(productCellID).innerHTML);
	for(var stNum = 0; stNum<numStores; stNum++) {
		var priceCellID = "priceCell_" + stNum + "_" + rowID;
		prices[stNum] = document.getElementById(priceCellID).innerHTML;
	}

	feedBasketWithAllData(productName, prices, amount, rowID);
}

//Adds product to the basket table
function addToBasketMulti(pthis, numStores)
{
	//alert(numStores);
	var basketTableMinimized = document.getElementById("BasketTableMinimizedID");
	var basketTableBody = document.getElementById("BasketTableBodyID");
	var basketRows = basketTableBody.getElementsByTagName('tr');
	var rowID = pthis.id;
	var amount = parseInt(document.getElementById("kolicina_"+rowID).value);
	
	feedBasket(rowID, amount, numStores);
}