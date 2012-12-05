{include file=$header1}
<script type="text/javascript" src="{$sitejs}/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript">
{literal}
$(document).ready(function(){
  $("#home_form").validate({
    errorElement:'div',
    rules: {
      pagename:{
              required: true 
      }
    },
    messages: {
        pagename:{
                required: "Please enter pagename"
        }
    }
  });
});
{/literal}
</script>
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/globalsettings/seo_list.php"> SEO List</a> &gt; Edit SEO List</div><br/>
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Edit SEO</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
	</div>
      <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
  
    <form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
       <input type="hidden" value="{$smarty.get.editid}" name="id_name" id="id_name" />
      <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
        <tr> 
           <td width="20%" align="right" ><span style="color:red;">*</span>Pagename:</td> 
           <td align="left" width="40%"><input type="text" name="pagename" id="pagename" value="{$pagename}"   style="width:268px;" maxlength="255" readonly="true" style="background:#D4D0C8"/>
          </td> 
        </tr>
        <tr>
          <td width="20%" align="right" valign="top">Meta Title:</td>
          <td>
          <input type="text" name="metatitle" id="metatitle" value="{$metatitle}"   style="width:268px;" maxlength="255"/>
         </td>
      </tr>
            <tr> 
              <td width="20%" align="right" valign="top" > Meta Tag Description:</td> 
              <td align="left" width="40%">
                <!--<input type="text" name="metatagdesc" id="metatagdesc" value="{$metatagdesc}" />-->
                <textarea cols="50" rows="4" class="textbox" id="metatagdesc" name="metatagdesc">{$metatagdesc}</textarea>
              </td>
             </tr>
              <tr>
                    <td width="20%" align="right" valign="top" > Meta Tag Keyword :</td> 
                    <td align="left" width="40%">
			<!--<input type="text" name="metatagkeyword" id="metatagkeyword" value="{$metatagkeyword}"   style="width:268px;"/>-->
			<textarea cols="50" rows="4" class="textbox" id="metatagkeyword" name="metatagkeyword">{$metatagkeyword}</textarea>
		    </td>
            </tr> 
    <tr>
      <td>&nbsp;</td>
      <td align="left">
      <div style="width:140px"> 
         <div id="buttonregister" style="overflow:hidden"> 
                 <input type="submit" name="Update" id="Update" value="Update" class="but_new fl" />
                 <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="javascript: location='seo_list.php'" 
                 class="but_new fr"/> 
        </div>
      </div>
      </td>
    </tr>
  </table>
  </form> 
</div>
</div>
{include file=$footer}
