<link href="{$siteroot}/templates/default/css/lightbox.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{$siteroot}/js/thick_js/thickbox.js"></script>
{literal}
<script type="text/javascript">
function redirect(){
	window.location="{/literal}{$siteroot}{literal}/deal/viewalldeal/";
}

function invitefrds()
	{	
		tb_show('Invite Friends', SITEROOT+'/modules/invitation/invitation.php?albID=6&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=440&width=400&modal=false',tb_pathToImage);

	}
</script>
{/literal}
<td width="192" valign="top" style="border:none"><!-- Profile Search Section Start -->
          <div class="maincont-inner-rgt fl">
            <div class="search-red">
              <div class="search-red-lft fl"> <img src="{$siteroot}/templates/default//images/search-iocn.png" width="24" height="25" alt="" title="" /> </div>
              <div class="search-red-rgt fr">
              <a  href="{$siteroot}/merchant-account/search_merchant">  <p> SEARCH
                  MERCHANTS &amp; GIVE OFFERS </p></a>
              </div>
              <div class="clr"></div>
            </div>
            <div class="invite-frd">
              <p>OffersnPals is more fun with friends around. Browse your email contacts to invite friends</p>
              <div style=" width:143px; margin:10px auto">
                <input name="name" type="text"  class="invite-btn" value="Invite Friends" style="width:120px"  onclick="javascript:invitefrds();"/>
              </div>
            </div>
          </div>
          <!-- Profile Search Section Start -->
          
          <!-- View all offers start -->
            <div class="fr" style="margin:10px 35px 10px 10px">
               <a href="javascript:void(0)" style="color: #FFFFFF; float:right" onClick="redirect()"><input name="name" type="button"  class="invite-btn" value="View All Offers" style="width:132px;"/></a>
              <div class="clr"></div>
            </div>
          <!-- View all offers ends -->      
</td>