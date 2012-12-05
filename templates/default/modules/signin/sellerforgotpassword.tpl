{include file=$header_start}
{literal}
	<script language="JavaScript">
		$(document).ready(function(){

             $("#frmforgotpass").validate({
			errorElement:'div',
			rules: {
					email:{
						required: true,
						email: true,
						minlength: 4,
						maxlength: 50
					}
				},
			messages: {
					email:{
						required: "Please enter an email address.",
						email: "Please enter a valid email address.",
						minlength: jQuery.format("Enter at least {0} characters."),
						maxlength: jQuery.format("Enter at most {0} characters.")
					}
				}
			});
		});

	</script>
{/literal}

  <!-- Maincontent starts -->
<div id="wrapper">
  <!-- header container starts here-->
  {include file=$profile_header}
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <div class="marchant-form-main">
      <h1>Identify Your Account</h1>
      <!-- / registration form start here -->
      <div class="marchant-form_bg" style="padding:5px 5px">
        <div class="marchant-form_cont" style="margin:20px auto">
 		{if $msg_succ}<p><div class="successMsg" align="center">{$msg_succ}</div></p>{/if}
                {if $msg}<p><div class="errorMsg" align="center">{$msg}</div></p>{/if}
		<form name="frmforgotpass" id="frmforgotpass" action="" method="POST">
			<ul class="fl marchantstep-one-form reset">
				<li>
				<label>Enter your email</label>
				<div class="fl">
					<input type="text" id="email" name="email" class="form-textbox" />
				</div>
				</li>
				<li>
				<label>&nbsp;</label>
				<div class="fl"> <br/>
					<div class="fr">
					<span class="sitesub-btn-lft"><span class="sitesub-btn-right"><input type="submit" name="submit" id="submit" class="sitesub-btn" value="Submit"></span></span>
					</div>
				</div>
				</li>
			</ul>
		</form>
        </div>
        <div class="clr"></div>
      </div>
      <!-- / registration form end here -->
    </div>

  <!-- Maincontent ends -->
{include file=$footer}