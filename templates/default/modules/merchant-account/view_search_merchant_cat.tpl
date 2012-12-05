{include file=$header_start}
{literal}
<script language="JavaScript" type="text/javascript">
function appr(val1,username)
{  
	
	var f_id1=val1;
	document.forms["profile"].fid1.value = f_id1;
	document.forms["profile"].act.value = "Insert";
	
	if(confirm("Would you like to be a fan of  "+username+" ?"))
	{
		//var an = document.getElementById('a_'+val1);
		//an.removeAttribute('onclick');
		$("#a_"+val1).removeAttr("onclick");
		document.forms["profile"].submit();
		//window.location.reload();


		
	}
}
</script>
{/literal}

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
        <td width="580" valign="top"><!-- Profile Comment Section Start -->


		<input type="hidden" name="act" id="act">
		<input type="hidden" name="fid" id="fid" value="">
		<input type="hidden" name="fid1" value="">
		<input type="hidden" name="name" id="name" value="{$smart.post.name}" >
		<input type="hidden" name="maincategory" id="maincategory" value="{$smart.post.maincategory}" >
		<input type="hidden" name="cityid" id="cityid" value="{$smart.post.cityid}" >
		<input class="signinput" name="name" type="hidden" id="name" value="{$smarty.post.name}" 
			size="25" class="textbox fl"/>
		<input class="signinput" name="maincategory" type="hidden" id="maincategory" value="{$smarty.post.maincategory}" 
			size="25" class="textbox fl"/>
		<input class="signinput" name="cityid" type="hidden" id="cityid" value="{$smarty.post.cityid}" 
			size="25" class="textbox fl"/>

          <div class="maincont-inner-mid fl">

            <div class="result">

              <div class="result-head">

                <h1>Search Merchant With Category {$select_category.category}</h1>

              </div>

              <ul class="reset result-listing">

{section name=i loop=$searches }
                <li>

                  <div>

                    <div class="result-lft fl"> 
						<a style="float:left;margin-top:1px;" href="{$siteroot}/merchant-account/{$searches[i].userid}/merchant_profile">
							<img src="{$siteroot}/uploads/user/{if $searches[i].photo neq ''}{$searches[i].photo}{else}profile_pic.png{/if}" title="" alt="" width="51" height="51" />
						</a>
					</div>

                    <div class="result-mid fl">

                      <div>

                        <a href="{$siteroot}/merchant-account/{$searches[i].userid}/merchant_profile"><h1>{$searches[i].business_name}</h1></a>
                        <span>Singapore</span>

                        <div class="clr"></div>

                      </div>

                      <div class="fl" style="margin:7px 0 0 0"> 
<span  class="star_1" style="width:20px;">
	<img  {if $searches[i].rating  > 0 && $searches[i].rating <= 0.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $searches[i].rating > 0.5 } src="{$siteroot}/templates/default/images/star-on.png" {else}  src="{$siteroot}/templates/default/images/star-off.png" {/if} style="margin:0px;border:none"/>
</span> 

<span class="star_2" style="width:20px;">
	<img alt="" {if $searches[i].rating > 1 && $searches[i].rating  <= 1.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $searches[i].rating > 1.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if} style="margin:0px;border:none"/>
</span> 

<span class="star_3" style="width:20px;">
	<img  alt=""  {if $searches[i].rating > 2 && $searches[i].rating  <= 2.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $searches[i].rating  > 2.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if} style="margin:0px;border:none"/>
</span>

<span class="star_4" style="width:20px;">
	<img  alt="" {if $searches[i].rating > 3 && $searches[i].rating  <= 3.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $searches[i].rating > 3.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if} style="margin:0px;border:none"/>
</span>

<span class="star_5" style="width:20px;">
	<img alt="" {if $searches[i].rating > 4 && $searches[i].rating  <= 4.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $searches[i].rating  > 4.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if} style="margin:0px;border:none"/>
</span>
 </div>

                    </div>


					{if $searches[i].count gt 0}
                    <div class="result-rgt fr">

                      <button class="submitbtn"  style="width:120px"> <span class="submitbtn-lft"><span class="submitbtn-rgt">I'm Your Fan</span></span> </button>

                    </div>

					{else}
 						<div class="result-rgt fr">

                      		<a href="javascript:void(0)" id="a_{$searches[i].userid}" onclick="appr({$searches[i].userid},'{$searches[i].business_name|ucfirst}');">
								<button class="greybtn"  style="width:120px"> 
									<span class="greybtn-lft">
										<span class="greybtn-rgt">Become a Fan
										</span>
									</span> 
								</button>

							</a>
                   		 </div>
					{/if}
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
<input class="signinput" name="name" type="hidden" id="name" value="{$smarty.post.name}" 
			size="25" class="textbox fl"/>
		<input class="signinput" name="maincategory" type="hidden" id="maincategory" value="{$smarty.post.maincategory}" 
			size="25" class="textbox fl"/>
		<input class="signinput" name="cityid" type="hidden" id="cityid" value="{$smarty.post.cityid}" 
			size="25" class="textbox fl"/>
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