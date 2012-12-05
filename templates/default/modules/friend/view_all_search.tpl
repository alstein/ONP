{include file=$header_start}
{literal}
<script language="JavaScript" type="text/javascript">
function appr(val1)
{  
	
	var f_id1=val1;
	document.forms["profile"].fid1.value = f_id1;
	document.forms["profile"].act.value = "Insert";
	document.forms["profile"].submit();
	
// 	if(confirm("Would you like to approve this request?"))
// 	{
// 		document.forms["profile"].submit();
// 	}
}
</script>
{/literal}
  <!-- header container starts here-->
    {include file=$profile_header2}
  <!-- Maincontent starts -->

  <div id="maincont" class="ovfl-hidden">

    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">

      <tr>

        <!-- Profile Left Section Start -->

        <td width="208" valign="top">{include file=$profile_left}</td>

        <!-- Profile Left Section End -->

        <!-- Profile Middle Section Start -->

	<form name="profile" id="profile" method="POST">
		<input type="hidden" name="act" value="" id="act">
		<input type="hidden" name="fid" id="fid" value="">
		<input type="hidden" name="fid1" value="">
        <td width="580" valign="top"><!-- Profile Comment Section Start -->


		<input class="signinput" name="name" type="hidden" id="name" value="{$smarty.post.name}" 
			size="25" class="textbox fl"/>
		<input class="signinput" name="maincategory" type="hidden" id="maincategory" value="{$smarty.post.maincategory}" 
			size="25" class="textbox fl"/>
		<input class="signinput" name="cityid" type="hidden" id="cityid" value="{$smarty.post.cityid}" 
			size="25" class="textbox fl"/>

          <div class="maincont-inner-mid fl">

            <div class="result">

              <div class="result-head">

                <h1>All Result for Friends </h1>

              </div>

              <ul class="reset result-listing">

{section name=i loop=$searches }
                <li>

                  <div>

                    <div class="result-lft fl"> 

						<a href="{$siteroot}/my-account/{$searches[i].userid}/my_profile" style="float:left;margin-top:1px;" ><img src="{if $searches[i].facebook_userid neq ''}http://graph.facebook.com/{$searches[i].facebook_userid}/picture?type=large{else} {$siteroot}/uploads/user/{if $searches[i].photo neq ''}{$searches[i].photo}{else}profile_pic.png{/if}{/if}" title="" alt="" width="51" height="51" /></a>

					</div>

                    <div class="result-mid fl">

                      <div>
                        <a href="{$siteroot}/my-account/{$searches[i].userid}/my_profile" style="float:left;padding: 4px;margin-top:0px;padding-left:0px;">{$searches[i].first_name} {$searches[i].last_name}</a>
                        <div class="clr"></div>
                      </div>
					  <div>Singapore</div>	

				</div>
		{if $smarty.session.csUserTypeId neq '3'}
		{if $searches[i].verification eq 'pending'}
			{if $searches[i].friendid eq $smarty.get.id1}
			<div class="result-rgt fr">
				<a href="{$siteroot}/my-account/friend_request">
					<button class="greybtn"  style="width:120px"> 
						<span class="greybtn-lft">
							<span class="greybtn-rgt">Respond
							</span>
						</span> 
					</button>
				</a>	
			</div>
			{else}
			 <div class="result-rgt fr">
				<a href="javascript:void(0);">
					<button class="greybtn"  style="width:120px"> 
						<span class="greybtn-lft">
							<span class="greybtn-rgt">Requested
							</span>
						</span> 
					</button>
				</a>	
			</div>
			{/if}
		
		{elseif $searches[i].verification eq 'yes'}
			 <div class="result-rgt fr">
				<a href="javascript:void(0);">
					<button class="greybtn"  style="width:120px"> 
						<span class="greybtn-lft">
							<span class="greybtn-rgt">Friend
							</span>
						</span> 
					</button>
				</a>	
			</div>
		{else}
			 <div class="result-rgt fr">
				<a href="javascript:void(0)" onclick="appr({$searches[i].userid});">
					<button class="greybtn"  style="width:120px"> 
						<span class="greybtn-lft">
							<span class="greybtn-rgt">Add as friend
							</span>
						</span> 
					</button>
				</a>	
			</div>
		{/if}{/if}


                    <!--</div>-->


					
                    <div class="clr"></div>

                  </div>

                </li>

{sectionelse}
				<div class="error" align="center">No Records Found.</div>
{/section}
               
               
                <li><div align="right">{$pgnation}</div></li>

              </ul>

            </div>

            <div class="clr" style="height:20px"></div>

          </div>

          <!-- Profile Comment Section End --></td>

		</form>
		
        <!-- Profile Middle Section End -->

        <!-- Profile Right Section Start -->

        <td width="192" valign="top" style="border:none"><!-- Profile Search Section Start -->

          {include file=$profile_right}
          <!-- Profile Search Section Start --></td>

        <!-- Profile Right Section End -->

      </tr>

    </table>

  </div>

  <!-- Maincontent ends -->

</div>

     {include file=$footer}