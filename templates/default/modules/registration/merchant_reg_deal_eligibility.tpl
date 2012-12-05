{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/lightbox.js"></script>
<link href="{$siteroot}/templates/default/css/lightbox.css" rel="stylesheet" type="text/css" />
{/strip}
{literal}
	<script type="text/javascript" language="JavaScript">
	function check(){

		var len = $("input[@id='chk_agree']:checked").length;
		if(len<=0){
			$("#chkterms").html("Please accept terms and conditions");
			return false;
		}else{
			$("#chkterms").html("");
			window.location=SITEROOT+"/registration/skip/merchant_reg_deal_eligibility";
		}
	}
	</script>
{/literal}
{include file=$header_end}
  <!-- Maincontent starts -->

<div id="wrapper">

  <!-- Maincontent starts -->

  <div id="maincont" class="ovfl-hidden">

    <div class="creat-deal">

      <h1>Local Business Registration</h1>

      

      <div class="profile-thumb1">

      <div class="profile-thumb1-lft fl">

      <h1>Step 1</h1>

      <p>Profile Info</p>

      </div>

      <div class="profile-thumb1-lft fl">

      <h1>Step 2</h1>

      <p>Business Info</p>

      </div>

       <div class="profile-thumb1-lft fl tabs">

        <h1 style=" color: #FFFFFF;font-size: 18px;margin: 5px 0;">Step 3</h1>

      <p style=" font: 13px Arial,Helvetica,sans-serif;text-align: center;color:#fff">Deal Eligibility</p>

      </div>

      <div class="clr"></div>

      </div>


<form method="POST" name="frm_deal" id="frm_deal"> 

      <div class="registration-form1">
	{if $msg neq ''}<div class="error" style="margin-left:113px;">{$msg}</div><br>{/if}
      <div class="step-3-wrap">

       <p class="design3-txt">.Yes, I would like to design and offer
my own deals and receive incoming deals.</p>

          

          <div class="pre-btn fl" style=" margin:20px 0 0 50px">

<input style="color: #FFFFFF;font: bold 15px/33px Arial,Helvetica,sans-serif;" class="previe-btn" type="button" name="apply" id="apply" value="Apply for Deal Eligibility" onclick="javascript:tb_show('Apply for Deal Eligibility', '{$siteroot}/modules/merchant-account/merchant_deal_request.php?sp=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=330&width=517&modal=false', tb_pathToImage);"  value="Apply for Deal Eligibility ">

        
      </div>

          <div class="clr"></div>

          

          <ul class="reset icn-link" style="padding:0px; margin:20px 0 10px 50px">

        <li><a href="javascript:void(0)" class="icn-link01 ">What's it?</a>

        <div class="tooltip">

        <span class="arrow">&nbsp;</span>

        <div class="top01"><div></div></div>

       <div class="mid" style="padding-bottom:5px">Tell people what you do best.</div>

       <div class="bot01"><div></div></div>

        </div>

        </li>

        

        </ul>

        

<input type="checkbox" name="chk_agree" id="chk_agree" value="yes" class="fl">


        <p class="fl ters-txt">I have read and Agree to Term & Conditions</p>

        <div class="clr"></div>

        <div class="pre-btn fl" style=" margin:20px 0 0 78px">

		<input class="previe-btn" type="submit" name="Submit" id="Submit" value="Save and Continue">

      </div>

       <div class="clr"></div>

          </div>

        

       

      </div>

</form>
    </div>

    <!-- Maincontent ends -->
    <!-- Maincontent ends -->

  </div>

</div>

{include file=$footer}
</body>

</html>
