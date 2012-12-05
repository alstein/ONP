{include file=$header_start}
{literal}
<script language="JavaScript" type="text/javascript">
function appr(val1,username)
{  
	
	var f_id1=val1;
	document.forms["profile"].fid1.value = f_id1;
	document.forms["profile"].act.value = "Insert";
	
	if(confirm("Would you like add "+username+" as fan?"))
	{
		document.forms["profile"].submit();
	}
}
</script>
{/literal}
<body class="inner_body">
    {include file=$profile_header2}
<!-- main continer of the page -->
<div id="wrapper">
  <!-- header container starts here-->

  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <!-- Left content Start here -->
   {include file=$profile_left}
    <!-- Middel content Start here -->
    <div class="profile-middel">
      <div class="profile-top" style="padding-top:0">
        <h1 class="pro-username"><a href="javascript:void(0)">{if $page eq '1'} Search Merchant {else} Search Friends {/if}</h1></a></h1>
	<form name="profile" id="profile" method="POST">
		<input type="hidden" name="act" value="" id="act">
		<input type="hidden" name="fid" id="fid" value="">
		<input type="hidden" name="fid1" value="">
		<ul class="reset srfr-list"  style="height:630px;">
		{section name=i loop=$searches }
		<li><a style="float:left;margin-top:1px;" href="{$siteroot}/merchant-account/{$searches[i].userid}/merchant_profile"><img src="{$siteroot}/uploads/user/{if $searches[i].photo neq ''}{$searches[i].photo}{else}profile_pic.png{/if}" title="" alt="" width="60" height="60" /></a>
		<div class="fl frname"><a style="float:left;margin-top:1px;" href="{$siteroot}/merchant-account/{$searches[i].userid}/merchant_profile">{$searches[i].first_name} {$searches[i].last_name}</a>
		<span>{$searches[i].city}<br>
		</span>
		</div>
		
		{if $searches[i].count gt 0}
		<a  href="javascript:void(0);">Fan</a>
		{else}

		<a href="javascript:void(0)" onclick="appr({$searches[i].userid},'{$searches[i].first_name|ucfirst}');">Become a Fan</a>
		{/if}
		</li>
		{sectionelse}
		<div class="error" align="center">No Records Found.</div>
		{/section}		<a href="javascript:void(0)" onclick="appr({$searches[i].userid},{$searches[i].username|ucfirst});">Add As Fan</a>

		
		</ul>
		<input class="signinput" name="name" type="hidden" id="name" value="{$smarty.post.name}" 
			size="25" class="textbox fl"/>
		<input class="signinput" name="maincategory" type="hidden" id="maincategory" value="{$smarty.post.maincategory}" 
			size="25" class="textbox fl"/>
		<input class="signinput" name="cityid" type="hidden" id="cityid" value="{$smarty.post.cityid}" 
			size="25" class="textbox fl"/>
	</form>
      </div>
      
    </div>
    <!-- Right content Start here -->
        {include file=$profile_right}
    <!-- footer container Start-->
     {include file=$footer}
    <!-- footer container End-->
  </div>
</div>
</body>
</html>
