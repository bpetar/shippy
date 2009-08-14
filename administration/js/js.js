var convertURL = 0;
function delClick(){
	return window.confirm("Da li zelite da obrisete stranicu?");
}
function checkStr(str){
	rez = str.search(/[^a-z0-9_-]/);
	return rez;
}


/*
check specified form fields
fieldIds are array od field ids separated with #
fieldIds are array od field names separated with #
checkTypes is array of field types separated with #: s for notempty string, n for number, e for email
*/
function checkForm(form, fieldIds, fieldNames, checkTypes){
	var numRE = /^\d+$/;
	var emailRE = /^.+\@.+\..+$/;
	var names = fieldNames.split(",");
	var fields = fieldIds.split(",");
	var values = checkTypes.split(",");

	for (i=0;i<names.length;i++){
		if (values[i] == 'n'){
			if (!form[fields[i]].value.match(numRE)){
				alert ("polje " + names[i] + " mora biti broj veci ili jednak nuli");
				form[fields[i]].focus();
				return false;
			}
		} else if (values[i] == 'e'){
			if (!form[fields[i]].value.match(emailRE)){
				alert ("polje " + names[i] + " mora biti ispravan email adresa");
				form[fields[i]].focus();
				return false;
			}
		} else {
			if (form[fields[i]].value == ''){
				alert ("polje " + names[i] + " mora biti popunjeno");
				form[fields[i]].focus();
				return false;
			}
		}
	}

	return true;
}
function insertFile(field_name, preview, lib_dir){
		t_win = window;
		url = document.getElementById(field_name).value;
		window.open('/cms/lib/up.php?lib=' + lib_dir + '&preview=' + preview + '&field_name='+field_name+'&url='+url, 'updlg', 'width=500,height=320,menubar=0,toolbar=0,resizable=0,scrollbars=0,status=1');
	}
function getDlgWin(){
	return t_win;
}
function setPreviewImg(img_src, elId){
	if(document.getElementById(elId)){
		document.getElementById(elId).src = img_src;
		document.getElementById(elId).style.display = 'block';
	}
}

var t_win = null;
function fileBrowserCallBack(field_name, url, type, win){
	if(type == 'image'){
		t_lib = 'img';
	}else if(type == 'file'){
		t_lib = 'pdf';
	}else{
		t_lib = lib;
	}
	t_win = win;
	temp_win = window.open(www_root + '/cms/lib/up.php?lib=' + t_lib + '&field_name='+field_name+'&url='+url, 'updlg', 'width=500,height=320,menubar=0,toolbar=0,resizable=0,scrollbars=0,status=1');
}
function clickSubmit(tmplt_page, form_id, params){
	obj = document.getElementById(form_id);
	obj.target = '';
	obj.action = tmplt_page + params;
}
function showPopupPreview(page_name, id, locale){
	t_popup_x = document.getElementById('dim_x').value;
	t_popup_y = document.getElementById('dim_y').value;
	tinyMCE.triggerSave();
	t_win = window.open(page_name + '?id=' + id + '&locale=' + locale, 'preview_window', 'width=' + t_popup_x + ',height=' + t_popup_y + ',menubar=0,toolbar=0,scrollbars=yes,resizable=yes,scrollbars=no,status=no');
}

function displayInfoDiv(displayMode, infoLines)
{
	var floatDiv = document.getElementById("floatlayer");
	
	var rising = true;
	var wopacity = 0;
	var longerPause = 3;

	if(displayMode == "FADEOUT")
	{
		rising = false;
		wopacity = 1;
	}
	else
	{
		floatDiv.style.top = document.body.scrollTop + document.body.clientHeight - 15 - 22*infoLines.length;
		floatDiv.style.left = document.body.scrollLeft + 10;
		
		//clean old div content
		while(floatDiv.lastChild)
		{
			floatDiv.removeChild(floatDiv.lastChild);
		}
		
		//add new div info text
		for(var i=0; i< infoLines.length; i++)
		{
			if(i!=0)
			{
				floatDiv.appendChild(document.createElement("br"));
			}
			floatDiv.appendChild(document.createTextNode(infoLines[i]));
		}
		
		floatDiv.style.display = '';
	}

	function f() //Internal function
	{
		if(rising)
		{
			wopacity +=.2;
			if(wopacity > 1)
			{
				wopacity = 1;
				rising = false;
				longerPause = 20;
				if(displayMode == "FADEIN")
				{
					return;
				}
			}
		}
		else
		{
			longerPause = 1;
			wopacity -= .2;
			if(wopacity < 0)
			{
				wopacity = 0;
				floatDiv.style.display = 'none';
				return;
			}
		}
		floatDiv.style.opacity = wopacity;
		setTimeout(f, 30*longerPause);
	}
	
	f();
}