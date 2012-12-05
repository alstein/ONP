{include file=$header1}
<link rel="stylesheet" href="{$siteroot}/templates/default/css/thickbox.css" type="text/css" media="screen" />

<script type="text/javascript" src="{$siteroot}/js/thick_js/thickbox.js"></script>
<script type="text/javascript">
{literal}
$(document).ready(function(){
 $("#smsg").fadeOut(3000);
 });
{/literal}
</script>
</script>
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Site Settings</div>
<br />
{if $msg}<div id="smsg" align="center">{$msg}</div>{/if}
<h2 class="txt13 padingTop">Sitesettings</h2>
<div class="holdthisTop">
  <table width="100%"  align="center">
    <tr>
      <td><table width="100%"  border="0" cellspacing="0" cellpadding="" align="center">
          {if $err neq ""}
          <tr class="trbgprj01" nowrap>
            <td colspan="4"><center>
                <span class="error">{$err}</span>
              </center></td>
          </tr> {/if}
          <tr>
            <td  align="right"><table>
                <tbody>
                </tbody>
              </table></td>
          </tr>
        </table>
        <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
          <tr align="center" class="headbg">
            <td width="20%" align="left">Parameter</td>
            <td align="left" width="70%">Description</td>
            <td width="10%" align="left">Action</td>
          </tr>
          {section name=i loop=$site}
          <tr class="grayback">
            <td valign="top" width="20%">{$site[i].type}</td>
            <td valign="top" align="left" width="70%">{$site[i].value}</td>
            <td valign="top" width="10%" align="left"> <img src="{$siteroot}/templates/{$templatedir}/images/icons/application_edit.png" align="absmiddle"/>
			
			
		<a href="javascript:void(0)" onClick="javascript:tb_show('Edit Site Master', 'Edit-Sitemaster.php?id={$site[i].id}&amp;placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height={if $site[i].id eq '36'}220{else}150{/if}&amp;width=600&amp;modal=false', tb_pathToImage);"  value="Edit Site Master">Edit</a>
			
			
			<!--<a href="Edit-Sitemaster.php?id={$site[i].id}&amp;placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height={if $site[i].id eq '36'}220{else}150{/if}&amp;width=600&amp;modal=false" class="thickbox" title="Edit Site Master" linkindex="2" set="yes">Edit</a>-->
			
			</td>
          </tr>
          {/section}
        </table></td>
    </tr>
  </table>
</div>
{include file=$footer}