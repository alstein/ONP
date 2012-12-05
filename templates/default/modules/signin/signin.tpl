{include file=$header_start}
<script language="JavaScript" type="text/javascript" src="{$siteroot}/js/validation/signin.js"></script>
{include file=$header_end}
  <!-- Maincontent starts -->
  <section id="maincont" class="ovfl-hidden">
    <section class="grybg">
      <div class="pagehead">
		<div class="grpcol">
	
		<h1 class="icons_login headingmain"><div style="float:left;" id="signinLbl">Buyer</div>&nbsp;Sign In</h1>
				{if $msg_succ}<p><div class="successMsg" align="center">{$msg_succ}</div></p>{/if}
				{if $msg}<p><div class="errorMsg" align="center">{$msg}</div></p>{/if} 
				{if $twittmsg}<p><div class="errorMsg" align="center">{$twittmsg}</div></p>{/if}       </div>
		</div>
	<div class="innerdesc">
		<div style="padding-bottom:30px; padding-left:50px;">
			<label style="width:150px;">Sign in as : </label>

			<input type="radio" id="type" name="type" value="buyer" onchange="javascript:changeFrm(this.value)" {if $type neq 'seller'} checked="true" {else} {if $toSetSection eq 'buyer'} checked="true" {/if} {/if}  style="float:left; margin-right:5px;"><label style="width:60px;">Buyer </label>
		
			<input type="radio" id="type" name="type" value="seller" onchange="javascript:changeFrm(this.value)" {if $type eq 'seller'} checked="true" {else} {if $toSetSection eq 'seller'} checked="true" {/if} {/if} style="float:left;margin-right:5px;"><label style="width:60px;">Seller </label>
		</div>
		<div style="clear:both;"></div>



		<form name="frmsignin" id="frmsignin" action="" method="POST" {if $type eq 'seller'} style="display:none;" {/if}>
			<ul class="form_div">
				<li><label>Email:</label>
					<div class="sel fl">
						<input type="text" id="email" name="email" class="sel_input" {if $smarty.cookies.login} value="{$smarty.cookies.login}" {/if}/>
					</div>
					<div class="clr"></div>
					<div class="error" htmlfor="email" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Password:</label>
					<div class="sel fl">
						<input type="password" id="pass" name="pass" class="sel_input"  {if $smarty.cookies.pass} value="{$smarty.cookies.pass}" {/if}/>
					</div>
					<div class="clr"></div>
					<div class="error" htmlfor="pass" generated="true" style="padding-left:152px;"></div>
				</li>
				<li>
					<label>&nbsp;</label>
					<div class="fl">
						<input name="rememberme" id="rememberme" type="checkbox" {if $smarty.cookies.remember eq 'yes'} checked="true" {/if} value="" style="width:auto; border:0px;">
						<a href="javascript:void(0);"> Remember Me</a> 
					</div>
				</li>
				<li>
					<label>&nbsp;</label>
					<div class="fl">
						<a href="{$siteroot}/forgotpassword"> Forgot Password?</a>
					</div>
				</li>
     			<li>
					<label>&nbsp;</label>
					<div class="fl btnmain">
						<input type="submit" name="login" id="login" class="buybtn2 fl" value="Login">
					</div>
				</li>
				<li>
					<label>&nbsp;</label>
					<div class="fl">
						<h1>Or login with your Facebook account</h1>
					</div>
				</li>
     			<li>
					<label>&nbsp;</label>
					<div class="fl">
						<div id="fb-root" style="float:left;"></div>
						{literal}
							<script language="javascript" type="text/javascript">
								FB.init({ 
								appId:'256976704344295',
								cookie:true,
								status:true,
								xfbml:true
								});
							</script>
						{/literal}
						<fb:login-button v="2" onlogin="offline_access_box();" scope="email" style="float:left;"><fb:intl>Login with Facebook</fb:intl></fb:login-button>

						<!--<a href="javascript:void(0);"><div class="fbook"></div></a>-->
					</div>
				</li>
				<li>
					<label>&nbsp;</label>
					<div class="fl">
						<h1>Or login with your Twitter account</h1>
					</div>
				</li>
				<li>
					<label>&nbsp;</label>
					<div class="fl">
						{if $smarty.session.emailverfiye eq 'twitter'}{else}{$twitter_connect}{/if}
					</div>
				</li>
			</ul>
		</form>



		<form name="frmsigninSeller" id="frmsigninSeller" action="" method="POST" {if $type neq 'seller'} style="display:none;" {/if}>
			<ul class="form_div">
				<li><label>Email:</label>
					<div class="sel fl">
						<input type="text" id="email" name="email" class="sel_input" {if $smarty.cookies.sellerlogin} value="{$smarty.cookies.sellerlogin}" {/if}/>
					</div>
					<div class="clr"></div>
					<div class="error" htmlfor="email" generated="true" style="padding-left:152px;"></div>
				</li>
				<li><label>Password:</label>
					<div class="sel fl">
						<input type="password" id="pass" name="pass" class="sel_input"  {if $smarty.cookies.sellerpass} value="{$smarty.cookies.sellerpass}" {/if}/>
					</div>
					<div class="clr"></div>
					<div class="error" htmlfor="pass" generated="true" style="padding-left:152px;"></div>
				</li>
				<li>
					<label>&nbsp;</label>
					<div class="fl">
						<input name="rememberme" id="rememberme" type="checkbox" {if $smarty.cookies.sellerremember eq 'yes'} checked="true" {/if} value="" style="width:auto; border:0px;">
						<a href="javascript:void(0);"> Remember Me</a>
					</div>
				</li>
				<li>
					<label>&nbsp;</label>
					<div class="fl">
						<a href="{$siteroot}/sellerforgotpassword"> Forgot Password?</a>
					</div>
				</li>
     			<li>
					<label>&nbsp;</label>
					<div class="fl btnmain">
						<input type="submit" name="seller_login" id="seller_login" class="buybtn2 fl" value="Login">
					</div>
				</li>	
			</ul>
		</form>



      </div>
      <div class="clr">&#x00A0;</div>
    </section>
    <section class="grybg">
      <div class="tphwrks">
	{include file=$footer_free_coupons}
      </div>
    </section>
  </section>
  <!-- Maincontent ends -->
{if $toSetSection}
{literal}
	<script language="javascript" type="text/javascript">
		changeFrm('{/literal}{$toSetSection}{literal}')
	</script>
{/literal}
{/if}
{include file=$footer}