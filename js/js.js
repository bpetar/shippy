
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

//colapse and expand categories
function CategoryRowClick(pthis)
{
	var rowid = parseInt(pthis.id) + 1;
	var row = document.getElementById(rowid);
	while (row.style.cursor != 'pointer')
	{
		if(row.style.display == 'none')	{
			row.style.display = '';
		} else {
			row.style.display = 'none';
		}
		row = document.getElementById(++rowid);
	}
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
	var total = parseFloat(totalCell.innerHTML) - parseFloat(price);
	totalCell.innerHTML = total.toFixed(2);
		
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
	
	//get product price and name
	var productCellID = "productCell_" + rowID;
	var priceCellID = "priceCell_" + rowID;
	var productName = clearString(document.getElementById(productCellID).innerHTML);
	var price = document.getElementById(priceCellID).innerHTML;

	//add price to total amout
	var totalCell = basketRows[basketRows.length-1].getElementsByTagName('td')[1];
	var total = parseFloat(totalCell.innerHTML) + parseFloat(price);
	totalCell.innerHTML = total.toFixed(2);

	//find if added product already exists in the selectedTable
	var productFromSelectedList;
	for(index = 0; index < basketRows.length; index++)
	{
		productFromSelectedList = clearString(basketRows[index].getElementsByTagName('td')[0].innerHTML);

		if (productName == productFromSelectedList)
		{
			var amount = parseInt(basketRows[index].getElementsByTagName('td')[2].innerHTML);
			//product already exists in the basket, just increase the amount
			amount++;
			basketRows[index].getElementsByTagName('td')[2].innerHTML = amount;
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
		var amount = 1;
		
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
	}

}