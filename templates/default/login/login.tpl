{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/validation/signup1.js"></script>

{/strip}
{include file=$header_end}
  <!-- main container with changing content -->
  <div id="maincont">
    <div class="uppermain">
    <div class="banrleft fl">
    <p class="banrtxtbx">Gives you ownership of your social buying deals and helps you in sharing experiences with friends. <a href="#">Learn More</a></p>
    <div class="mainbanr">
    <ul class="banrmenu reset">
    <li>
    <label class="busines"></label>
    <div class="banrmenutxt fl">
    <h1>Businesses:</h1>
    <p>Make deals on your own terms</p>
    </div>
    </li>
    <li>
    <label class="consumer southspace-2"></label>
    <div class="banrmenutxt fl">
    <h1>Consumers: </h1>
    <p>Offer deals to your favorite local businesses</p>
    </div>
    </li>
    <li>
    <label class="community"></label>
    <div class="banrmenutxt fl">
    <h1>Community: </h1>
    <p>Share deals,views and experiences with friends</p>
    </div>
    </li>
    </ul>
    </div>
    </div>

<form name="frm" id="frm" method="POST" action="">
    <div class="signin_rigt fr rel">
   <!-- <div class="businesmanimg"></div>-->
    <!--<a href="#" class="loc_busines"><span>Local Business ? Click here!</span></a>-->
    <div class="signinbox ovfl-hidden">
 	<h1 class="signinhead">Sign In</h1>
    <div class="signinbox2">
    <ul class="sinninformbx reset">
    <li>
    <label>Email:</label>
    <div class="fl">
    <input class="textbox" type="text" onblur="if(this.value=='')this.value='Username'" onclick="if(this.value=='Username')this.value=''" value="Username" name="lemail" id="lemail" >
    </div>
    </li>
    <li>
    <label>Password:</label>
    <div class="fl">
    <input class="textbox" type="password" value="" name="lpassword" id="lpassword">
    </div>
    </li>
	 <li> <label>&nbsp;</label><div class="fl westspace-6 padnorth-1"><a href="javascript:void(0)" class="loc_busines fl"><span><input class="loc_busines fl" type="submit" name="submit_login" id="submit_login" value="Log In"></span></a></div></li>
      </ul>
    </div>
    </div>
    </div>
</form>
    </div>
    
  </div>
  {include file=$footer}



