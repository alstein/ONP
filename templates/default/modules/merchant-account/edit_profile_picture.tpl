{include file=$header_start}

  {include file=$profile_header2}
{strip}
<script type="text/javascript" src="{$sitejs}/validation/profile_picture.js"></script>
{/strip}
{literal}
<script type="text/javascript">
    function setImage(file) {
        if(document.all)
            document.getElementById('prevImage').src = file.value;
        else
            document.getElementById('prevImage').src = file.files.item(0).getAsDataURL();
        if(document.getElementById('prevImage').src.length > 0) 
            document.getElementById('prevImage').style.display = 'block';
    }
</script>


{/literal}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
           {include file=$merchant_home_left}
        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="560" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <div class="edit-profile-form">
              <h1 class=" form-title">Change Profile Picture</h1>
		 <form name="frmUserProfile" id="frmUserProfile" action="" method="post" enctype="multipart/form-data" >
              <ul class="reset user-edit-form">
				<div align="center" class="success">{$msg}</div>
                
                
                <li>
                  <div class="fl"><img id="prevImage" src="{if $user.photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{$user.photo}{/if}" width="120" height="120" alt="image"></div>
                  <div >
                 <input align="left"  contentEditable="false" type="file" value="" name="photo" id="photo"  onchange="setImage(this);"  style="margin-left:5px;">
                  </div>
                  <div class="clr"></div>
                </li>

				
                <li>
                <label>&nbsp;</label>
                <div class="fl" style="margin:0px 0 0 30px">
			<input  type="submit" name="Submit" id="Submit" value="Submit"  style="width:72px" class="previe-btn"/>
      
     		 </div>
      			
                </li>
                

              </ul>
		</form>
            </div>
            <div class="clr" style="height:30px"></div>
          </div>
          <!-- Profile Comment Section End --></td>
        <!-- Profile Middle Section End -->
        <!-- Profile Right Section Start -->
        
  {include file=$merchant_home_right}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
 {include file=$footer}
