<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta content="{$siteroot}" name="sitename" />
<meta content="{$metades}" name="description" />
<meta content="{$metakeyword}" name="keywords" />
<script type="text/javascript" src="{$sitejs}/remote.js"></script>
<script src="{$sitejs}/jquery-1.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="{$sitejs}/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="https://ssl.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
<script type="text/javascript" language="JavaScript" src="{$siteroot}/js/validation/signup.js"></script> 
<script type="text/javascript" language="JavaScript" src="{$siteroot}/js/validation/signin.js"></script> 
<script type="text/javascript" src="{$sitejs}/ajax.js"></script>
<!--<script type="text/javascript" src="{$sitejs}/jquery.js"></script>-->
<script type="text/javascript" src="{$sitejs}/jquery.countdown.js"></script>
<script type="text/javascript" src="{$siteroot}/js/dragpopup.js"></script>

<script type="text/javascript" src="{$siteroot}/js/text-tooltip.js"></script> 
<link rel="StyleSheet" href="{$siteroot}/templates/default/css/text-tooltip.css" type="text/css"/>

<link href="{$siteroot}/templates/{$templatedir}/css/dragpopup.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

{literal}
function getSelleroption(val){

      ajax.sendrequest("get", SITEROOT+"/modules/seller/get-seller-option.php", {val:val,seller:1}, '', 'replace');

   }

	function subscribe_email(){
		if(document.getElementById("sub_email").value == ""){
			document.getElementById("usersubsec").innerHTML="Please enter email address";
			return false;
		}
                if ( !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("sub_email").value)))
                {
			document.getElementById("usersubsec").innerHTML="Please enter valid email address";
			return false;
                }
		var sub_city=document.getElementById("sub_city").value;
		var sub_email=document.getElementById("sub_email").value;
		var sub_code =document.getElementById("sub_code").value;

		ajax.sendrequest("get", SITEROOT+"/subscribe.php", {sub_city:sub_city,sub_email:sub_email,sub_code:sub_code}, '', 'usersubsec');

   }

   
function news(){


 if ($("#newsletter").is(":hidden")) {
      $("#newsletter").slideDown("slow");
        $("#newsclick").addClass("active");
    } else {
      $("#newsletter").slideUp("slow");
        $("#newsclick").removeClass("active");
    }


$("#howitworks").hide();


}
function howit(){

 if ($("#howitworks").is(":hidden")) {
      $("#howitworks").slideDown("slow");
        $("#howclick").addClass("active");
    } else {
      $("#howitworks").slideUp("slow");
        $("#howclick").removeClass("active");
    }

$("#newsletter").hide(); 
}

function howItWorks(){
	document.getElementById("step1").style.display="block";
	document.getElementById("step2").style.display="none";
	document.getElementById("step3").style.display="none";
	document.getElementById("step4").style.display="none";
	
	

	$("#s1").addClass("active");
	$("#s2").removeClass("active");
	$("#s3").removeClass("active");
	$("#s4").removeClass("active");
}

function howItWorks1(){
	document.getElementById("step1").style.display="none";
	document.getElementById("step2").style.display="block";
	document.getElementById("step3").style.display="none";
	document.getElementById("step4").style.display="none";
	
	$("#s1").removeClass("active");
	$("#s2").addClass("active");
	$("#s3").removeClass("active");
	$("#s4").removeClass("active");
}

function howItWorks2(){
	document.getElementById("step1").style.display="none";
	document.getElementById("step2").style.display="none";
	document.getElementById("step3").style.display="block";
	document.getElementById("step4").style.display="none";
	
	$("#s1").removeClass("active");
	$("#s2").removeClass("active");
	$("#s3").addClass("active");
	$("#s4").removeClass("active");
}

function howItWorks3(){
	document.getElementById("step1").style.display="none";
	document.getElementById("step2").style.display="none";
	document.getElementById("step3").style.display="none";
	document.getElementById("step4").style.display="block";
	
	$("#s1").removeClass("active");
	$("#s2").removeClass("active");
	$("#s3").removeClass("active");
	$("#s4").addClass("active");
}

{/literal}

var SITEROOT = '{$siteroot}';
</script>
<!-- Website title -->
<title>{$sitetitle}</title>
<!--Attached css-->
{if $detype eq 'product' } 
<link href="{$sitecss}/product_orange.css" rel="stylesheet" type="text/css" />
{/if} 
{if $detype eq 'service' } 
<link href="{$sitecss}/service_blue.css" rel="stylesheet" type="text/css" />
{/if} 
{if $detype eq '' } 
<link href="{$sitecss}/main.css" rel="stylesheet" type="text/css" />
{/if} 
<!--Attached fevicon-->
<link rel="shortcut icon" type="image/x-icon" href="{$siteimg}/fav.ico" />


