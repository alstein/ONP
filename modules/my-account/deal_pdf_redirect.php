<?php
	include_once("../../include.php");
	
	$id = $_GET['id'];

	$payu = $dbObj->cgs("tbl_deal_payment_unique","","uniqueid",$id,"","","");
	$payunique = @mysql_fetch_assoc($payu);

	$res_deal4 = $dbObj->cgs("tbl_deal","*","deal_unique_id",$payunique['deal_id'],"","","");
	$dealData = @mysql_fetch_assoc($res_deal4);

//////// START Assigning all variables ///////////

	$qrCodeImagePath = SITEROOT."/includes/phpqrcode/index_back.php?url=".$dealData['qr_code_link']."&id=".$dealData['deal_unique_id'];

///////// END Assigning all variables ////////////

?>
<script language="JavaScript" type="text/javascript">
	//////////////////////////
	var xmlHttp
	var id = <?php echo $id; ?>;
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

	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null){
		alert ("Your browser does not support AJAX!");
	}
	var url = "<?php echo $qrCodeImagePath; ?>";
	xmlHttp.onreadystatechange=state_value;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

	function state_value()
	{
		if (xmlHttp.readyState==4)
		{
			location.replace('<?php echo SITEROOT; ?>'+'/modules/my-account/deal_pdf.php?id='+id);

			//document.getElementById("qrCode").innerHTML = "<img src='<?php //echo SITEROOT."/includes/phpqrcode/temp/test".$dealData['deal_unique_id'].".png"; ?>' width='64' height='64' >";
		}
	}

	///////////////////////////
</script>

<div>
	Wait Voucher pdf is loading....
</div>