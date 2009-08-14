<script language="JavaScript" type="text/javascript">
function editPriceSubmit(formElement, productID, storeID)
{
	sndReq("submit.php", productID, storeID, formElement.price.value);
	return false;
}

function createRequestObject() {
    var ro;
    if (window.XMLHttpRequest) 
	{
		ro = new XMLHttpRequest();
	} 
	else if (window.ActiveXObject) 
	{
		ro = new ActiveXObject("Microsoft.XMLHTTP");
	}
    return ro;
}

var http = createRequestObject();

function sndReq(url, productid, storeid, price) {
    http.open('POST', url+'?username=<?=$user->name?>&password=<?=$user->password?>&productid='+productid+'&storeid='+storeid+'&price='+price);
    http.onreadystatechange = handleResponse;
    http.send(null);
}

function sndReqNoResp(url, action, tag, post) {
    http.open('POST', url+'?action='+action+'&tag='+tag+'&post='+post);
    http.send(null);
}

function handleResponse() {
    if(http.readyState == 4){
        var response = http.responseText;
        var update = new Array();
        //alert(response);
        var info = new Array();
		info[0] = response;
		displayInfoDiv("FADEIN-FADEOUT", info);

        if(response.indexOf('|' != -1)) {
            update = response.split('|');
            
            //document.getElementById("tags-" + update[0]).innerHTML = update[1];
        }
    }
}
	</script>
<?	if($error){?>
	<div class="pgsitem">
		<div class="pgsleft">GREŠKA:</div>
		<div class="pgsright">Došlo je do greške, proverite unesene podatke!!!<br><?=$message?></div>
	</div>
<?	}
	if($act=="insert"){?>
		<div class="pgsitem">
			<div class="pgsleft">
				Odaberite neku prodavnicu<br><br>
			</div>
		</div>
	<?	} else {

		$currentType = "empty";
		foreach($prices as $item){
/*				$selected = "";
			if($item['id'] == $store->city){
				$selected = "selected";
			}*/
			if ($currentType != $item['tname'])
			{
				$currentType = $item['tname'];
				echo("<div class=\"pgsitem\"><div class=\"pgsleft\">".$currentType."</div></div>");
			}
			?>
			<div class="pgsitem">
				<div class="pgsleftprc"><img src="../img/i.gif" title="<?=$expl["name"]?>" alt="" style="vertical-align:middle;" />
				&nbsp;&nbsp;<?=$item['pname']?>:</div>
				<div class="pgsrightprc">
					<form name="unosforma" id="unosforma" onsubmit="javascript:return editPriceSubmit(this, <?=$item['id']?>, <?=$id?>)" action="index.php?act=<?=$act?>&id=<?=$id?>" method="post">
						<input type="text" name="price" id="price" value="<?=$item['price']?>" class="prcinput" maxlength="35" />
					</form>
				</div>
			</div>
		<?
		}
 } ?>
 <div id="floatlayer" style="position:absolute;top:50;left:100;opacity:.0;background:#d0d0ff;border:solid black 1px;padding:5px"></div>