tinyMCE.init({
	relative_urls : "false",
	mode : "textareas",
	textarea_trigger : "rules",
	theme : "advanced",
	language : "sr",
	plugins : "table,paste",
	theme_advanced_buttons1_add : "fontsizeselect,separator,forecolor,backcolor",
	theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_disable : "formatselect,help,visualaid",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	content_css : "/css/tiny.css",
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	file_browser_callback : "fileBrowserCallBack",
	urlconverter_callback : "vobanCustomURLConverter"
});