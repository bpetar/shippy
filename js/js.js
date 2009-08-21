
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

//Remove from basket
function removeFromBasket(pthis)
{
	test1(pthis);
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

//Adds Row to the Table of Selected Products
function addToBasket(pthis)
{
	var basketTableBody = document.getElementById("BasketTableBodyID");
	var found = false;
	var rowID = pthis.id;
	
	var productCellID = "productCell_" + rowID;
	var priceCellID = "priceCell_" + rowID;
	var productName = clearString(document.getElementById(productCellID).innerHTML);
	var price = document.getElementById(priceCellID).innerHTML;

	//find if added product already exists in the selectedTable
	var productFromSelectedList;
	var basketRows = basketTableBody.getElementsByTagName('tr');
	
	var totalCell = basketRows[basketRows.length-1].getElementsByTagName('td')[1];
	var total = parseFloat(totalCell.innerHTML) + parseFloat(price);
	totalCell.innerHTML = total.toFixed(2);

	for(index = 0; index < basketRows.length; index++)
	{
		productFromSelectedList = clearString(basketRows[index].getElementsByTagName('td')[0].innerHTML);

		if (productName == productFromSelectedList)
		{
			var amount = parseInt(basketRows[index].getElementsByTagName('td')[2].innerHTML);
			//just increase the amount
			amount++;
			basketRows[index].getElementsByTagName('td')[2].innerHTML = amount;
			found = true;
			break;
		}
	}
	
	if(!found)
	{
		var basketTable = document.getElementById("BasketTableID");
		var row = basketTable.insertRow(basketTable.rows.length-1);
		row.id = "selected_" + rowID;//it has same number as id of row from products table it will be used in remove functionality
		var amount = 1;
		
		//add Product cell to the list selectedTable
		row.appendChild(createBasketCell(productName, '12px', '#EEEEEE'));
		//add Price cell to the selectedTable
		row.appendChild(createBasketCell(price, '12px', '#EE8888'));
		//add Amount cell to the selectedTable
		row.appendChild(createBasketCell(amount, '12px', '#EEEEEE'));
		
		//add store name with minimum price
		//td = document.createElement("td");
		//cellText = document.createTextNode(minimumPriceStoreName);
		//td.appendChild(cellText);
		//row.appendChild(td);
		
		//add "remove" link
		var td = createBasketCell(" - ", '12px', '#888888')
		td.id = "btnRemove_" + rowID;//contains id of row from products table it will be used in remove functionality
		td.style.cursor = 'pointer';
		td.onclick = function(){removeFromBasket(this)};
		row.appendChild(td);
	}

}