{include file=$header1}
{literal}
	<script language="javascript">
	
		function trim(stringToTrim)
		{
			return stringToTrim.replace(/^\s+|\s+$/g,"");
		}
		
		function is_validate()
		{
			if(trim(document.frmAd.tittle.value) == '')
			{
					alert("Please enter title.");
					document.frmAd.tittle.focus();
					return false;
			}
			if(trim(document.frmAd.desc.value) == '')
			{
					alert("Please enter Description.");
					document.frmAd.desc.focus();
					return false;
			}
			if(trim(document.frmAd.acc_rec.value) == '')
			{
					alert("Please enter account receivable.");
					document.frmAd.acc_rec.focus();
					return false;
			}
			if(trim(document.frmAd.c_info.value) == '')
			{
					alert("Please enter contact information.");
					document.frmAd.c_info.focus();
					return false;
			}

			if(document.getElementById("text") != null && trim(document.frmAd.content.value) == '')
			{
					alert("Please enter Embedded Code.");
					document.frmAd.content.focus();
					document.frmAd.content.select();
					return false;
			}
			
			if(document.frmAd.img.value != '')
			{	
				if(isValidImage(document.frmAd.img.value))
				{
					alert("You Can Upload Only Image Based Files");
					return false;		
				}	
			}
			else
			{
				if(document.getElementById("im") == null)
				{
				alert("Please upload image.");
				document.frmAd.img.focus();
				document.frmAd.img.select();
				return false;
				}
			}  
			return true;
		}

		function isValidImage(imagename)
		{
			imagefile_value = imagename;
			var checkimg = imagefile_value.toLowerCase();
			if (!checkimg.match(/(\.jpg|\.gif|\.png|\.JPG|\.GIF|\.PNG|\.jpeg|\.JPEG)$/))
			{
						
				return true;
			}
			else
			{
				return false;
			}
		}


		function switchControl(value,content)
		{
			switch(value)
			{
				case 'embedded':
					document.getElementById("content").innerHTML ="<textarea class='text_area5' cols='60' rows='10' name='content' id='text'>"+content+"</textarea>";
					//document.getElementById("image").innerHTML = "";
					document.getElementById("image").style.visibility = 'hidden';					
					document.getElementById("text").focus();
					break;
				case 'image':
					document.getElementById("content1").innerHTML ="<input type='text' name='link' id='link' value=''>";
					document.getElementById("content").innerHTML ="<input type='file' name='img'>";				
					document.getElementById("image").style.visibility = 'visible';
					break;
				default:
			}
		}
	</script>
{/literal}
{include file=$header2}
<div class="holdthisTop">
<div class="breadcrumb">
		<a href="{$siteroot}/admin/index.php">Home</a> &gt;&nbsp;<a href="{$siteroot}/admin/sitemodules/admanagement/Manage_Ads.php">Ad Manage List</a> &gt;Edit Ad
	</div> <br />
  <table width="100%"  align="center">

    <tr>
      <td>
        <form name="frmAd" method="post" action="" enctype="multipart/form-data" onsubmit="return is_validate();">
          <table width="100%"  border="2" cellpadding="6" cellspacing="2" class="listtable">
	  <tr>
	  <TD align="left"><h2 class="txt13 padingTop">{if $ad_id gt 0}<input type="hidden" name="ad_id" value="{$ad_id}" /><input type="hidden" name="old_image" value="{if $ad.ad_image}{$ad.ad_image}{/if}" />Edit Ad{else}New Ad{/if}</h2></table>
	<TD align="right"><b><a href="Manage_Ads.php">Back</a></b></TD>
	</tr>
            <tr>
              <td width="10%" align="right" valign="top">Title</td>
              <td align="left"><input type="text" name="$tittle" id="$tittle" size="50" value="{$ad.ad_title}"/>
              <br /></td>
            </tr>
            <tr>
              <td valign="top" align="right" >Description</td>
              <td valign="top">
                	<textarea name="desc" cols="60" rows="8">{$ad.ad_desc}</textarea>
                </td>
            </tr>
	    <tr>
	      <td width="15%" align="right" valign="top">
		  <span id="mesg" class="mesg_red" style="color :red;">*</span>&nbsp;Accounts receivable: 
	      </td>
	      <td align="left">
		  <input type="text" name="acc_rec" id="acc_rec" size="50" maxlength="100" value="{$ad.acc_rec}" />
	      </td>
	    </tr>
	    <tr>
	      <td width="15%" align="right" valign="top">
		  <span id="mesg" class="mesg_red" style="color :red;">*</span>&nbsp;Contact Info: 
	      </td>
	      <td align="left">
		  <input type="text" name="c_info" id="c_info" size="50" maxlength="100" value="{$ad.c_info}" />
	      </td>
	    </tr>
            <tr>
              <td valign="top" align="right" >Align</td>
              <td valign="top">
                <input type="radio" name="align" value="Right Top" {if $ad_id gt 0 and $ad.ad_align == 'Top'}checked="true"{else}checked="true"{/if}>Right Top
		<input type="radio" name="align" value="Right Footer" {if $ad_id gt 0 and $ad.ad_align == 'Footer'}checked="true"{/if}>Right Footer
		<!--<input type="radio" name="align" value="Side" {if $ad_id gt 0 and $ad.ad_align == 'Side'}checked="true"{/if}>Side-->
              </td>
            </tr>
	   <tr>
              <td valign="top" align="right" >Select</td>
              <td valign="top">
			<input type="radio" name="ad_cont" value="Embedded Code" onclick="switchControl('embedded','{if $ad.ad_embedded_code} {$ad.ad_embedded_code|escape:'htmlall'} {/if}');" {if $ad.ad_embedded_code} checked="true"{else} checked="true" {/if}>Embedded Code
			<input type="radio" name="ad_cont" value="Image" onclick="switchControl('image','');" 
				{if $ad_id gt 0 and $ad.ad_image != ''} checked="true" {/if}>Image
			
	      </td>
            </tr>
		{if $ad_id gt 0 and $ad.ad_image != ''}
		<tr id="image">
			<TD valign="top" align="right">&nbsp;</TD>
			<TD align="left">{if $ad.ad_image}<img src="{$siteroot}/uploads/ad/{$ad.ad_image}" id="im"/>{/if}</TD>
		</tr>	
			
		{/if}
	    <tr>
              <td valign="top" align="right" >
			&nbsp;
	      </td>
              <td valign="top">
			<div id="content">
				{if $ad.ad_embedded_code != '' and $ad.ad_image == ''}
					<textarea cols="60" rows="8" name="content" id="text">{$ad.ad_embedded_code}</textarea>
			       {elseif $ad_id == 0}
					<textarea class="text_area5" cols="60" rows="8" name="content" id="text"></textarea>
				{/if}
				{if  $ad.ad_image != ''}
					<input type='file' name='img'>						
				{/if}
			</div>
		</td>
            </tr>	
	   <tr>
		
		<td valign="top" align="right">
			{if  $ad.ad_image != ''}Link{else}&nbsp;{/if}
			
	      </td>
		<td valign="top">
			<div id="content1">				
			  {if  $ad.ad_image != ''}
				  <input type="text" name="link1" id="link1" value="{$ad.ad_link}">		
			  {/if}
		      </div>
		</td>
		
          </tr>	
            <tr>
              <td align="right" valign="top"></td>
              <td><input type="submit" name="Submit" id="Submit" value="Update" class="button1"/><div class="buttonEnding1"></div>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" name="Cancel" value="Cancel" class="button1" onclick="javascript: history.back();" />
		</td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>
</div>
{include file=$footer} 
