<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- Website title -->

{if $row_meta.meta_title neq ""}
<title>{$row_meta.meta_title|replace:'[[USERNAME]]':$seoname}</title><!--$dealData-->
{else}
<title>{$sitetitle}</title>
{/if}

{if $row_meta.meta_tag_description neq ""}
<meta name="description" content="{$row_meta.meta_tag_description|replace:'[[DEAL_TITLE]]':$dealGBy.title}" />
{else}
<meta name="description" content="{$metades}" />
{/if}

{if $row_meta.meta_tag_keyword neq ""}
<meta name="keywords" content="{$row_meta.meta_tag_keyword|replace:'[[DEAL_TITLE]]':$dealGBy.title}" />
{else}
<meta name="keywords" content="{$metakeyword}" />
{/if}

<link href="{$siteroot}/templates/default/css/basic.css" rel="stylesheet" type="text/css">
<link href="{$siteroot}/templates/default/css/main.css" rel="stylesheet" type="text/css">
<link href="{$siteroot}/templates/default/css/thickbox.css" rel="stylesheet" type="text/css" />
<link href="{$siteroot}/templates/default/css/form.css" rel="stylesheet" type="text/css">
<link href="{$siteroot}/templates/default/css/code.css" rel="stylesheet" type="text/css">
<link href="{$siteroot}/templates/default/css/error_message.css" rel="stylesheet" type="text/css">
<link href="{$siteroot}/templates/default/css/css-tooltips.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/x-icon" href="{$siteroot}/favicon.ico" />

{literal}
<script language="JavaScript" type="text/javascript">
    document.createElement('div');
    document.createElement('aside'); document.createElement('figure'); document.createElement('footer'); document.createElement('header'); document.createElement('hgroup'); document.createElement('nav'); document.createElement('section'); document.createElement('figcaption'); 
</script>
{/literal}

{literal}
<script type="text/javascript">
	var SITEROOT = '{/literal}{$siteroot}{literal}';
	var TEMPLATEDIR = '{/literal}{$templatedir}{literal}';
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34416550-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
{/literal}

<script type="text/javascript" src="{$sitejs}/remote.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$sitejs}/validation/validateCustomerSignup.js"></script>
<script type="text/javascript" src="{$siteroot}/js/selectmenu.js"></script>
<script type="text/javascript" src="{$sitejs}/validation/home_login.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript" src="{$siteroot}/templates/default/css/test.htm"></script>
<script language="JavaScript" type="text/javascript">
{literal}
function isValidDate(value)
{
    try   
    {
		
        //Change the below values to determine which format of date you wish to check. It is set to dd/mm/yyyy by default.
        var DayIndex = 0;
        var MonthIndex = 1;
        var YearIndex = 2;
 
        value = value.replace(/-/g, "/").replace(/\./g, "/"); 
        var SplitValue = value.split("/");
        var OK = true;
        if (!(SplitValue[DayIndex].length == 1 || SplitValue[DayIndex].length == 2)) {
            OK = false;
        }
        if (OK && !(SplitValue[MonthIndex].length == 1 || SplitValue[MonthIndex].length == 2)) {
            OK = false;
        }
        if (OK && SplitValue[YearIndex].length != 4) {
            OK = false;
        }
        if (OK) {
            var Day = parseInt(SplitValue[DayIndex], 10);
            var Month = parseInt(SplitValue[MonthIndex], 10);
            var Year = parseInt(SplitValue[YearIndex], 10);
            if (OK = ((Year > 1900) && (Year < new Date().getFullYear()))) {
                if (OK = (Month <= 12 && Month > 0)) {
                    var LeapYear = (((Year % 4) == 0) && ((Year % 100) != 0) || ((Year % 400) == 0));
                    if (Month == 2) {
                        OK = LeapYear ? Day <= 29 : Day <= 28;
                    }
                    else {
                        if ((Month == 4) || (Month == 6) || (Month == 9) || (Month == 11)) {
                            OK = (Day > 0 && Day <= 30);
                        }
                        else {
                            OK = (Day > 0 && Day <= 31);
                        }
                    }
                }
            }
        }
        return OK;
    }
    catch (e) {
        return false;
    }
}
function validate()
{
	$("#frm").validate();
	
	if($("#frm").valid())
	{
            var name=document.getElementById("name").value;
            var lname=document.getElementById("lname").value;
            var email=document.getElementById("email").value;
            //var reenter_email=document.getElementById("reenter_email").value;
            var password=document.getElementById("password").value;
            var sel_gender=document.getElementById("sel_gender").value;
            var sel_dd=document.getElementById("sel_dd").value;
            var sel_yy=document.getElementById("sel_yy").value;

            date = $("#sel_dd").val() +"/"+$("#sel_mm").val()+"/"+$("#sel_yy").val(); 
            var vdat = isValidDate(date);
            if(vdat)
            {
				// $('#singup-box').css('margin-top','-96px');
				 //$('#title_name').html('SECOND STEP!');
				 $('#cateselect').css('width','400px');
				 $('.joinus').css('width','366px');
				 $('.joinus-row-1').css('width','374px');
				 $('#singup_first').hide();
				 
				 $('#cate_select').show();
				 
               //$("#frm").submit();
// 		window.location = SITEROOT+"/profileinfo/";
            }
            else
            {
                alert("Select proper birth date");
		return false;
            }
	}
        else
	{
          $("#frm").submit();
	}
}

$(document).ready(function() {
    $('a.login-window').click(function() {
		
        //Getting the variable's value from a link 
        var loginBox = $(this).attr('href');

        //Fade in the Popup
        $(loginBox).fadeIn(300);

        //Set the center alignment padding + border see css style
        var popMargTop = ($(loginBox).height() + 24) / 2; 
        var popMargLeft = ($(loginBox).width() + 24) / 2; 

        $(loginBox).css({ 
            'margin-top' : -popMargTop,
            'margin-left' : -popMargLeft
        });
		
        // Add the mask to body
        $('body').append('<div id="mask"></div>');
        $('#mask').fadeIn(300);
		
        return false;
    });
	
    // When clicking on the button close or the mask layer the popup closed
    $('a.close, #mask').live('click', function() { 
        $('#mask , .login-popup').fadeOut(300 , function() {
            $('#mask').remove();  
        }); 
        return false;
    });
});

// SINGUP POPUPBOX
$(document).ready(function() {
    $('a.singup-window').click(function() {

        //Getting the variable's value from a link 
        var loginBox = $(this).attr('href');

        //Fade in the Popup
        $(loginBox).fadeIn(300);

        //Set the center alignment padding + border see css style
        var popMargTop = ($(loginBox).height() + 24) / 2; 
        var popMargLeft = ($(loginBox).width() + 24) / 2; 

        $(loginBox).css({ 
            'margin-top' : -popMargTop,
            'margin-left' : -popMargLeft
        });

        // Add the mask to body
        $('body').append('<div id="mask"></div>');
        $('#mask').fadeIn(300);

        return false;
    });

    // When clicking on the button close or the mask layer the popup closed
    $('a.close, #mask').live('click', function() { 
        $('#mask , .singup-popup').fadeOut(300 , function() {
            $('#mask').remove();  
        }); 
        return false;
    });
    $('a.close, #mask').live('click', function() { 
        $('#mask , .cate-popup').fadeOut(300 , function() {
            $('#mask').remove();  
        }); 
        return false;
    });
});
{/literal}
</script>
</head>
<!-- js disabled -->
<div class="popupbg">
    <noscript>
        <link rel="StyleSheet" href="{$siteroot}/disablejs/jserror.css" type="text/css" media="screen" />
        <div class="massagewrpper">
            <div class="massag_bg">
                <p>JavaScript is disabled on your browser</p>
                <p>Please enable JavaScript or upgrade to a JavaScript-capable browser to use <a href="http://www.offersnpals.com">http://www.offersnpals.com</a></p>
            </div>
            <div class="massag_bg">
                <div><img alt="logo" src="{$siteroot}/templates/default/images/logo-new.png"/></div>
                <p>&nbsp;</p>
                <p>You need to change a setting in your web browser</p>
                <div>
                    <p class="message_text">AgentRater requires a browser feature called JavaScript. All modern browsers support</p>
                    <p class="message_text">JavaScript. You probably just need to change a setting in order to turn it on.</p>
                    <p class="message_text">Please see: <a href="http://www.google.com/support/bin/answer.py?answer=23852">How to enable JavaScript in your browser.</a></p>
                    <p class="message_text">Please see <strong>Minimum Browser Requirements below</strong></p>
                    <p class="message_text">The current minimum browser versions  supports are:</p>
                    <p class="message_text">Internet Explorer 7.0 and 8.0</p>
                    <p class="message_text">Firefox 3.5.X</p>
                    <p class="message_text">Mac Safari 4.0.x </p>
                    <p class="message_text">Chrome 3.0.x.x</p>
                    <p class="message_text">Having the most current version of Adobe Flash installed is also required (In some areas).</p>
                    <p class="message_text1">Other things to do if you find issues:</p>
                    <p class="message_text">Ensure that Javascript is enabled in your browser</p>
                    <p class="message_text">Clear your browser cache and restart your browser</p>
                    <p class="message_text">If you have the above settings and are having difficulty viewing any  pages, please email us </p>
                    <p class="message_text">on <a href="mailto:support@offersnpals.com">support@offersnpals.com</a> Send us your browser type and version, PC or Mac, and the </p>
                    <p class="message_text">links or screens you were trying to access.</p>
                    <p class="message_text">Thank you.</p>
                </div>
            </div>
            <div class="massag_btm">
                <div>&nbsp;</div>
            </div>
        </div>
    </noscript>
</div>

<!-- Header Starts -->
{literal}
<script type="text/javascript" language="JavaScript">
    function search_by_category(category_id){
        $("#cat_ref").val(category_id);
        document.frmh.submit();
    }
    function category_view(category_id){
        $("#cat_ref").val(category_id);
        document.frmc.submit();
    }
</script>
{/literal}
</head>
<!--//js disabled-->
{if $smarty.session.is_valid_browser eq '0'}
    {include file = $browser_info}
    {php}//exit;{/php}
{/if} 
<body id="inner-head">
<div style="position:fixed; background:#2e2f30; z-index:999; height:45px;border-bottom:1px solid #AFB9C5" class="fullwid">
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
                        <li><a href="#login-box" class="login-window"><strong>Login</strong></a></li>
                    </ul>
                </div>
            {/if}
        </div>
    </div>    
    <div class="clr"></div>
    <div id="subheader" class="submenu fr">
        <form name="frmc" id="frmc" action="{$siteroot}/deal/category_view" method="POST">
        <ul>
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