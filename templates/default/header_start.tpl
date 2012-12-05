<!DOCTYPE HTML>
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
<script src="{$sitejs}/jquery-1.4.min.js" type="text/javascript" charset="utf-8"></script>
<!--<link rel="StyleSheet" href="{$sitejs}/facebox/facebox.css" type="text/css"/>
<script type="text/javascript" src="{$sitejs}/facebox/facebox.js"></script>-->



<script type="text/javascript" src="{$siteroot}/js/thick_js/thickbox.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="{$siteroot}/js/selectmenu.js"></script>
<script type="text/javascript" src="{$siteroot}/templates/default/css/test.htm"></script>


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


