{include file=$header_start}
<script language="JavaScript" type="text/javascript" src="{$siteroot}/js/validation/registration.js"></script>
{include file=$header_end}
  <!-- Maincontent starts -->
  <section id="maincont" class="ovfl-hidden">
    <section class="grybg">
      <div class="pagehead">
        <div class="grpcol">

		<h1 class="sing_up headingmain">Sign Up</h1>
                {if $msg_succ}<p><div class="successMsg" align="center">{$msg_succ}</div></p>{/if}
                {if $msg}<p><div class="errorMsg" align="center">{$msg}</div></p>{/if}
        </div>
      </div>
      <div class="innerdesc">
		<ul class="form_div">
			<li class="margin_bottom">
				<label>&nbsp;</label>

				<div class="fl btnmain" style="margin-right:10px">
					<input type="button" value="Buyer Registration" onclick="javascript:window.location='{$siteroot}/buyer_registration'" class="buybtn2">
				</div>

				<div class="fl btnmain">
					<input type="button" onclick="javascript:window.location='{$siteroot}/seller_registration'" value="Seller Registration" class="buybtn2">
				</div>
               <!-- <div class="fl"><a href="#"  class="ancherbtn"><span>DJ</span></a></div>-->

			</li>	
		</ul>
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
{include file=$footer}