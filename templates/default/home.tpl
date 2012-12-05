{include file=$header_start} 
<script type="text/javascript" src="{$siteroot}/js/validation/validate_password1.js"></script>
{if $smarty.session.csUserId neq ''}
{include file=$profile_header2}
{else}

</head>
{strip}
<!--<script type="text/javascript" src="{$sitejs}/validation/login.js"></script>-->

{/strip}

<!--//js disabled-->
{if $smarty.session.is_valid_browser eq '0'}

 {include file = $browser_info}

 {php}//exit;{/php}
{/if} 

<!-- js disabled -->


<body style="background:none">
<!-- main continer of the page -->
<div class="fullwid" style="position:fixed; background:#DDE2E8; z-index:1; height:30px">
<div id="header">
<form name="form_index" id="form_index" method="POST">
<input type="hidden" name="txt_msg" id="txt_msg" value="{$login_error}">
    <div class="ovfl-hidden">
      
	  <div class="loginsect fr">

      </div>
    </div>

</form>
  </div>
</div>
<div>vdvdd</div>

<div id="wrapper01">
  <!-- header container starts here-->
  
  <!-- / header container ends here-->
{/if}
  <!-- / header container ends here-->
  <!-- main container with changing content -->
<form name="frm" id="frm" method="POST" action="">
<div style="height:15px"></div>
	
  <div id="maincont">
    <div class="uppermain">
    <h1 class="lan-logo">&nbsp;</h1>
	<h2 class="in-heading ovfl-hidden" style="text-align: center; padding:30px 100px; color:#2f527d;font-size:16px">
    OffersnPals is a revolutionary concept in Social Buying. We are open for Private Beta testing. Please enter your password to enter the site.</h2>
	<div style="height:20px;"></div>
	<div style="line-height: 20px;padding-left: 407px;" class="error">{if $msg neq ''}{$msg}{/if}</div>
	<div class="fullwid ovfl-hidden in-cont" style="text-align: center;">Password:&nbsp;&nbsp;<input type="password" name="pass" id="pass" style=" border: 1px solid #CCCCCC;padding: 4px;width: 350px;">
		<div class="error" htmlfor="pass" generated="true" style="padding-right: 166px;"></div>
	 </div><br />

<div class="fullwid ovfl-hidden in-cont" style="text-align: center; width:115px; margin:0 auto">
	    <span class="sitesub-btn-lft"><span class="sitesub-btn-right">
		<input class="loc_busines" type="Submit" value="Submit" name="Submit" />
		</span></span>
</div>

	</div>
  </div>
</form>
<div id="footerwrap" class="ovfl-hidden">
  <div id="footer" class="normTxt"> 
  <p class="fr">© 2012 Alstein Pvt Ltd. All Rights Reserved.</p>
  <div class="clr"></div>
  </div>
</div>
</div>


</body>
</html>
</div>
  <!-- Maincontent ends -->
