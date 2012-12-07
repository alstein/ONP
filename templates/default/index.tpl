<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>OffersnPals</title>
<link href="{$siteroot}/templates/default/css/main.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="{$siteroot}/favicon.ico" />
<!-- FOR COMBO BOX -->
<script type="text/javascript" src="{$siteroot}/js/jquery.js"></script>
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.js"></script>
<script type="text/javascript" src="{$siteroot}/js/selectmenu.js"></script>
<script type="text/javascript" src="{$sitejs}/validation/validateCustomerSignup.js"></script>
<script type="text/javascript" src="{$sitejs}/validation/home_login.js"></script>
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
            var reenter_email=document.getElementById("reenter_email").value;
            var password=document.getElementById("password").value;
            var sel_gender=document.getElementById("sel_gender").value;
            var sel_dd=document.getElementById("sel_dd").value;
            var sel_yy=document.getElementById("sel_yy").value;

            date = $("#sel_dd").val() +"/"+$("#sel_mm").val()+"/"+$("#sel_yy").val(); 
            var vdat = isValidDate(date);
            if(vdat)
            {
                $("#frm").submit();
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
{/literal}	
</script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
{literal}
<script language="JavaScript" type="text/javascript">
    jQuery(document).ready(function()
    {
	var id1= '{/literal}{if  $smarty.get.id1 neq ''}{$smarty.get.id1}{else}0{/if}{literal}'
	if(id1 =='1')
	{
            var answer = confirm("This is private testing version of OffersnPals.com and by entering this site you agree that  OffersnPals.com and Alstein Pte Ltd would not be liable for any damage, whatsoever, resulting from using the site")
            if (answer)
            {
                window.location = SITEROOT+"/welcome/";
            }
            else
            {
// 				window.location = SITEROOT;
                window.location = SITEROOT+"/welcome/";
            }
        }
    });
</script>

{/literal}

<!-- FOR COMBO BOX -->

</head>

<body {if $slide_image_id1 eq '9'} class="back-bg1" {elseif $slide_image_id1 eq '1'} class="back-bg2" {elseif $slide_image_id1 eq '2'} class="back-bg3" {elseif $slide_image_id1 eq '3'} class="back-bg4" {elseif $slide_image_id1 eq '4'} class="back-bg5" {elseif $slide_image_id1 eq '5'} class="back-bg6" {elseif $slide_image_id1 eq '6'} class="back-bg7" {elseif $slide_image_id1 eq '7'} class="back-bg8" {elseif $slide_image_id1 eq '8'} class="back-bg9" {/if} >

<div id="wrapper">
    <!-- RIGHT SECTION -->
    <div class="right-section">
        <div class="right-bg">
            <div class="right-wrap">
                <!-- LOGO  -->
                <div class="logo"><a href="{$siteroot}"></a></div>
                <!-- LOGO  -->
                <div class="clr-bth" >&nbsp;</div>
                <!-- MEMBER SIGNIN -->
                <div class="member-signin">
                    <div class="member-signin-title"> 
                        Already a Member?<br />
                        <strong>MEMBER SIGN IN</strong> 
                    </div>
                    <div class="signin">
                        <form name="frm1" id="frm1" method="POST">
                            <div class="row-1">
                                <input type="hidden" name="siteroot" id="siteroot" value="{$siteroot}" />
                                <label style="text-align:right;">Email :</label>
                                <div class="row-1-txtbox-bg">
                                    <input type="text" class="row-1-txtbox" name="lemail" id="lemail"/>
                                    <div for="lemail" generated="true" class="error"></div>
                                </div>
                                <div class="clr-bth"></div>
                            </div>
                            <div class="row-1">
                                <label>Password :</label>
                                <div class="row-1-txtbox-bg">
                                    <input type="password" class="row-1-txtbox" id="lpassword" name="lpassword"/>
                                    <div for="lpassword" generated="true" class="error"></div>
                                    <a href="{$siteroot}/forgotpassword"><em>Forgot your password?</em></a> <br />
                                    <div style="margin-left:15px;">
                                        <span class="login-btn-lft">
                                            <span class="login-btn-rgt">
                                                <input type="submit" name="submit_login" id="submit_login" value="Login" class="login-btn">
                                            </span>
					</span>
                                    </div>
                                </div>
                                <div class="clr-bth">&nbsp;</div>
                            </div>
                        </form>
                        <!-- FACEBOOK -->
			<br /><br /> <br /> 
                        <div style="text-align:center; color:#FFFFFF;"><br />or<br />
                            <div id="fb-root" ></div>
                            {literal}
                            <script>
    // 					window.fbAsyncInit = function() {
                                FB.init({
                                        appId      : '468889599797776',
                                        status     : true,
                                        cookie     : true,
                                        xfbml      : true
                                });
    // 					};
                                (function(d){
                                    var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
                                    js = d.createElement('script'); js.id = id; js.async = true;
                                    js.src = "//connect.facebook.net/en_US/all.js";
                                    d.getElementsByTagName('head')[0].appendChild(js);
                                }(document));
                            </script>
                            <script>
                                function fbLogin()
                                {
                                    FB.login(function(response) {
                                        if (response.authResponse) {
                                            var accessToken = response.authResponse.accessToken;
                                            var SITEROOT='{/literal}{$siteroot}{literal}';
                                            jQuery.post(SITEROOT+"/fb.php",'',function(data){
                                                window.location= SITEROOT+"/my-account/my_profile_home";
                                            });
                                        } else {
                                            return false;
                                        }
                                    },{scope: 'email'});
                                }
                            </script>
                            {/literal}
                            <br />
                            <a href="javascript:void(0)" ><img  onclick="fbLogin();" src="{$siteroot}/includes/facebook/Connect_with_facebook_iphone.png"></a>
                        </div>
                        <!-- FACEBOOK -->
                        <div class="clr-bth"></div>
                    </div>
                </div>
                <!-- MEMBER SIGNIN -->
                <!-- DIVIDER -->
                <div style="width:302px; margin:15px auto;">
                    <img src="{$siteroot}/templates/default/images/right-divider.png" />
                </div>
                <!-- DIVIDER -->
                <!-- JOIN US -->
		<div class="member-signin-title"> 
                    New to Us? <br />
                    <strong>JOIN US NOW!</strong> 
		</div>
                <form name="frm" id="frm" method="POST">
                    <div class="joinus">
                        <div class="joinus-row-1">
                            <label style="text-align:right; width:85px;">First Name:</label>
                            <div class="joinus-row-1-txtbox-bg">
                                <input type="text" class="row-1-txtbox" name="name" id="name" value="{$name}" />
                            </div>
                            <div class="clr-bth"></div>
                        </div>
                        <div class="joinus-row-1">
                            <label style="text-align:right;">Last Name:</label>
                            <div class="joinus-row-1-txtbox-bg">
                                <input type="text" class="row-1-txtbox" id="lname" name="lname" value="{$lname}" />
                            </div>
                            <div class="clr-bth"></div>
                        </div>
                        <div class="joinus-row-1">
                            <label style="text-align:right;">Email:</label>
                            <div class="joinus-row-1-txtbox-bg">
                                <input type="text" class="row-1-txtbox" id="email" name="email" value="{$email}" />
                                {if $email_exist eq "1"}
                                    <div id="emailmsg" class="error">Email already exist.</div>
                                {/if}
                            </div>
                            <div class="clr-bth"></div>
                        </div>
                        <div class="joinus-row-1">
                            <label style="text-align:right;">Password:</label>
                            <div class="joinus-row-1-txtbox-bg">
                                <input type="password" class="row-1-txtbox" id="password" name="password"/>
                            </div>
                            <div class="clr-bth"></div>
                        </div>
                        <div class="joinus-row-1">
                            <label style="text-align:left;">Re-type Password:</label>
                            <div class="joinus-row-1-txtbox-bg">
                                <input type="password" class="row-1-txtbox" id="reenter_pass" name="reenter_pass"/>
                                <div htmlfor="reenter_pass" generated="true" class="error" style="display: block; width: 231px;"></div>
                            </div>
                            <div class="clr-bth"></div>
                        </div>
                        <div class="joinus-row-1">
                            <label style="text-align:right;">I am:</label>
                            <div class="joinus-row-1-txtbox-bg" style="background:none;" >
                                <div class="joinus-row-1-txtbox-bg i-am-txtbox-bg" style="background:none;">
                                    <!-- I AM -->
                                    <div class="i-am-combox-select">
					<select name="sel_gender" id="sel_gender" class="select" style="height:16px; width:70px">
                                            <option value="male" {if $gender eq 'male'} selected="selected" {/if}>Male</option>
                                            <option value="female" {if $gender eq 'female'} selected="selected" {/if}>Female</option>
					</select>
                                    </div>
                                    <!-- I AM -->
                                </div>
                            </div>
                            <div class="clr-bth"></div>
                        </div>
                        <div class="joinus-row-1">
                            <label style="text-align:right; width:85px;">Birthday:</label>
                            <div class="joinus-row-1-txtbox-bg" style="background:none;" >
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="50" align="left" valign="middle">
                                            <div class="day-bg">
                                                <!-- DAY -->
                                                <div class="day-select">
                                                    <select name="sel_dd" id="sel_dd" class="select" >
                                                        <option value="">DD</option>
                                                        {section name=day start=1 loop=32 step=1}
                                                            <option value="{$smarty.section.day.index}"  {if $sel_dd eq $smarty.section.day.index} selected="selected" {/if} >{$smarty.section.day.index}</option>
                                                        {/section}
                                                    </select>
                                                </div>
                                                <!-- DAY -->
                                            </div>
                                        </td>
                                        <td width="72" align="left" valign="middle">
                                            <div class="month-bg">
                                                <!-- MONTH -->
                                                <div class="month-select">
                                                    <select name="sel_mm" id="sel_mm" class="select" >
                                                        <option value="">MM</option>
							{section name=month start=1 loop=13 step=1}
                                                        <option value="{$smarty.section.month.index}" {if $sel_mm eq $smarty.section.month.index} selected="selected" {/if}>{$smarty.section.month.index}</option>
                                                        {/section}
                                                    </select>
                                                </div>
                                                <!-- MONTH -->
                                            </div>
                                        </td>
                                        <td width="58" align="left" valign="middle">
                                            <div class="year-bg">
                                                <!-- YEAR -->
                                                <div class="year-select">
                                                    <select name="sel_yy" id="sel_yy" class="select" >
                                                        <option value="">YYYY</option>
                                                        {section name=year start=1900 loop=$year step=1}
                                                        <option value="{$smarty.section.year.index}" {if $sel_yy eq $smarty.section.year.index} selected="selected" {/if}>{$smarty.section.year.index}</option>
                                                        {/section}
                                                    </select>
                                                </div>
                                                <!-- YEAR -->
                                            </div>
                                        </td>
                                    </tr>
                                    <TR><td colspan="2"><div for="sel_yy" generated="true" class="error"></div></td></TR>
                                </table>
                            </div>
                            <div class="clr-bth"></div>
                        </div>
                        <div class="row-1">
                            <label> </label>
                            <div class="row-1-txtbox-bg" style="background:none;margin-top:15px;">
                                <div style="margin-left:15px;">
                                    <span class="login-btn-lft">
                                        <span class="login-btn-rgt"><input type="submit" name="submit" id="submit" value="SIGN UP" class="login-btn"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="clr-bth"></div>
                        </div>
                        <div class="clr-bth"></div>
                    </div>
                </form>
                <!-- JOIN US -->
		<div class="clr-bth">&nbsp;</div>
		<!-- FOOTER -->
		<div class="footer">
                    Talk to Us? Here you go: <em> <a href="mailto:we_listen@alsteincorp.com" style="color:#F9532C;font-style:normal;">we_listen@alsteincorp.com</a></em>
                    <br />
                    © 2012 <a href="#">Alstein Pte Ltd</a>. All Rights Reserved.		
		</div>
		<!-- FOOTER -->
                <div class="clr-bth"></div>
            </div>
            <div class="clr-bth"></div>
        </div>
    </div>
    <!-- RIGHT SECTION -->
    <!-- LEFt SECTION -->
    <div class="left">
        <!-- BUTTON -->
        <div class="local-business">
            <a href="{$siteroot}/registration/merchant_reg_profileinfo"><img src="{$siteroot}/templates/default/images/local-business-button.png" /></a>
        </div>
        <!-- BUTTON -->
        <!-- GIVE YOU -->
        <div class="give-you-txt">
            Gives You Ownership of <br /> 
            Your Discount Shopping AND<br /> 
            Helps You in Sharing Offers, Reviews<br /> 
            and Experiences with Friends
            <br /> 
            <strong><a href="{$siteroot}/help/19/content/">Learn More</a></strong>
        </div>
        <!-- GIVE YOU -->
        <!-- BUSINESS BOX -->
        <div class="box">
            <!-- BOX 1 -->
            <div class="box-1-bg">
                <div class="box-1-bg-wrap">
                    <div class="box-1-left">
                        <strong>Businesses</strong><br />
                        Create offers on your own terms.
                    </div>
                    <div class="box-1-right">
                         <img src="{$siteroot}/templates/default/images/business-icon.png" />
                    </div>
                </div>
            </div>
            <!-- BOX 1 -->
            <!-- BOX 2 -->
            <div class="box-1-bg">
                <div class="box-1-bg-wrap">
                    <div class="box-1-left">
                        <strong>Consumers</strong><br />
                        Give offers to your favorite local 
                        businesses.
                    </div>
                    <div class="box-1-right">
                         <img src="{$siteroot}/templates/default/images/consumer-icon.png" />
                    </div>
                </div>
            </div>
            <!-- BOX 2 -->
            <!-- BOX 3 -->
            <div class="box-1-bg">
                <div class="box-1-bg-wrap">
                    <div class="box-1-left">
                        <strong>Community</strong><br />
                        Share offers,views &amp; experiences 
                        with friends
                    </div>
                    <div class="box-1-right">
                         <img src="{$siteroot}/templates/default/images/community-icon.png" />
                    </div>
                </div>
            </div>
            <!-- BOX 3 -->
            <div class="clr-bth">&nbsp;</div>
        </div>
        <!-- BUSINESS BOX -->
        <div class="clr-bth">&nbsp;</div>
    </div>
    <!-- LEFT SECTION -->
    <div class="footer-links">
        <div id="menu2">
            <ul>
                <li><a href="{$siteroot}/help/19/content/">Help</a></li>
                <li><a href="{$siteroot}/blog" target="_blank">Blog </a></li>
                <li><a href="{$siteroot}/faq/faq-consumer/">FAQ</a></li>
                <li><a href="{$siteroot}/privacy-policy">Privacy </a></li>
                <li><a href="{$siteroot}/terms">Terms</a></li>
                <li> <a href=" https://www.twitter.com/OffersnPals"  target="_blank"><img src="{$siteroot}/templates/default/images/tw.png" /></a>  </li>
                <li> <a href="https://facebook.com/OffersnPals" target="_blank"><img src="{$siteroot}/templates/default/images/fb.png" /></a></li>
                <!-- <li><a href="{$siteroot}/contact-us" style="border-right:0px;">Contact Us</a></li>-->
                <!--<li><a href="#" class="nodivdr">Contact Us</a></li>-->
            </ul>
        </div>
    </div>
</div>
</body>
</html>