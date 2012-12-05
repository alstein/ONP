{include file=$header_start}
{strip}
<link rel="stylesheet" href="{$siteroot}/lightbox/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="{$siteroot}/lightbox/lightbox.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validate/comment.js"></script>
	<!--<link rel="stylesheet" href="{$siteroot}/templates/{$templatedir}/css/admin/thickbox.css" type="text/css" media="screen" />-->

{/strip}
{literal}

<script type="text/javascript">
 $(document).ready(function(){
	pageload();
	
	
});

function pageload()
{
	var photoid = jQuery("#photoid").val();	
	var albumid = jQuery("#ablid").val();
	var page = jQuery("#pageid").val();
	var userid = jQuery("#userid").val();
	jQuery.post(SITEROOT+"/modules/photos/ajax_show.php",{page:page,photoid:photoid,albumid:albumid,userid:userid},
	function(data)
	{
		jQuery("#ajaxdiv").html(data);
	});
}
function validateDetail(uid,pid)
{
   var userid = uid;
   var itemid = pid;
   if(document.getElementById("reason").value=="")
   {
      document.getElementById("reason_error").innerHTML="<br/><div class='error'>Please select your reason for flagging this Photo as inappropriate.</div>";
      return false;
   }
   else
   {
     //return true;
      flaggedImage(userid,itemid,'reason');
   }
}
function showFlagBox(itemid)
{
      $("#flagPhoto_"+itemid).toggle(1500);
}
function refreshpage(albumid)
{
	var photoid = jQuery("#photoid").val();	
	jQuery.post(SITEROOT+"/modules/photos/ajax_show.php",{photoid:photoid,albumid:albumid},
	function(data)
	{
		jQuery("#ajaxdiv").html(data);
	});
        jQuery("#msg").html("Photo deleted successfully").fadeOut(5000).css('color', 'green');
}
</script>
{/literal}
<body class="inner_body">
<!-- main continer of the page -->
<div id="wrapper">
  <!-- header container starts here-->
   {include file=$profile_header2}
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont" >
    <!-- Left content Start here -->
     {if $smarty.session.csUserTypeId eq 3}{include file=$merchantprofile_left_panel}{elseif $smarty.session.csUserTypeId eq 2}  {include file=$myprofile_left_panel}{/if}
    <!-- Middel content Start here -->
    <div class="profile-middel" style="width: 551px;">
	<div  id="ajaxdiv" style="width:552px;"></div>
	 
	<input type="hidden" name="photoid" id="photoid" value="{$smarty.get.id2}">
	<input type="hidden" name="ablid" id="ablid" value="{$albumid}">
	<input type="hidden" name="pageid" id="pageid" value="{$smarty.get.id3}">
	<input type="hidden" name="userid" id="userid" value="{$siteUserId}">	
    </div>
    <!-- Right content Start here -->
      {if $smarty.session.csUserTypeId eq 3} {include file=$merchantprofile_right_panel}{elseif $smarty.session.csUserTypeId eq 2} {include file=$myprofile_right_panel}{/if}
    <!-- footer container Start-->
      {include file=$footer}
    <!-- footer container End-->
  </div>
</div>
</body>
</html>
