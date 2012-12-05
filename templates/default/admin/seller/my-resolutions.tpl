{include file=$header_seller1}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}

{literal}
<script language="JavaScript">
$(document).ready(function() {
	$('#frmregistration').validate({
		errorElement:'div',
		rules: {
			deal_id:{
				required:true,
				minlength: 1,
				maxlength: 200
			},
			usr_name:{
				required:true,
				minlength: 2,
				maxlength: 100
			},
			subject:{
				required:true,
				minlength: 4,
				maxlength: 100
			},
			body:{
				required:true,
				minlength: 4,
				maxlength: 10000
			}
		},
		messages: {
			deal_id:{
				required: "Please enter deal id or deal URL",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			usr_name:{
				required: "Please enter your name",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			subject:{
				required: "Please enter subject",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			body:{
				required: "Please enter message",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			}
		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
	});
});
</script>
{/literal}

{include file=$header_seller2}

<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> 
 &gt; Resolution Centre</div>
<br />-->

<section id="maincont" class="ovfl-hidden">

	<section class="grybg">
		<div class="pagehead">
			<div class="grpcol">
				<ul class="reset ovfl-hidden tab1">
					<li><a href="{$siteroot}/admin/seller/my-profile-view.php" class="active">My Account</a> </li>
					<li><a href="{$siteroot}/admin/seller/deal/add_product.php">Deal Management</a> </li>
					<li><a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php">Masters</a> </li>
					<li><a href="{$siteroot}/admin/seller/login-log.php">Tools</a> </li>
				</ul>
                <div class="SubNav">
                <a href="{$siteroot}/admin/seller/my-profile-view.php">My Profile</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                <a href="{$siteroot}/admin/seller/my-resolutions.php" class="active">Resolution Centre</a>
                </div>
			

			</div>
		</div>
		<div class="innerdesc">
        <h3 class="pagehead2">Resolution Centre</h3>
		<div class="border"></div>
    {if $msg_succ}<div align="center" id="msg" style="color:green;"><br/>{$msg_succ}<br/> <br/></div>{/if}

<form name="frmregistration" id="frmregistration" method="POST" action="" enctype="multipart/form-data">
	<ul class="form_div">
				<li><label><span style="color:red">*</span> Your Name:</label>
					<div class="fl">
						<input type="hidden" name="from" id="from" value="{$userData.email}"/>
						<input type="text" name="usr_name" id="usr_name" class="textbox" value="{$userData.fullname}"/>
					</div><div style="clear:both;"></div>
					<div htmlfor="from" generated="true" class="error" style="margin-left:210px;"></div>
				</li>
                <li><label><span style="color:red">*</span> Deal Id/URL:</label>
					<div class="fl">
						<input type="text" name="deal_id" id="deal_id" class="textbox"/>
					</div><div style="clear:both;"></div>
					<div htmlfor="deal_id" generated="true" class="error" style="margin-left:210px;"></div>
				</li>
                <li><label><span style="color:red">*</span> Subject:</label>
					<div class="fl">
						<input type="text" name="subject" id="subject" class="textbox"/>
					</div><div style="clear:both;"></div>
					<div htmlfor="subject" generated="true" class="error" style="margin-left:210px;"></div>
				</li>
                <li><label><span style="color:red">*</span> Message:</label>
					<div class="fl">
						<textarea name="body" id="body" class="textbox" rows="5" cols="50"></textarea>
					</div><div style="clear:both;"></div>
					<div htmlfor="body" generated="true" class="error" style="margin-left:210px;"></div>
				</li>
                <li><label>&nbsp;</label>
                <div class="fl btnmain">
							<input type="submit" name="submit" id="submit" value="Save" class="buybtn2">
						</div>
				</li>
		</ul>


		

</form>
</div>
{include file=$footer_seller}