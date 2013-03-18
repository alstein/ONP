<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
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
<script type="text/javascript">
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
<script type="text/javascript" src="{$sitejs}/jquery.validate.js"></script>
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
            if (OK = ((Year >= 1900) && (Year < new Date().getFullYear()))) {
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
{literal}
<script type="text/javascript" language="JavaScript">
    function search_by_category(category_id){
        $("#cat_ref").val(category_id);
        document.frmh.submit();
    }
    function category_view(category_id){
        $("#cat").val(category_id);
        document.frmc.submit();
    }
</script>
{/literal}
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
      <div ><p class="message_text">AgentRater requires a browser feature called JavaScript.
         All modern browsers support</p>
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


