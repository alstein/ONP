{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/validation/profile_info_step2.js"></script>

{/strip}
{literal}
<script language="JavaScript" type="text/javascript" >

function show_div()
{

	var cat_checked = $("input[id=chk_category]:checked").length;
	if(cat_checked<2){
		$("#div_cat1").show();
		$("#div_cat").hide();
		return false;
	}else{
		return true;
	}


/*	if($('input[@name=right_now_deal]:checked').size() == 0 || $('input[@name=usual_deal]:checked').size() == 0){
		$("#div_deal").show();
		return false;
	}
	else{
		var cat_checked = $("input[id=chk_category]:checked").length;
		
		if(cat_checked==0){
			$("#div_cat").show();
			return false;
		}else{
			return true;
		}
	}*/

}
</script>
{/literal}
{include file=$header_end} 
  <!-- Header ends -->

  <!-- Maincontent starts -->

  <div id="maincont" class="ovfl-hidden">

    <div class="creat-deal">

       <h1>Just these few clicks !</h1>
<!--
      <div class="profile-thumb">

      <ul class="reset profile-thumb">

      <li class="active">

      <h1>Step-1</h1>

      <p>Profile Info</p>

      </li>

      

      <li>

      <h1>Step-2</h1>

      <p>Profile Picture</p>

      </li>

      <li>

      <h1>Step-3</h1>

      <p>Invite friends</p>

      </li>

      </ul>

    

      <div class="clr"></div>

      </div>
-->
<form name="frm" id="frm" method="POST" action="">
      <div class="registration-form-inn">

       

        <div class="form-inn">

        <!-- <h2><span>Step1 :</span>Page 2 of 2</h2>-->

          <p class="title">Besides My Favorite Local Businesses, I am interested in Following:</p>

          <p class="title-red">Categories Preference :</p>

          <ul class="reset deal-from">

            <li>

			{section name=i loop=$category}
              <div  style="margin-left:30px">

                <input class="styled" name="chk_category[]" id="chk_category" type="checkbox" value="{$category[i].id}">

                <p class="fl forminntxt">{$category[i].category}</p>

              </div>

           		{/section}
				<div>{$msg}</div>

              <div  style="margin-left:30px">

				 <input name="deal_thr_email" id="deal_thr_email" type="checkbox" value="yes" class="styled">
                <p class="fl forminntxt" style="color:#044EA2">"You would like to receive Offers through emails as well"? </p>

              </div>

              <div class="clr"></div>

            </li>

			<li>
				<div id="div_cat" class="error" style="display:none;padding-left:30px" >Please select atleast category which you want to prefer. </div>
				<div id="div_cat1" class="error" style="display:none;padding-left:30px" >Please select atleast Two categories which you want to prefer. </div>
			</li>
          </ul>

          

          <div class="clr"></div>

<div>By clicking Join Now, you are indicating that you have read, understood, and agree to our <a href="{$siteroot}/terms" style="color:#044EA2">Terms</a> and <a href="{$siteroot}/privacy-policy" style="color:#044EA2">Privacy Policy</a>.</div>
          <div class="pre-btn fr">

		<input class="previe-btn" type="submit" name="Submit" id="Submit" value="JOIN NOW" onclick="return show_div();">
        </div>

        <div class="clr"></div>

        </div>

        

      </div>

</form>
    </div>

    <!-- Maincontent ends -->

  </div>

</div>
</form>
{include file=$footer}

