
//test
function test(pthis)
{
	alert("evo me " + pthis.id);
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


//Adds Row to the Table of Selected Products
function addToBasket(pthis)
{
	//alert("evo me " + pthis.id);
	/*var text = pthis.id;
	var btnRow = text.split("tn"); //wht tn? because ID is in the form: btn1, btn2, etc. so split will make two strings: "b" and remaining number
	var btnID = btnRow[1]; //we take the number from id

	var cellName = "cell_" + btnID + "_";
	var productName = document.getElementById(cellName + "0").innerHTML;

	//find if added product already exists in the selectedTable
	var found = false;
	var productFromSelectedList;
	var selectedItemsRows = selectedItemListTableBody.getElementsByTagName('tr');
	for(index = 0; index < selectedItemsRows.length; index++)
	{
		productFromSelectedList = selectedItemsRows[index].getElementsByTagName('td')[0].innerHTML;
		if (productName == productFromSelectedList)
		{
			var amount = parseInt(selectedItemsRows[index].getElementsByTagName('td')[1].innerHTML);
			//just increase the amount
			amount++;
			selectedItemsRows[index].getElementsByTagName('td')[1].innerHTML = amount;
			found = true;
			break;
		}
	}
	
	if(!found)
	{
		var row = document.createElement("tr");
		row.id = "selected_" + btnID;//it has same number as id of row from products table it will be used in remove functionality
		var amount = 1;
		
		//find minimum price
		var minimumPriceStoreName = "nema";
		for (i = 1;i<=numStores;i++)//store count starts from 1
		{	
			var minimumCell = document.getElementById("cell_" + btnID + "_" + i);
			if (minimumCell.style.background == minimumCellStyle || minimumCell.style.background == minimumCellStyleLower
				|| minimumCell.style.textDecoration == minimumTextDecoration)
			{
				var id = i - 1;
				minimumPriceStoreName = document.getElementById("store_name_" + id).innerHTML;
				break;
			}
		}		

		//add Product cell to the list selectedTable
		var td = document.createElement("td");
		var cellText = document.createTextNode(productName);
		td.appendChild(cellText);
		//td.style.background = "rgb(105,205,210)";
		row.appendChild(td);

		//add Amount cell to the selectedTable
		td = document.createElement("td");
		cellText = document.createTextNode(amount);
		td.appendChild(cellText);
		row.appendChild(td);
		
		//add store name with minimum price
		td = document.createElement("td");
		cellText = document.createTextNode(minimumPriceStoreName);
		td.appendChild(cellText);
		row.appendChild(td);
		
		//add "remove" button
		td = document.createElement("td");
		var btnRemove = document.createElement("input");

		btnRemove.id ="btnRemove_" + btnID;//contains id of row from products table it will be used in remove functionality
		btnRemove.value = 'Ukloni 1';
		btnRemove.type = 'button';
		btnRemove.onclick = function(){removeFromBasket(this)};
		td.appendChild(btnRemove);
		row.appendChild(td);

		selectedItemListTableBody.appendChild(row);
	}
	
	for(i = 1; i<=numStores; i++)
	{
		var sum = 0;
		var value = document.getElementById(cellName + i).innerHTML;
		if (isNaN(value))
		{
			document.getElementById("storeInfo_" + storeIDs[i-1]).appendChild(document.createTextNode(productName + " nedostaje! "));
			//document.getElementById("storeInfo_" + storeIDs[i-1]).innerHTML += productName + " nedostaje! ";
		}
		else
		{
			var storeSumInput = document.getElementById("store_" + i);
			sum = parseInt(storeSumInput.value) + parseInt(value);
			storeSumInput.value = sum;
		}
	}*/
}