{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/forum.js"></script>
{include file=$header2}
<div class="holdthisTop">
<div class="breadcrumb"><a href="{$siteroot}/admin/modules/forum/index.php">Forums</a> > <a href="{$siteroot}/admin/modules/forum/thread_list.php?forumid={$forum.forumid}">Posts</a> > {if $thread.threadid}Edit{else}Add{/if} Post</div><br/>
<table width="100%" cellpadding="6" cellspacing="2" class="conttableDkBg conttable">
  <tr>
    <td valign="top" align="justify"><h4>{$forum.title}</h4>
      {$forum.description}</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><form action="#" method="post" name='frmThread' id="frmThread">
        <input type="hidden" name="threadid" value="{$thread.threadid}" />
        <input type="hidden" name="forumid" value="{$forum.forumid}" />
        <table width="90%" border="0" cellspacing="5" cellpadding="5"   >
          <tr>
            <td style="vertical-align:top;text-align:right;">Description: </td>
            <td align="left" >
                <!--<input type="text" size="80" maxlength="255" name="title" id="title" value="{$thread.title}" />-->

                <textarea name="title" id="title" rows="5" cols="70">{$thread.title}</textarea>
        </td>
          </tr>
         <!-- <tr align="left" valign="top" >
            <td>Description </td>
            <td><textarea name="description" id="description" rows="10" cols="70">{$thread.description}</textarea></td>
          </tr>-->
          <tr align="left" >
            <td>&nbsp;</td>
            <td><input type="submit" onclick="" value="Save" name="submit"/>
            </td>
        </table>
      </form></td>
  </tr>
</table>
</div>
{include file=$footer}