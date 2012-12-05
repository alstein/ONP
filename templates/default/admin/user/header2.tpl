</head>
<body> 
<div id="mainWrapper">
<div id="header">
	<div class="topLinkBg ar">
		<p>
		{if $smarty.session.admLgn ne ""}{$smarty.session.duAdmFname}
          [Administrator] | <a href="{$siteroot}/admin/login/signout.php">LogOut</a>{else}Welcome To {$sitetitle} Please Login{/if}
		</p>
  </div>
  <div id="logo">
		<div class="fl ar"><h2 class="padOne"><a href="{$siteroot}/admin/index.php">
		<img src="{$siteroot}/templates/default/images/logo.png"  /></a></h2></div>
		<div class="clr"></div>
  </div>
  <div class="clr"></div>
 
</div>
<div class="topcorner">&nbsp;</div>
<div id="maincont">
<div class="bgWht padOne">
 {if $smarty.session.duAdmId}
  <div style="float:left; width:193px">
    <ul id="nav" class="menu">
        <li> <a href="javascript:;" {if $inmenu eq 'networks'} class="active"{/if}>Members</a>
            <ul class="SubNav">
                 <li> <a href="{$siteroot}/admin/user/manage_admin.php">Admin User</a></li>
                <li> <a href="{$siteroot}/admin/user/users_list.php">Buyer User</a></li>
                 <li> <a href="{$siteroot}/admin/user/seller_list.php">Seller User</a></li>
                 <!--<li> <a href="{$siteroot}/admin/user/delusers_list.php">Deleted User list</a></li>-->
            </ul>
        </li>
        <li> <a href="#">Deal Management</a>
            <ul class="SubNav">
             <li> <a href="{$siteroot}/admin/category/category_list.php">Deal Category</a></li>
             
                <li> <a href="{$siteroot}/admin/globalsettings/deal/add_product.php">Add New Deal</a> </li>
		<li> <a href="{$siteroot}/admin/globalsettings/deal/view-deal.php">Deals to be reviewed</a> </li>
		 <li> <a href="{$siteroot}/admin/globalsettings/deal/pending-deal.php">Pending Deals</a> </li>
		<li> <a href="{$siteroot}/admin/globalsettings/deal/manage_deal.php">Active Deals</a></li>	
                <li> <a href="{$siteroot}/admin/globalsettings/deal/manage_complete_deal.php">Completed Deal</a> </li>
                <li> <a href="{$siteroot}/admin/globalsettings/deal/In-demand.php">In Demand</a></li>
		<li> <a href="{$siteroot}/admin/globalsettings/deal/demand-request.php">Demand Request</a></li>
		 <li> <a href="{$siteroot}/admin/globalsettings/deal/rejected-deals.php">Rejected Deals</a> </li>
<!--		<li> <a href="{$siteroot}/admin/globalsettings/deal/deal-purchase.php">Deal Purchase</a></li>
		<li> <a href="{$siteroot}/admin/globalsettings/deal/deal-order.php">Deal Order</a></li>-->
            </ul>
        </li>
        <li> <a href="javascript:;" {if $inmenu eq 'search'} class="active"{/if}>Contents</a>
            <ul class="SubNav">
                <li> <a href="{$siteroot}/admin/contentpages/page_list.php">Manage Pages</a> </li>
                <li> <a href="{$siteroot}/admin/msg/msg_list.php">Manage error message</a> </li>

            </ul>
        </li>

        <li> <a href="javascript:;" {if $inmenu eq 'gsetting'}class="active"{/if}>Global Settings</a>
            <ul class="SubNav">
                <li> <a href="{$siteroot}/admin/globalsettings/system_emails.php">System Emails</a> </li> 
                <li> <a href="{$siteroot}/admin/globalsettings/Sitemaster-List.php">Site settings</a> </li> 
                <li> <a href="{$siteroot}/admin/globalsettings/message-center/nlcontent.php">Manage message content</a> </li>
                <li> <a href="{$siteroot}/admin/globalsettings/message-center/send_message.php">Send message</a> </li>
                <li> <a href="{$siteroot}/admin/mastermanagement/undermaintenance.php">Under Maintenance Page</a> </li>
            </ul>
        </li>

        <li> <a href="#">Masters</a>
            <ul class="SubNav">
                <li> <a href="{$siteroot}/admin/city/city_list.php">City</a></li>
                <li> <a href="{$siteroot}/admin/modules/faq/faq_list.php">FAQ</a></li>
                <li> <a href="{$siteroot}/admin/modules/faq/faqcategory_list.php">FAQ category</a></li>
                 <li> <a href="{$siteroot}/admin/modules/banner/banner_list.php">Advertisement</a></li>
                 <li> <a href="{$siteroot}/admin/mastermanagement/security_question_list.php">Manage Secret Question</a></li>
                 <li> <a href="{$siteroot}/admin/modules/ipban/ipban.php">IP Ban</a></li>
            </ul>
        </li>

	<li> <a href="#">Seller type manage</a>
            <ul class="SubNav">
                <li> <a href="{$siteroot}/admin/seller/seller-type-list.php">Seller type</a></li>
                <li> <a href="{$siteroot}/admin/seller/seller-type-option-list.php">Manage seller type option</a></li>

            </ul>

        <li> <a href="javascript:;" {if $inmenu eq 'gsetting'}class="active"{/if}>Modules</a>
            <ul class="SubNav">
                <li> <a href="{$siteroot}/admin/modules/discussion/categories.php">Forum Categories</a> </li>
                <li> <a href="{$siteroot}/admin/modules/forum/index.php">Forum Topics</a> </li>
               <li> <a href="{$siteroot}/admin/modules/feedback/feedback.php">Feedback</a> </li>
               <li> <a href="{$siteroot}/admin/modules/user-message/user-message.php">User Messages</a> </li>
                <li> <a href="{$siteroot}/admin/modules/news/news-list.php">News</a> </li>
             </ul>
        </li>

     
     <li> <a href="#">Payments</a>
            <ul class="SubNav">
            <li> <a href="{$siteroot}/admin/mastermanagement/payment_setting.php">Payment Gateway</a></li>
         </ul>
        </li>
        
        <!--<li> <a href="javascript:;" {if $inmenu eq 'admin'} class="active1"{/if}>Deal Management</a>
            <ul class="SubNav">
                <li> <a href="{$siteroot}/admin/mastermanagement/dealcategory_list.php">Deal Category</a> </li>
            </ul>
        </li>-->
        <li> <a href="javascript:;" {if $inmenu eq 'company'} class="active" {/if}>Tools</a>
            <ul class="SubNav">
                <li> <a href="{$siteroot}/admin/login/admin-login-log.php">Admin Login Log</a> </li>
                <li> <a href="{$siteroot}/admin/login/user-login-log.php">User Login Log</a> </li>
                <li> <a href="{$siteroot}/admin/login/signout.php">Sign Out</a> </li>
            </ul>
        </li>
    </ul>
     
     <div class="clr"> </div>
   </div>
   {/if}
