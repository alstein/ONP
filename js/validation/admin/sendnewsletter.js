function selectpagecontent()
	{
		
		var nlid = document.getElementById("newsletter").value;
		window.location = "send_message.php?news="+nlid;
	}

function openpopup(phpfile)
{  
	
		var url_val=phpfile;

		window.open("add_to_user.php",null,' height=500 , width=500 , left=100,  top=100,resizable=yes,scrollbars=yes,toolbar=no,status=yes');
	   
} 

function openpopup1(phpfile,id)
{	
		var url_val=phpfile;
// 		var url1 = 'add_to_sub.php?city='+id;
		var url1 = 'add_to_sub.php';
      	window.open(url1,null,' height=500 , width=500 , left=100,  top=100,resizable=yes,scrollbars=yes,toolbar=no,status=yes');
}

function show()
{

	if(document.getElementById('all').checked == true || document.getElementById('allbuyer').checked == true)
	{
	document.getElementById('sub').style.display = "none";
	document.getElementById('to1').style.display = "none";
	//document.getElementById('to1').style.display = "none";
	}else
	{
	document.getElementById('sub').style.display = "block";
	document.getElementById('to1').style.display = "block";
	//document.getElementById('to1').style.display = "block";
	}
   
//    if(document.getElementById('allbuyer').checked == true)
//    {
//    document.getElementById('sub').style.display = "none";
//    document.getElementById('to').style.display = "none";
//    document.getElementById('to1').style.display = "none";
//    }else
//    {
//    document.getElementById('sub').style.display = "block";
//    document.getElementById('to').style.display = "block";
//    document.getElementById('to1').style.display = "block";
//    }
}
window.onerror = null;
 var bName = navigator.appName;
 var bVer = parseInt(navigator.appVersion);
 var NS4 = (bName == "Netscape" && bVer >= 4);
 var IE4 = (bName == "Microsoft Internet Explorer" 
 && bVer >= 4);
 var NS3 = (bName == "Netscape" && bVer < 4);
 var IE3 = (bName == "Microsoft Internet Explorer" 
 && bVer < 4);
 var blink_speed=500;
 var i=0;
 
if (NS4 || IE4) {
 if (navigator.appName == "Netscape") {
 layerStyleRef="layer.";
 layerRef="document.layers";
 styleSwitch="";
 }else{
 layerStyleRef="layer.style.";
 layerRef="document.all";
 styleSwitch=".style";
 }
}
	function getCity(val)
	{
		ajax.sendrequest("GET", SITEROOT+"/admin/sitemodules/deal/get_city.php", {val:val}, '', 'replace');
	}
