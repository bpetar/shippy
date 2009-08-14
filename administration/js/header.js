function changeLocale(id){
	tmp_url = document.URL;
	if(tmp_url.indexOf('?') == -1){
		window.location.href = tmp_url + '?locale=' + id;
	}else if(tmp_url.indexOf('locale=') == -1){
		window.location.href = tmp_url + '&locale=' + id;
	}else{
		window.location.href = tmp_url.replace(/locale=\d/, "locale=" + id);
	}
}
function delClick(){
	return window.confirm("Da li zelite da obrisete stranicu?");
}