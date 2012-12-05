{include file=$header_start}
{literal}
<script language="JavaScript" type="text/javascript">
function appr(val1)
{  
	
	var f_id1=val1;
	document.forms["profile"].fid1.value = f_id1;
	document.forms["profile"].act.value = "Insert";
	document.forms["profile"].submit();
	
}
</script>
{/literal}
  <!-- header container starts here-->
  {include file=$profile_header2}
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <!-- Left content Start here -->
  	{if $smarty.session.csUserTypeId eq '2'}
		{include file=$profile_left}
	{else}
		{include file=$merchant_home_left}	 	
	{/if}
    <!-- Middel content Start here -->
    <div class="profile-middel">
      <div class="profile-top" style="padding-top:0">
        <h1 class="pro-username"><a  style="font: bold 12px Arial,Helvetica,sans-serif;" href="javascript:void(0)">cheered Users For</a><br></h1>

			<img src="{$siteroot}/uploads/album/photo/thumbnail/{$arow.photo}" title="" alt=""  /> <!--In {$arow.album_title}-->
	<form name="profile" id="profile" method="POST">
		<input type="hidden" name="act" value="" id="act">
		<input type="hidden" name="fid" id="fid" value="">
		<input type="hidden" name="fid1" value="">
		<ul class="reset srfr-list"  style="height:630px;">
		{section name=i  loop=$friend1}
		<li>
		{if $friend1[i].photo neq ''}
			<img src="{$siteroot}/uploads/user/{$friend1[i].photo}" title="" alt="" width="60" height="60"  />
		{else}
			<img src="{$siteroot}/templates/default/images/profile_pic.png" title="" alt="" width="60" height="60"  />
		{/if}
		
		<div class="fl frname" style="width: 100px;">
		<a href="{if $friend1[i].usertypeid eq '2'}{$siteroot}/my-account/{$friend1[i].userid}/my_profile/{else}{$siteroot}/merchant-account/{$friend1[i].userid}/merchant_profile/{/if}" target="_blank">{if $friend1[i].usertypeid eq '2'}{$friend1[i].fullname}{else}{$friend1[i].business_name}{/if}</a>
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
  	{if $smarty.session.csUserTypeId eq '2'}
		{include file=$profile_right}
	{else}
		{include file=$merchant_home_right}	 	
	{/if}


  </div>
   {include file=$footer}
</div>
</body>
</html>
