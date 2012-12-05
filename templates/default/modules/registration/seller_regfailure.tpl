{include file=$header_start}
{include file=$header_end}
  <!-- Maincontent starts -->
  <section id="maincont" class="ovfl-hidden">
    <section class="grybg">
      <div class="pagehead">
        <div class="grpcol">

		<h1 class="sing_up headingmain">Seller Sign Up Failed</h1>
                {if $msg_succ}<p><div class="successMsg" align="center">{$msg_succ}</div></p>{/if}
                {if $msg}<p><div class="errorMsg" align="center">{$msg}</div></p>{/if}
        </div>
      </div>
      <div class="innerdesc">
		Your registartion process is failed, please try again with registartion <a href="{$siteroot}/seller_registration">click here</a>!
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