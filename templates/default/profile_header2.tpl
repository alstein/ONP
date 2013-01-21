{if $smarty.session.csUserTypeId neq ''}
    {literal}
        <script type="text/javascript" language="JavaScript">
        function search_by_category(category_id){
                $("#cat_ref").val(category_id);
                document.frmh.submit();
        }
        </script>
    {/literal}
    </head>
    {strip}
    <!--<script type="text/javascript" src="{$sitejs}/validation/login.js"></script>-->

    {/strip}

    <!--//js disabled-->
    {if $smarty.session.is_valid_browser eq '0'}

     {include file = $browser_info}

     {php}//exit;{/php}
    {/if} 

    <body id="inner-head">

    <div style="position:fixed; background:#2e2f30; z-index:1; height:43px;border-bottom:1px solid #AFB9C5" class="fullwid">
    <!-- main continer of the page -->
    <div id="header" {if $smarty.session.csUserTypeId eq '2'} style="width:1121px;height:45px !important;" {/if}>
        <div>
          <h1 id="inner-page-logo" class="fl"><a href="{$siteroot}">&nbsp;</a></h1>
            {if $smarty.session.csUserTypeId eq '2'}
        <form name="frm_search" id="frm_search" method="POST">
          <div class="fl search-bar fl">
              <input type="text" name="txt_search" id="txt_search" value="Search Friends"  onBlur="if(this.value=='')this.value='Search Friends'" onFocus="if(this.value=='Search Friends')this.value=''" style="color:#FFFFFF" class="fl"/>
              <a href="javascript:void(0);" class="maginifier fl" onClick="search_text();"></a>
          </div>
             </form>
            {/if}
          <div class="menu fr">
            <ul>
              <li><a href="{if $smarty.session.csUserTypeId eq '2'}{$siteroot}/my-account/my_profile_home{elseif $smarty.session.csUserTypeId eq '3'} {$siteroot}/merchant-account/merchant_profile_home{/if}"><span class="home">&nbsp;</span>Home<abbr class="arrow">&nbsp;</abbr></a></li>
              <li><a href="{if $smarty.session.csUserTypeId eq '2'}{$siteroot}/my-account/my_profile{elseif $smarty.session.csUserTypeId eq '3'} {$siteroot}/merchant-account/merchant_profile{/if}"><span class="user">&nbsp;</span>{$smarty.session.csFullName|substr:0:19}<abbr class="arrow">&nbsp;</abbr></a>
                <div class="dropdown">
                  <div class="dropdwon-arrow"></div>
                  <div class="dropdown-top"></div>
                  <div class="dropdown-mid">
                    <dl class="reset">
                      <dt><a href="{if $smarty.session.csUserTypeId eq '2'}{$siteroot}/editprofile{else}{$siteroot}/merchant-account/edit_merchant_profile/{/if}">Edit Profile</a></dt>
                                    {if $smarty.session.csUserTypeId eq '2'}
                      <dt><a href="{$siteroot}/change-profilepic" style="border:none">Change Profile Image</a></dt>
                                    {else if $smarty.session.csUserTypeId eq '3'}
                                            <dt><a href="{$siteroot}/merchant-account/edit_profile_picture" style="border:none">Change Profile Image</a></dt>
                                    {/if}
                                     <dt><a href="{$siteroot}/modules/logout/logout.php" style="border:none">Logout</a></dt>
                    </dl>
                    <div class="clr"></div>
                  </div>
                  <div class="dropdown-btm"></div>
                </div>
              </li>
              <li><a href="{$siteroot}/help/19/content"><span class="help">&nbsp;</span>Help<abbr class="arrow">&nbsp;</abbr></a></li>
                    {if $smarty.session.csUserTypeId eq '2'}
              <li><a href="javascript:void(0);"><span class="setting">&nbsp;</span>Setting<abbr class="arrow">&nbsp;</abbr></a>
                <div class="dropdown">
                  <div class="dropdwon-arrow"></div>
                  <div class="dropdown-top"></div>
                  <div class="dropdown-mid">
                    <dl class="reset">
                            <dt><a href="{$siteroot}/my-account/account_setting/">Account Setting</a></dt>


                    </dl>
                    <div class="clr"></div>
                  </div>
                  <div class="dropdown-btm"></div>
                </div>
              </li>
                    {/if}

            {if $smarty.session.csUserTypeId eq '2'}
              <li><a href="javascript:void(0);"><span class="setting">&nbsp;</span>Browse Merchants<abbr class="arrow">&nbsp;</abbr></a>
                <div class="dropdown">
                  <div class="dropdwon-arrow"></div>
                  <div class="dropdown-top"></div>
                  <div class="dropdown-mid">
                            <form name="frmh" id="frmh" action="{$siteroot}/merchant-account/view_search_merchant" method="POST">
                    <dl class="reset">
                                                    <input name="cat_ref[]" id="cat_ref" type="hidden">
                                                    {section name=i loop=$categoryh}

                                                        <dt><a href="javascript:void(0)" onclick="search_by_category({$categoryh[i].id})">{$categoryh[i].category}</a></dt>
                                                    {/section}


                    </dl>
                            </form>
                    <div class="clr"></div>
                  </div>
                  <div class="dropdown-btm"></div>
                </div>
              </li>
                    {/if}


            </ul>
          </div>
        </div>
        <div class="clr"></div>
      </div>
      </div>
    <div id="wrapper">
      <!-- Header starts -->


    {literal}
    <script language="JavaScript" type="text/javascript">
    function search_text()
    {
    var search_text=$('#txt_search').val();
    if(search_text == 'Search Friends')
    {
    $('#txt_search').val(' ');
    }
    else
    {
    $('#txt_search').val('Search Friends');
    }
    }
    </script>
    {/literal}
{else}
    <!--//js disabled-->
    {if $smarty.session.is_valid_browser eq '0'}
        {include file = $browser_info}
        {php}//exit;{/php}
    {/if} 
    <body id="inner-head">
    <div style="position:fixed; background:#030303; z-index:999; height:45px;border-bottom:1px solid #AFB9C5" class="fullwid">
        <!-- main continer of the page -->
        <div id="header" {if $smarty.session.csUserTypeId eq '2'} style="width:1121px;" {/if}>
            <div>
                <h1 id="inner-page-logo" class="fl"><a href="{$siteroot}">&nbsp;</a></h1>
                {if $smarty.session.csUserTypeId neq ''}
                {if $smarty.session.csUserTypeId eq '2'}
                    <form name="frm_search" id="frm_search" method="POST">
                        <div class="fl search-bar fl">
                            <input type="text" name="txt_search" id="txt_search" value="Search Friends"  onBlur="if(this.value=='')this.value='Search Friends'" onFocus="if(this.value=='Search Friends')this.value=''" style="color:#FFFFFF" class="fl"/>
                            <a href="javascript:void(0);" class="maginifier fl" onClick="search_text();"></a>
                        </div>
                    </form>
                {/if}
                <div class="menu fr">
                    <ul>
                        <li><a href="{if $smarty.session.csUserTypeId eq '2'}{$siteroot}/my-account/my_profile_home{elseif $smarty.session.csUserTypeId eq '3'} {$siteroot}/merchant-account/merchant_profile_home{/if}"><span class="home">&nbsp;</span>Home<abbr class="arrow">&nbsp;</abbr></a></li>
                        <li>    
                            <a href="{if $smarty.session.csUserTypeId eq '2'}{$siteroot}/my-account/my_profile{elseif $smarty.session.csUserTypeId eq '3'} {$siteroot}/merchant-account/merchant_profile{/if}"><span class="user">&nbsp;</span>{$smarty.session.csFullName|substr:0:19}<abbr class="arrow">&nbsp;</abbr></a>
                            <div class="dropdown">
                                <div class="dropdwon-arrow"></div>
                                <div class="dropdown-top"></div>
                                <div class="dropdown-mid">
                                    <dl class="reset">
                                        <dt><a href="{if $smarty.session.csUserTypeId eq '2'}{$siteroot}/editprofile{else}{$siteroot}/merchant-account/edit_merchant_profile/{/if}">Edit Profile</a></dt>
                                        {if $smarty.session.csUserTypeId eq '2'}
                                        <dt><a href="{$siteroot}/change-profilepic" style="border:none">Change Profile Image</a></dt>
                                        {else if $smarty.session.csUserTypeId eq '3'}
                                        <dt><a href="{$siteroot}/merchant-account/edit_profile_picture" style="border:none">Change Profile Image</a></dt>
                                        {/if}
                                        <dt><a href="{$siteroot}/modules/logout/logout.php" style="border:none">Logout</a></dt>
                                    </dl>
                                    <div class="clr"></div>
                                </div>
                                <div class="dropdown-btm"></div>
                            </div>
                        </li>
                        <li><a href="{$siteroot}/help/19/content"><span class="help">&nbsp;</span>Help<abbr class="arrow">&nbsp;</abbr></a></li>
                        {if $smarty.session.csUserTypeId eq '2'}
                        <li>
                            <a href="javascript:void(0);"><span class="setting">&nbsp;</span>Setting<abbr class="arrow">&nbsp;</abbr></a>
                            <div class="dropdown">
                                <div class="dropdwon-arrow"></div>
                                <div class="dropdown-top"></div>
                                <div class="dropdown-mid">
                                    <dl class="reset">
                                        <dt><a href="{$siteroot}/my-account/account_setting/">Account Setting</a></dt>
                                    </dl>
                                    <div class="clr"></div>
                                </div>
                                <div class="dropdown-btm"></div>
                            </div>
                        </li>
                        {/if}
                        {if $smarty.session.csUserTypeId eq '2'}
                        <li>
                            <a href="javascript:void(0);"><span class="setting">&nbsp;</span>Browse Merchants<abbr class="arrow">&nbsp;</abbr></a>
                            <div class="dropdown">
                                <div class="dropdwon-arrow"></div>
                                <div class="dropdown-top"></div>
                                <div class="dropdown-mid">
                                    <form name="frmh" id="frmh" action="{$siteroot}/merchant-account/view_search_merchant" method="POST">
                                    <dl class="reset">
                                        <input name="cat_ref[]" id="cat_ref" type="hidden">
                                        {section name=i loop=$categoryh}
                                        <dt><a href="javascript:void(0)" onclick="search_by_category({$categoryh[i].id})">{$categoryh[i].category}</a></dt>
                                        {/section}
                                    </dl>
                                    </form>
                                    <div class="clr"></div>
                                </div>
                                <div class="dropdown-btm"></div>
                            </div>
                        </li>
                        {/if}
                    </ul>
                </div>
                {else}
                    {include file=$login}
                    {include file=$signup}
                    <!--<form name="frm_search" id="frm_search" method="POST">
                        <div class="search-bar fl">
                            <input type="text" name="txt_search" id="txt_search" value="Search Friends"  onBlur="if(this.value=='')this.value='Search Friends'" onFocus="if(this.value=='Search Friends')this.value=''" style="color:#FFFFFF" class="fl"/>
                            <a href="javascript:void(0);" class="maginifier fl" onClick="search_text();"></a>
                        </div>
                    </form>-->
                <div class="menu fr">
                    <ul>
                        <li><a href="#login-box" class="login-window" style="padding:4px 0px !important;background:transparent !important;"><img src="{$siteroot}/templates/default/images/login.png" /></a></li>
                        <li><a href="{$siteroot}/registration/merchant_reg_profileinfo" style="padding:3px 0px !important;background:transparent !important;"><img src="{$siteroot}/templates/default/images/local-business-button.png" /></a></li>
                    </ul>
                </div>
                {/if}
            </div>
        </div>    
        <div class="clr"></div>
        <div id="subheader" class="submenu fr">
            <form name="frmc" id="frmc" action="{$siteroot}/deal/category_view" method="POST">
            <ul>
                <input name="cat" id="cat" type="hidden">
                {foreach item=rootcat from=$categories}
                <li>
                    <a href="javascript:void(0);" onclick="category_view({$rootcat.id})">{$rootcat.category}</a>
                    <!--<div class="dropdown">
                        <div class="dropdwon-arrow"></div>
                        <div class="dropdown-top"></div>
                        <div class="dropdown-mid">
                            <dl class="reset">
                                <input name="cat_ref[]" id="cat_ref" type="hidden">
                                {foreach item=subcats from=$rootcat.subcats}
                                <dt>
                                <a href="javascript:void(0)" onclick="category_view({$subcats.id})">{$subcats.category}</a>
                                </dt>
                                {/foreach}
                            </dl>
                            </form>
                            <div class="clr"></div>
                        </div>
                        <div class="dropdown-btm"></div>
                    </div>-->
                </li>
                {/foreach}
            </ul>
            </form>
        </div>
    </div>
    <div class="clr"></div>
    <div id="wrapper">
    <!-- Header starts -->

    {literal}
    <script language="JavaScript" type="text/javascript">
    function search_text()
    {
    var search_text=$('#txt_search').val();
    if(search_text == 'Search Friends')
    {
    $('#txt_search').val(' ');
    }
    else
    {
    $('#txt_search').val('Search Friends');
    }
    }
    </script>
    {/literal}

    <!-- Header Ends -->
{/if}