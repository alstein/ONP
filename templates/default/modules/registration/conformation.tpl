{include file=$header_start}
<script language="JavaScript" type="text/javascript" src="{$siteroot}/js/validation/registration.js"></script>
{include file=$header_end}
  <!-- Maincontent starts -->
<div style="height:30px;"></div>
  <section id="maincont" class="ovfl-hidden">
    <section class="grybg">
      <div class="pagehead">
        <div class="grpcol">

		<h1 class="sing_up headingmain">Account Verification</h1>
                {if $msg_succ}<p><div class="successMsg" align="center">{$msg_succ}</div></p>{/if}
                {if $msg}<p><div class="errorMsg" align="center">{$msg}</div></p>{/if}
        </div>
      </div>
      <div class="innerdesc">
		<ul class="form_div reset" style="padding:0px;">
			{if $msg_succ}
				<li>
					You have confirmed your Account You can login using below link<br><br>
				</li>
				<li >
					<div class="fl">
						<a href="{$siteroot}" class="fl">Click here to login</a><br><br>
					</div>
				</li>
			{/if}
		</ul>
      </div>
      <div class="clr">&#x00A0;</div>
    </section>
  </section>
  <!-- Maincontent ends -->
{include file=$footer}