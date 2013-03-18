<td width="192" valign="top" style="border:none"><!-- Profile Search Section Start -->
          <div class="maincont-inner-rgt fl">

			{if $whose_profile eq 'Consumer'  ||  $whose_profile eq 'view_friend' || $whose_profile eq 'view_searches'}
			{if $whose_profile neq 'view_searches' }
			{if $smarty.session.csUserTypeId eq 2}
				{if  $count_friend neq '0' && $friend_acc.verification eq 'pending'}
					{if $smarty.get.id1 neq ''}
            <div>
				<input type="button" name="" id="" style="font-size: 12px;" value="Request Pending"    class="send-msg-btn" >
				{/if}
				{elseif $count_friend eq '0' && $smarty.get.id1 neq '' && $smarty.get.id1 neq $smarty.session.csUserId && $chkusertype eq '2'}
              <input name="addasfriend" id="addasfriend" value="Add As Friend"  onclick="appr('{$user.fullname}'); "  class="send-msg-btn" />
				{else}
			 <input name="addasfriend" id="addasfriend" value="Send Message"  onclick="tb_show('Send Message', '{$siteroot}/modules/message/create.php?id1={$smarty.get.id1}&id=1&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=400&width=550&modal=false', tb_pathToImage);"  class="send-msg-btn" />
			{/if}
			{/if}
		{/if}
	

{/if}
            </div>
          </div>
          <!-- Profile Search Section Start --></td>

