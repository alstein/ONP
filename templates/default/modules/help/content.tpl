{include file=$header_start} 
{if $smarty.session.csUserId eq ''}
	{include file=$header_end}
{else}
	{include file=$profile_header2}
{/if}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
        <td width="208" valign="top"><div class="maincont-inner-lft fl">
            <!--Help Left Section  start -->
            <h1 class="help-title">Help Center</h1>
            	{include file=$help_left} 
          </div>
          <!--Help Left Section end --></td>
        <td width="792" valign="top" style="border:none"><!--Help Right Section  start -->
          <div class="help-contain fl">
            <h1 class="help-title">{$title}</h1>
            <ul class="reset">
              <li>
              <!--  <h2>What’s unique about OffersnPals?</h2>-->
                <p>{$description|html_entity_decode}</p>
              </li>
   
            </ul>
          </div>
          <!--Help Right Section  end --></td>
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
  {include file=$footer}