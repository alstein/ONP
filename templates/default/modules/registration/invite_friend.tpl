{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/validation/signup1.js"></script>

{/strip}
{literal}

<script type="text/javascript">
function togglegmail()
{
var state=document.getElementById('showgmail').style.display;
if(state == 'block')
{
 document.getElementById('showgmail').style.display = 'none';
}
else
{
 document.getElementById('showgmail').style.display = 'block';
}
// 	$('#showgmail').toggle();
}

function toggleothers()
{
	$('#showothers').toggle();
}

</script>
{/literal}
<div id="wrapper">
  <!-- header container starts here-->
 {include file=$profile_header}
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <!-- / registration form start here -->
<form name="frm" id="frm" method="POST" action="" >

    <div class="form_bg">
	
      <div class="form_nav">
        <ul class="maketabs reset centerAll">
          <li class="item">
            <h3>Step 1<span>Profile Info</span></h3>
          </li>
          <li class="item">
            <h3>Step 2<span>Profile Picture</span></h3>
          </li>
          <li class="item active">
            <h3>Step 3<span>Invite friends</span></h3>
          </li>
        </ul>
      </div>
      <div class="form_cont">
        <h2 style="margin:0"><span>Quite a few of your friends might be here.</span></h2>
        <p class="title-text">Browsing through your email contacts is the best way to find your friends on</p>
        <ul class="reset browsing-through">
          <li>
            <div><img src="{$siteroot}/templates/default/images/gmail.png" width="93" height="41" alt="image" class="fl">
              <div class="fr"><a href="javascript:void(0)" onclick="togglegmail()">Find Friends</a></div>
<div id="showgmail"  {if $import eq 'Import Contacts'} style="display:block" {else} style="display:none"  {/if} >{$contents}</div>
		<div></div>
            </div>
          </li>
          <li>
            <div><img src="{$siteroot}/templates/default/images/yahoo.png" width="215" height="41" alt="image" class="fl">
              <div class="fr"><a href="javascript:void(0)">Find Friends</a></div>
		
            </div>
          </li>
          <li>
            <div><img src="{$siteroot}/templates/default/images/msn.png" width="112" height="41" alt="image" class="fl">
              <div class="fr"><a href="javascript:void(0)">Find Friends</a></div>
            </div>
          </li>
        </ul>
        <div class="fr" style="width:245px">
          <div class="fr" style="margin-left:10px; line-height:32px"><a href="modules/registration/invite_friend.php?id=1"><strong>Skip this step</strong></a></div>
          <div class="fr">
            <button class="sitesub-btn"><span class="sitesub-btn-lft"><span class="sitesub-btn-right"><input class="loc_busines fl" type="submit" name="Submit" id="Submit" value="Save and Continue"></span></span></button>
          </div>
	<input type="hidden" name="txt_hidden" id="txt_hidden" value="1" >
          <div class="clr"></div>
        </div>
         <div class="clr"></div>
      </div>
</form>
      <!-- / registration form end here -->
    </div>
    <!-- footer container Start-->
     {include file=$footer}
    <!-- footer container End-->
  </div>
</div>
