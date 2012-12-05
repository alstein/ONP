</head>
<body >

{literal}
<script language="JavaScript" type="text/javascript">
			$(document).ready(function(){
			$('a[href*=#]').click(function() {
				if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
				&& location.hostname == this.hostname) {
					var $target = $(this.hash);
					$target = $target.length && $target
					|| $('[name=' + this.hash.slice(1) +']');
					if ($target.length) {
					var targetOffset = $target.offset().top;
					$('html,body')
					.animate({scrollTop: targetOffset}, 1000);
					return false;
					}
				}
			});
				setInterval("updateTimes()",1000);
		 		
			});
			var cdArray = new Array();
			var idArray = new Array();
			function registerCountdown(enddate,divID) {
				 //alert(enddate+" "+divID);
				var divID = "cd_"+divID;
// 2010-11-20 20:00:59
				var time = enddate.substr(enddate.indexOf(" "));
				var dateParts = enddate.substr(0,enddate.indexOf(" ")).split("-");
					
				// var endDateTime = Date.parse(enddate.substr(0,enddate.indexOf(" ")));
				var endDateTime = new Date();
				endDateTime.setFullYear(dateParts[0]);
                               if(dateParts[1]==02)
                                {
                                    if((dateParts[0]%4==0) || (dateParts[0]%100!=0 && dateParts[0]%400==0))
                                        {
                                        var feb=29;
                                        }
                                        else
                                        {
                                         var feb=28;
                                        }
                                endDateTime.setMonth(dateParts[1]);
                                endDateTime.setDate(dateParts[2]-feb);
                                }else{ 
                               
				endDateTime.setMonth(dateParts[1]-1);
				endDateTime.setDate(dateParts[2]);
                                }
				endDateTime.setHours(0);
				endDateTime.setMinutes(0);
				endDateTime.setSeconds(0);
				var timeParts = time.split(":");
				var time2 = 1000 * (Number(timeParts[0] * 60 * 60) + Number(timeParts[1]  * 60) + Number(timeParts[2])) + Number(endDateTime);
				var myDate = new Date();
				 myDate.setTime(time2);
				//alert(myDate);
				cdArray[divID] = myDate;
				idArray.push(divID);
				// cdArray[
				// alert(idArray.length+" "+idArray[idArray.length-1]+" "+$(divID).html());
				
			}
			function updateTimes() {
				for(var i=0;i<idArray.length;i++) {
					var cdID = idArray[i];
					var curDate = new Date();
					var diff = cdArray[cdID].getTime() - curDate.getTime();
					var days = Math.floor(diff/(24 * 60 * 60 * 1000));
					diff = diff - days * 24 * 60 * 60 * 1000;
					var hours = Math.floor(diff/(60 * 60 * 1000));
					if (hours < 10)  hours = String("0"+hours.toString());
					diff = diff - hours * 60 * 60 * 1000;
					var mins = Math.floor(diff/(60 * 1000));
					if (mins < 10)  mins = String("0"+mins.toString());
					diff = diff - mins * 60 * 1000;
					var secs = Math.floor(diff/1000);
					if (secs < 10)  secs = String("0"+secs.toString());
					diff = diff - secs * 1000;
					
                                    
					
				 	$("#"+cdID).html("<div class='fl datecol'><div class='datebg'>"+days+"</div>days</div><div class='fl datecol'><div class='datebg'>"+hours+"</div>hr</div><div class='fl datecol'><div class='datebg'>"+mins+"</div>min</div><div class='fl datecol'><div class='datebg'>"+secs+"</div>sec</div>");
                                        //alert(cdID);
				 //	$("#"+cdID).html("CLOSES IN "+cdArray[cdID]);
                                        if(days == 0 && hours == 0 && mins == 0 && secs == 0)
                                        {
                                        window.location.reload(true);
                                        }
				}
			}
	
		
	</script>
{/literal}
<!--<input type="hidden" name="curdate" id="curdate" value="{$currant}">
<input type="hidden" name="offs" id="offs" value="{$d}">-->
<div style="background:#000; width:100%">
	<div style="width:950px; display:none; color:#fff; margin:0 auto; " id="howitworks">
    <div class="hiwitworktitle allCaps">How it Works</div>
    <div class="steps">
    	<ul class="reset stepslist">
        	<li class="steps1" onMouseOver="javascript:howItWorks();" id="s1">
            	<div class="step1img">&nbsp;</div>
            	<div class="steps1desc">
                	<h2>step 1</h2>
                    <p>
                    	Join Group Buy It and Find Your Bargain
                    </p>
                </div>
            </li>
            <li class="steps2" onMouseOver="howItWorks1()" id="s2"> 
            	<div class="step1img">&nbsp;</div>
            	<div class="steps1desc">
                	<h2>step 2</h2>
                    <p>
                    	Sharing Is Caring
                    </p>
                </div>
            </li>
            <li class="steps3" onMouseOver="javascript:howItWorks2()" id="s3">
            	<div class="step1img">&nbsp;</div>
            	<div class="steps1desc">
                	<h2>step 3</h2>
                    <p>
                    	Completing Your Purchase
                    </p>
                </div>
            </li>
            <li class="steps4" onMouseOver="javascript:howItWorks3()" id="s4">
            	<div class="step1img">&nbsp;</div>
            	<div class="steps1desc">
                	<h2>step 4</h2>
                    <p>
                    	Enjoy Your Purchase
                    </p>
                </div>
            </li>
        </ul>
    </div>
   <!-- <h4 style="font-size:20px; line-height:36px;color:#87B400; font-weight:normal; font-family:Arial, Helvetica, sans-serif">{$howit->title} </h4>-->
                                <div class="step1" id="step1" style="font-size:12px; line-height:16px; padding-bottom:10px; margin-top:10px; display:block">
 {$howit->description|html_entity_decode|stripslashes}</div>
 <div class="step2" id="step2" style="font-size:12px; line-height:16px; padding-bottom:10px; margin-top:10px; display:none">
 {$howit1->description|html_entity_decode|stripslashes}</div>
 <div class="step3" id="step3" style="font-size:12px; line-height:16px; padding-bottom:10px; margin-top:10px; display:none">
 {$howit2->description|html_entity_decode|stripslashes}</div>
    <div class="step4" id="step4" style="font-size:12px; line-height:16px; padding-bottom:10px; margin-top:10px; display:none">
 {$howit3->description|html_entity_decode|stripslashes}</div>
    </div>
    <div style="width:950px; display:none; color:#fff; margin:0 auto; " id="newsletter" >
     <!-- This code for newsletter popup -->

        <h4 class="newslettertitle">Newsletter Subscripton</h4>
	<span>Keep up to date with deals near you and best offers!</span>
        <div class="usersubsec">
	  <ul class="reset subscribeform">
	      <li>
		<div id="usersubsec" style="padding-left:10px;color:red"></div>
		<div class="fl">
		    <span style="color:#FFFFFF; font-weight:bold;">Email</span><br/><input type="text" id="sub_email" class="inputbg" />
		</div>
		<div class="clr">&nbsp;</div>
		<div class="fl">
		<span  style="color:#FFFFFF; font-weight:bold;">Location</span><br/> 
		<input type="text" id="sub_city" name="sub_city" class="inputbg" value="{$ipCity}" readonly="readonly" />
		</div>
		<div class="clr">&nbsp;</div>
		<p>If your location is not found or incorrect, enter your postcode.</p>
		<div class="fl" style="margin-top:10px;">
		<span  style="color:#FFFFFF;font-weight:bold;">Postcode</span><br/> <input type="text" id="sub_code" name="sub_code" class="inputbg" />
		</div>
	      </li> 
	      <li style="margin-top:14px;">
		  <div class="fl buttongreen"><input type="button" class="inputbtn" value="Subscribe" /> </div>
	      </li>
	  </ul>
        </div>
        <div>&nbsp;We will not share your information with anyone, you can unsubscribe at any time.</div>
        <br/><br/>
	<!-- End of newsletter subscriber -->
 </div>
</div>
<!-- main continer of the page -->
<div class="fullwid pagetopbg">
<div id="wrapper">
  <!-- Top section -->
  <div>
    <div class="fl">
      <ul class="reset topmenu">
  <!--        <li class="orangebg"><a {if $dtype eq 'product' } class="active" {/if} href="#"><span>Products only</span></a></li>
        <li class="greenbg"><a  {if $dtype eq 'service' } class="active" {/if} href="#"><span>Services only</span></a></li>-->
      <li class="orangebg"><a {if $detype eq 'product' } class="active" {/if} href="#" onMouseOut="hideTooltip()" onMouseOver="showTooltip(event,'{$headertooltip[0]}');return false"><span>Products only</span></a></li>
        <li class="greenbg"><a  {if $detype eq 'service' } class="active" {/if} href="#" onMouseOut="hideTooltip()" onMouseOver="showTooltip(event,'{$headertooltip[1]}');return false"><span>Vouchers only</span></a></li>
      </ul>
    </div>
    <div class="fr topR"><div  class="fl" ><a class="subscribe" href="#" id="howclick">How it works</a> | 
    <a class="subscribe" href="javascript:void(0);" id="newsclick"  >Newsletter Subscription</a>

    </div> | <span>Follow Us</span> <a href="#" target="_blank"><img src="{$siteimg}/f_icn.png" alt="facebook" /></a> <a href="#" target="_blank"><img src="{$siteimg}/t_icn.png" alt="twitter" /></a> <a href="#" target="_blank"><img src="{$siteimg}/rss_icn.png" alt="rss" /></a></div>
	<div class="clr">&nbsp;</div>
	
  </div>
 <!--<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script> -->
  <!-- Header starts -->
  <div id="header">
    
      <h1 id="logo" class="fl"><a href="#">&nbsp;</a></h1>
      <div class="fr headerR">
        <div id="globalNav">
          <ul class="reset topnav">
            <!--<li><a class="active" href="#"><span>Your account</span></a></li>-->
            <li><a href="#" {if $brows eq '1'} class="active" {/if}><span>Buy</span></a>
            	<ul class="reset">
                	<li><a href="#">Browse Categories</a></li>
                </ul>
            </li>
            <li><a href="#"><span>Sell</span></a>
            	<ul class="reset" style="">
                        {if $smarty.session.csUserTypeId eq '3' || $smarty.session.csUserTypeId eq ''}
                	<li><a href="#">Add A New Deal</a></li>
                    <li><a href="#">My Deal</a></li>
                    <li><a href="#" >My Feedback</a></li>
                        {else}
                        <li><a href="#" >Login as a seller.</a></li>
                        {/if}
                </ul>
            </li>
            <li><a href="#" {if $menu_forum eq 'forum'} class="active" {/if}><span>Community</span></a>
            	<!--<ul class="reset">
                	<li><a href="#">Browse Categories</a></li>
                </ul>-->
            </li>
            <li><a href="#" {if $menu_pastdeals eq '1'} class="active" {/if}><span>Past Deals</span></a>
            	<!--<ul class="reset">
                	<li><a href="#">Browse Categories</a></li>
                </ul>-->
            </li>
            <li class="bgnone"><a href="#"><span>Help</span></a>
            	<ul class="reset" style="width:120px;">
                	<li style="text-align:center;"><a href="#">Contact Us</a></li>
                   <!-- <li><a href="#">dispute centre</a></li>-->
                </ul>
            </li>
          </ul>
          <div class="clr">&nbsp;</div>
        </div>
{if $smarty.session.csUserId eq ''}
        <div class="loginsec fr">
          <div class="loginregbg">
          	<ul class="reset loginregmenu">
				<li class=""><a href="#" class="login {if $tab eq 'log'} active{/if}" onClick="#" ><!--<input type="button" class="login fl {if $tab eq 'log'} active{/if}" value="" onClick="window.location.href='{$siteroot}/sign-in/'" />-->Login</a>
                	<div class="loginpopupbox">
                <form name="frmHeaderSignin" id="frmHeaderSignin" method="post" >
                    	<ul class="reset form">
                        	<li style="height:45px;">
                            	<label style="width:80px; text-align:right" for="email">Email:</label>
                                <input type="text" id="lemail" name="lemail" class="inputbg" style="width:220px" value="{$lemail}" autocomplete="off"  />
                                <div class="error" htmlfor="lemail" style="margin-left:88px;" generated="true">
                            </li>
                            <li style="height:45px;">
                            	<label style="width:80px; text-align:right" for="pwd">Password:</label>
                                <input type="password" id="lpassword" name="lpassword" class="inputbg" style="width:220px" value="{$lpassword}"/>
                                 <div class="error" htmlfor="lpassword" align="center" generated="true" >
                            </li>
                            <li>
                            	<label style="width:80px">&nbsp;</label>
                                <input type="checkbox" name="isremember" id="isremember" value="1"
                        	{if $isremember eq 1} checked="true" {else} checked="false" {/if}/>&nbsp;Remember me for 24 hours.
                            </li>
                            <li>
                            	<label style="width:80px">&nbsp;</label>
                                <a href="#">Forgotten your password?</a>
                            </li>
                            <li>
                            	<label style="width:80px">&nbsp;</label>
                                <div class="buttongreen"><input type="button" style="width: 67px;" value="Login" name="btnLogin" class="inputbtn" /></div>
                            </li>
                        </ul>
                        <div class="clr">&nbsp;</div>
                    </div>
                </li>    
            	<li class="registermenu"><a href="#" class="register fl{if $tab eq 'reg'} active{/if}" >Register</a></li>
				</ul>        
          </div>
          </form>
<!--fb twitter code-->
</div>
{else}
 <div class="clr">&nbsp;</div>
<div class="loginsec fr">
          <a class="strong welcometxt" href="#">Welcome {$smarty.session.csFullName|ucfirst}</a> ,
          <a class="myaccnt" href="#">My Account</a>{if $smarty.session.csUserMsg > 0} | <a href="#">Messages {if $msg_unreadCnt gt 0} ({$msg_unreadCnt}) {/if}</a> {/if}| <a href="#">Logout</a> </div>
      
{/if}
  </div>
    <div class="clr">&nbsp;</div>
  </div>
  <div class="clr">&nbsp;</div>
  <!-- Header ends -->
