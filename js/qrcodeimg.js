//QR Code Image functions using AJAX.

var qrcount = 0;
var qrcount_Daily = 0;
var xmlHttp

function GetXmlHttpObject(){
	var xmlHttp=null;
	try{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e){
		// Internet Explorer
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e){
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}


function getQrCodeImg(qr_code_link,deal_id){
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null){
		alert ("Your browser does not support AJAX!");
	}
	var url = SITEROOT+"/includes/phpqrcode/index_back.php?url="+qr_code_link+"&id="+deal_id;
	//xmlHttp.onreadystatechange=state_value;
	xmlHttp.onreadystatechange = function(){
								if (xmlHttp.readyState==4 && xmlHttp.status==200){
									document.getElementById("qrImg_"+deal_id).src = SITEROOT+"/includes/phpqrcode/temp/test"+deal_id+".png";
								}
							}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}


//End