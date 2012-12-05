{include file=$header1}
{include file=$header2}
<div style="float:left; width:1035px; padding-left:10px">
  <div>
    <table cellpadding="0" cellspacing="3" align="center" width="100%" class="brdall" border="0">
     {if $smarty.session.duUserTypeId eq 3}
      <tr>
        <td align="left"><p class="blueTxt largeText">Hello, Seller</p>
          <br />
          <span class="frmtxt">Welcome to your Seller control panel. Here you can manage and modify every aspect of your {$sitetitle}. </span><br />
          <br /></td>
      </tr>
     {else}
      <tr>
        <td align="left"><p class="blueTxt largeText">Hello, Admin</p>
          <br />
          <span class="frmtxt">Welcome to your Admin control panel. Here you can manage and modify every aspect of your {$sitetitle}. </span><br />
          <br /></td>
      </tr>
     {/if}
      <tr><td><h1 align='center'></h1></td></tr>
    </table>
  </div>
<!--  <div class="clr"></div>-->
</div>
{include file=$footer}