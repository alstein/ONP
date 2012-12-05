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
  {include file=$header_end}
<div id="wrapper"><br><br><br>
  <!-- header container starts here-->

  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <div class="marchant-form-main">
      <center><h1>Please Identify Your Account</h1></center>
      <!-- / registration form start here -->
      <div class="marchant-form_bg" style="padding:5px 5px">
        <div class="marchant-form_cont" style="margin:20px auto">
 		{if $msg_succ}<p><div class="successMsg" align="center">{$msg_succ}</div></p>{/if}
                {if $msg}<p><div class="errorMsg" align="center">{$msg}</div></p>{/if}
		<form name="frmforgotpass" id="frmforgotpass" action="" method="POST">
			<ul class="fl marchantstep-one-form reset">
				<li>
				<label>Enter your email :</label>
				<div class="textbox fl">
					<input type="text" id="email" name="email"/>
				</div>
				</li>
				<li>
				<label>&nbsp;</label>
				<div class="fl"> <br/>
					<div class="fr" style="margin-left:25px">
					<span class="login-btn-lft"><span class="login-btn-rgt"><input type="submit" name="submit" id="submit" class="login-btn" value="Submit"></span></span>
					</div>



				</div>
				</li>
			</ul>
		</form>
        </div>
        <div class="clr"></div>
      </div>
		<div style="height:100px;"></div>
      <!-- / registration form end here -->
    </div>

  <!-- Maincontent ends -->
{include file=$footer}