{include file=$header_start}
{literal}
<script language="JavaScript" type="text/javascript">
function appr(val1)
{  
	
	var f_id1=val1;
	document.forms["profile"].fid1.value = f_id1;
	document.forms["profile"].act.value = "Insert";
	document.forms["profile"].submit();
	
// 	if(confirm("Would you like to approve this request?"))
// 	{
// 		document.forms["profile"].submit();
// 	}
}
function redirect_to_parent(val,usertype)
{
	if(usertype=='user')
	{
	var url=SITEROOT+"/my-account/"+val+"/my_profile";
	}
	else if(usertype=='merchant')
	{
	var url=SITEROOT+"/merchant-account/"+val+"/merchant_profile";
	}
	window.parent.location=url;
	window.close();
}
</script>
{/literal}
  <!-- header container starts here-->

  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <!-- Left content Start here -->
  
    <!-- Middel content Start here -->
    <div class="profile-middel">
      <div class="profile-top" style="padding-top:0">
        <h1 class="pro-username"><a  style="font: bold 12px Arial,Helvetica,sans-serif;" href="#">Users who cheered this</a></h1>
	<form name="profile" id="profile" method="POST">
		<input type="hidden" name="act" value="" id="act">
		<input type="hidden" name="fid" id="fid" value="">
		<input type="hidden" name="fid1" value="">
		<ul class="reset srfr-list"  style="height:630px;">
		{section name=i  loop=$friend1}
		<li>
		<img src="{$siteroot}/uploads/user/{$friend1[i].photo}" title="" alt="" width="60" height="60"  />
		
		<div class="fl frname" style="width: 100px;">
		<a href="javascript:void(0);" onclick="redirect_to_parent({if $friend1[i].userid neq $smarty.get.id1}{$friend1[i].userid}{else}{$friend1[i].friendid}{/if},'{$friend1[i].usertype}')">{$friend1[i].first_name} {$friend1[i].last_name}</a>
<!-- {$searches[i].first_name} {$searches[i].last_name} -->
		
		</div>
		
		</li>
		{sectionelse}
		<div class="error" align="center">No Records Found.</div>
		{/section}
		 <!--<li class="padding">-->

					
			<!--</li>-->
		</ul>
	</form>
<div align="center">{$pgnation}</div>
      </div>

    </div>
  
  </div>
</div>
</body>
</html>
