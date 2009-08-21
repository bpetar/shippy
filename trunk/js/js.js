
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

//Adds Row to the Table of Selected Products
function addToBasket(pthis)
{
	var basketTableBody = document.getElementById("BasketTableBodyID");
	var found = false;
	var rowID = pthis.id;
	
	var cellName = "productCell_" + rowID + "_";
	var productName = clearString(document.getElementById(cellName + "0").innerHTML);

	//find if added product already exists in the selectedTable
	var productFromSelectedList;
	var basketRows = basketTableBody.getElementsByTagName('tr');
	for(index = 0; index < basketRows.length; index++)
	{
		productFromSelectedList = clearString(basketRows[index].getElementsByTagName('td')[0].innerHTML);

		if (productName == productFromSelectedList)
		{
			var amount = parseInt(basketRows[index].getElementsByTagName('td')[1].innerHTML);
			//just increase the amount
			amount++;
			basketRows[index].getElementsByTagName('td')[1].innerHTML = amount;
			found = true;
			break;
		}
	}
	
	if(!found)
	{
		var row = document.createElement("tr");
		row.id = "selected_" + rowID;//it has same number as id of row from products table it will be used in remove functionality
		var amount = 1;
		
		//add Product cell to the list selectedTable
		var td = document.createElement("td");
		var cellText = document.createTextNode(productName);
		td.appendChild(cellText);
		td.style.color = '#EEEEEE';
		td.style.font.size = '6px';
		row.appendChild(td);

		//add Amount cell to the selectedTable
		td = document.createElement("td");
		cellText = document.createTextNode(amount);
		td.appendChild(cellText);
		row.appendChild(td);
		
		//add store name with minimum price
		//td = document.createElement("td");
		//cellText = document.createTextNode(minimumPriceStoreName);
		//td.appendChild(cellText);
		//row.appendChild(td);
		
		//add "remove" button
		td = document.createElement("td");
		var btnRemove = document.createElement("input");

		btnRemove.id ="btnRemove_" + rowID;//contains id of row from products table it will be used in remove functionality
		btnRemove.value = ' - ';
		btnRemove.type = 'button';
		btnRemove.onclick = function(){removeFromBasket(this)};
		td.appendChild(btnRemove);
		row.appendChild(td);

		basketTableBody.appendChild(row);
	}

}