</head>
<body>
<div id="mainWrapper">
<div id="header">
	<div class="topLinkBg ar">
		{if $smarty.session.duUserTypeId eq 3}
			{assign var=signouturl value="/signout"}
		{else}
			{assign var=signouturl value="/admin/login/signout.php"}
		{/if}
		<p>
		{if $smarty.session.admLgn ne ""}{$smarty.session.duAdmFname} {if $smarty.session.duUserTypeId eq 1}
          [Administrator]{else}[Merchant]{/if} | <a href="{$siteroot}{$signouturl}">LogOut</a>{else}Welcome To {$sitetitle} Please Login{/if}
		</p>
	</div>
	<div id="logo">
		<div class="fl ar"><h2 class="padOne"><a href="{$siteroot}/admin/index.php">
		<img src="{$siteroot}/templates/default/images/logo-new02.png"/></a></h2></div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>

</div>
<div id="maincont">
<div class="bgWht padOne">
 {if $smarty.session.duAdmId}
  <div style="float:left; width:170px">
    <ul id="nav" class="menu">
	{if $smarty.session.duAdmId == '1'}
        <li> <a href="JavaScript:void(0);" {if $inmenu eq 'user'} style="color:#87B400;"{/if}>Members</a>
            <ul class="SubNav">
			<li> <a href="{$siteroot}/admin/user/manage_admin.php">Admin User ({$TOT_ADMIN})</a></li>
			<li> <a href="{$siteroot}/admin/user/users_list.php">Consumer List ({$TOT_BUYER})</a></li>
			<li> <a href="{$siteroot}/admin/user/seller_list.php">Merchant User ({$TOT_SELLER})</a></li>
<!--<li> <a href="{$siteroot}/admin/sitemodules/albums/album.php">Album Manager ({$TOT_SELLER})</a></li>-->
            </ul>
        </li>
	{/if}
        {if in_array("2",$arr_modules_permit) == true || in_array("3", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'
	 || in_array("8",$arr_modules_permit) == true || in_array("9", $arr_modules_permit) == true || in_array("10",$arr_modules_permit) == true
	 || in_array("38",$arr_modules_permit) == true || in_array("9", $arr_modules_permit) == true || in_array("11",$arr_modules_permit) == true
	 || in_array("12",$arr_modules_permit) == true || in_array("40", $arr_modules_permit) == true || in_array("13",$arr_modules_permit) == true
	 || in_array("14",$arr_modules_permit) == true || in_array("15", $arr_modules_permit) == true || in_array("16",$arr_modules_permit) == true
	 || in_array("17",$arr_modules_permit) == true || in_array("41", $arr_modules_permit) == true || in_array("47", $arr_modules_permit) == true || in_array("50", $arr_modules_permit) == true || in_array("51", $arr_modules_permit) == true }
        <li> <a href="JavaScript:void(0);">Deal Management</a>
            <ul class="SubNav">
              <!-- {if in_array("47", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                     <li> <a href="{$siteroot}/admin/deal/deal_type_list.php">Deal Type</a></li>
               {/if}-->

               {if in_array("2", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/category/category_list.php">Merchant Category</a></li>
               {/if}

               <!-- {if in_array("3", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/globalsettings/deal/add_product.php">Add New Deal</a> </li>
                {/if}-->
	
                <!--{if in_array("9", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
		    <li> <a href="{$siteroot}/admin/globalsettings/deal/pending-deal.php">Pending Deals ({$deal_notice_info.tot_pending})</a> </li>
                {/if}-->
                {if in_array("10", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
		<li> <a href="{$siteroot}/admin/globalsettings/deal/manage_deal.php">Active Deals ({$adealnum})</a></li>
		{/if}
               <!-- {if in_array("38", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                <li> <a href="{$siteroot}/admin/globalsettings/deal/featured_deal.php">Featured Deals ({$deal_notice_info.tot_fea})</a></li>	
                {/if}-->

             <!--   {if in_array("16", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
		<li> <a href="{$siteroot}/admin/globalsettings/deal/rejected-deals.php">Rejected Deals ({$deal_notice_info.tot_rej})</a> </li>
                {/if}-->

              <!--  {if in_array("50", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
				<li> <a href="{$siteroot}/admin/globalsettings/deal/upcoming_deal.php">Upcoming Deals ({$deal_notice_info.tot_upcom})</a></li>
			{/if}-->
			{if in_array("51", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
				<li> <a href="{$siteroot}/admin/globalsettings/deal/expired_deal.php">Expired Deals ({$edealnum})</a></li>
			{/if}
			{if in_array("40", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
				<li> <a href="{$siteroot}/admin/globalsettings/deal/manage_complete_gb_product.php">Completed Deals ({$cdealcnt})</a> </li>
			{/if}

			{if in_array("40", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
				<li> <a href="{$siteroot}/admin/deal/offer_deal_request.php">Deals By Consumers</a> </li>
			{/if}
			{if in_array("40", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
				<li> <a href="{$siteroot}/admin/deal/merchant_deal_request.php"> Requests By Merchant</a> </li>
			{/if}
			{if in_array("40", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
				<li> <a href="{$siteroot}/admin/user/merchant_pay.php">Merchant Pay Offer Deal</a> </li>
			{/if}
            </ul>
        </li>
        {/if}

      
	<li> <a href="JavaScript:void(0);">Friends</a>
            <ul class="SubNav">
              {if in_array("2", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/friend/friend_list.php">Friend List</a></li>
               {/if}

                {if in_array("3", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/friend/fan.php">Fan List</a> </li>
                {/if}
	    </ul>
        </li>




 {if in_array("6", $arr_modules_permit) == true || in_array("24", $arr_modules_permit) == true || in_array("25", $arr_modules_permit) == true || in_array("59", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
        <li> <a href="JavaScript:void(0);" {if $inmenu eq 'search'} class="active"{/if}>Contents</a>
            <ul class="SubNav">
                {if in_array("6", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/contentpages/page_list.php">Manage Pages</a> </li>
			 {/if}
			 {if in_array("24", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/modules/faq/faq_list.php">FAQ</a></li>
                {/if}
                {if in_array("25", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/modules/faq/faqcategory_list.php">FAQ Category</a></li>
                {/if}
               <!--<li> <a href="{$siteroot}/admin/contentpages/contact_us.php">Contact Us</a></li>-->
		 <li> <a href="{$siteroot}/admin/modules/contact/company_contact.php">Contact Company</a></li>
            </ul>
        </li>
        {/if}

	{if in_array("18", $arr_modules_permit) == true || in_array("18", $arr_modules_permit) == true || in_array("20", $arr_modules_permit) == true || in_array("21", $arr_modules_permit) == true || in_array("48", $arr_modules_permit) == true || in_array("62", $arr_modules_permit) == true || in_array("72", $arr_modules_permit) == true || in_array("73", $arr_modules_permit) == true || in_array("74", $arr_modules_permit) == true || in_array("75", $arr_modules_permit) == true || in_array("77", $arr_modules_permit) == true || in_array("80", $arr_modules_permit) == true || in_array("87", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
        <li> <a href="JavaScript:void(0);" {if $inmenu eq 'gsetting'}class="active"{/if}>Global Settings</a>
            <ul class="SubNav">
                {if in_array("18", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/globalsettings/system_emails.php">System Emails</a> </li> 
		{/if}
		{if in_array("19", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/globalsettings/Sitemaster-List.php">Site Settings</a> </li> 
                {/if}
		{if in_array("62", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/globalsettings/seo_list.php">SEO List</a> </li> 
		{/if}

                <!--{if in_array("22", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                <li> <a href="{$siteroot}/admin/mastermanagement/undermaintenance.php">Under Maintenance Page</a> </li>
                {/if}-->
                {if in_array("48", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                <li> <a href="{$siteroot}/admin/mastermanagement/payment_setting.php">Payment Gateway</a></li>
                {/if}

				{if in_array("48", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                	<li> <a href="{$siteroot}/admin/modules/contact/password.php">Beta Testing Password</a></li>
                {/if}
               </ul>
        </li>
        {/if}

	{if in_array("24", $arr_modules_permit) == true || in_array("25", $arr_modules_permit) == true || in_array("26", $arr_modules_permit) == true || in_array("49", $arr_modules_permit) == true || in_array("54", $arr_modules_permit) == true || in_array("57", $arr_modules_permit) == true || in_array("58", $arr_modules_permit) == true || in_array("60", $arr_modules_permit) == true || in_array("61", $arr_modules_permit) == true || in_array("63", $arr_modules_permit) == true || in_array("64", $arr_modules_permit) == true || in_array("65", $arr_modules_permit) == true || in_array("66", $arr_modules_permit) == true || in_array("67", $arr_modules_permit) == true || in_array("69", $arr_modules_permit) == true || in_array("70", $arr_modules_permit) == true || in_array("76", $arr_modules_permit) == true || in_array("78", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
        <li> <a href="JavaScript:void(0);">Masters</a>
            <ul class="SubNav">

		{if in_array("54", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                <!--<li> <a href="{$siteroot}/admin/country/country_list.php">Manage Country, State, City</a></li>-->
		{/if}

              <!--
                {if in_array("26", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/modules/ipban/ipban.php">IP Ban</a></li>
                {/if}-->

                {if in_array("58", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <!--<li> <a href="{$siteroot}/admin/modules/links/edit_links.php">Manage Links</a></li>-->
                {/if}
                {if in_array("60", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <!--<li> <a href="{$siteroot}/admin/modules/logos/followus_logo_list.php">Manage Followus Logos</a></li>-->
                {/if}
                {if in_array("61", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <!--<li> <a href="{$siteroot}/admin/modules/logos/payment_logo_list.php">Manage Payment Logos</a></li>-->
                {/if}
                <!--{if in_array("63", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/modules/rating/rating_question_list.php">Manage Rating Questions</a></li>
                {/if}-->
		{if in_array("64", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                    <li> <a href="{$siteroot}/admin/modules/rating/reviews_rating_deals_list.php">Manage Reviews/Ratings</a></li>
                
                {/if}
		<!-- {if in_array("76", $arr_modules_permit) == true || $smarty.session.duAdmId == '1'}
                <li> <a href="{$siteroot}/admin/modules/logos/freecoupons_images_list.php">Free Coupons Images</a></li>
                {/if}-->
                


            </ul>
        </li>
        {/if}
{if $smarty.session.duUserTypeId == '1'}
	<li> <a href="JavaScript:void(0);" {if $inmenu eq 'company'} class="active" {/if}>Tools</a>
		<ul class="SubNav">
			<li> <a href="{$siteroot}/admin/login/admin-login-log.php">Admin Login Log</a> </li>
			<li> <a href="{$siteroot}/admin/login/user-login-log.php">Consumer Login Log</a> </li>
			<li> <a href="{$siteroot}/admin/login/seller-login-log.php">Merchant Login Log</a> </li>
			<li> <a href="{$siteroot}/admin/login/signout.php">Sign Out</a> </li>
		</ul>
	</li>
{/if}


<!-- //////////////////START Seller Menus/////////////////// -->
<!--{if $smarty.session.duUserTypeId == '3'}


	<li> <a href="javascript:void(0);" {if $inmenu eq 'myaccount'} class="active" {/if}>My Account</a>
		<ul class="SubNav">
			<li> <a href="{$siteroot}/admin/seller/my-profile-view.php">My Profile</a> </li>
			<li> <a href="{$siteroot}/admin/seller/my-resolutions.php">Resolution Centre</a> </li>
		</ul>
	</li>
	
	<li> <a href="javascript:void(0);" {if $inmenu eq 'deal_management'} class="active" {/if}>Deal Management</a>
		<ul class="SubNav">
			<li> <a href="{$siteroot}/admin/seller/deal/add_product.php">Add New Deal</a> </li>
			<li> <a href="{$siteroot}/admin/seller/deal/pending-deal.php">Pending Deals ({$deal_notice_info_seller.tot_pending})</a> </li>
			<li> <a href="{$siteroot}/admin/seller/deal/manage_deal.php">Active Deals ({$deal_notice_info_seller.tot_actv1})</a></li>
			<li> <a href="{$siteroot}/admin/seller/deal/featured_deal.php">Featured Deals ({$deal_notice_info_seller.tot_fea})</a></li>	
			<li> <a href="{$siteroot}/admin/seller/deal/rejected-deals.php">Rejected Deals ({$deal_notice_info_seller.tot_rej})</a> </li>
			<li> <a href="{$siteroot}/admin/seller/deal/upcoming_deal.php">Upcoming Deals ({$deal_notice_info_seller.tot_upcom})</a></li>
			<li> <a href="{$siteroot}/admin/seller/deal/expired_deal.php">Expired Deals ({$deal_notice_info_seller.tot_exp})</a></li>
		</ul>
	</li>

	<li> <a href="javascript:void(0);" {if $inmenu eq 'masters'} class="active" {/if}>Masters</a>
	       <ul class="SubNav">
			<li> <a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php">Manage Reviews and Ratings</a> </li>
		</ul>
	</li>

	<li> <a href="javascript:void(0);" {if $inmenu eq 'company'} class="active" {/if}>Tools</a>
		<ul class="SubNav">
			<li> <a href="{$siteroot}/admin/seller/login-log.php">Seller Login Log</a> </li>
		</ul>
		<ul class="SubNav">
			<li> <a href="{$siteroot}{$signouturl}">Sign Out</a> </li>
		</ul>
	</li>


{/if}-->
<!-- ///////////////////END Seller Menus/////////////////// -->

    </ul>
     <div class="clr"> </div>
   </div>
	{/if}
