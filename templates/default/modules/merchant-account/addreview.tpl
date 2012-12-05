{strip}
<!-- demo page css -->
<!--<link rel="stylesheet" type="text/css" media="screen" href="{$siteroot}/rating/css/demos.css"/>-->
<script type="text/javascript" src="{$sitejs}/jquery-1.2.6.pack.js"></script>
<link href="{$siteroot}/templates/default/css/lightbox.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="{$siteroot}/js/rating/js/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="{$siteroot}/js/rating/js/jquery.raty.min.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/rating/js/jquery.rating.js"></script>
<!-- demo page js -->
<script type="text/javascript" src="{$siteroot}/rating/js/jquery.min.js?v=1.4.2"></script>
<script type="text/javascript" src="{$siteroot}/rating/js/jquery-ui.custom.min.js"></script>
<!-- Star Rating widget stuff here... -->
<script type="text/javascript" src="{$siteroot}/rating/js/jquery.ui.stars.js"></script>
<link rel="stylesheet" type="text/css" href="{$siteroot}/rating/css/jquery.ui.stars.css"/>
<script type="text/javascript" src="{$sitejs}/func.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery-effect.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
{/strip}
{literal}
<!--  Star rating Script start -->
<script type="text/javascript">
var siteurl= {/literal}'{$siteroot}'{literal};
			$(function(){
			
			$caption = $("<span/>");

			$(".star").stars({
				inputType: "select",

				cancelShow: false,
				
				captionEl: $(this).parent().next().find('td'), 
				callback: function(ui, type, value)
				{
					$.post("rating.php", {rate: value}, function(data)
					{
					
					});
				}

			});

			// Make it available in DOM tree
			$caption.appendTo("#ratings");
		});


//     $("#stars-wrapper2").stars({
//         inputType: "select"
//     });
	</script>
<!--  Star rating Script end -->
<script type="text/javascript" language="JavaScript">

$(document).ready(function(){
	$("#frm").validate({
		errorElement:'div',
		rules: {
			dtlss:{
				required: true,
				minlength: 2,
				maxlength:1000
			},
			summary:{
				required: true,
				minlength: 2,
				maxlength:150
			}

		},
		messages: {
			dtlss:{
				required: "Please write review",
				minlength: "Enter at least 2 charactors",
				maxlength: "Enter at most 1000 charactors"
			},
			summary:{
				required: "Please write summary",
				minlength:  "Enter at least 2 charactors",
				maxlength: "Enter at most 150 charactors"
			}
		}
	});
	
});
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}


function facebookpublish()
{  
    
     var fbid={/literal}'{$fbid}'{literal};
    
    var merchant={/literal}'{$merchant}'{literal};  
    var usernam={/literal}'{$usernam}'{literal}; 
        var review=document.getElementById("dtlss").value;
        var keyword=usernam+" wrote a review on "+merchant+" on OffersnPals";
        var my_string=confirm("Do you want to publish your review to facebook?");
          if(my_string==true)
         {
                    FB.init({
                    appId  : fbid,
                    status : true, // check login status
                    cookie : true, // enable cookies to allow the server to access the session
                    xfbml  : true,
                    oauth  : true // parse XFBML
                  });

                     var obj = {
                          method: 'feed',
                          link: 'http://offersnpals.com/',
                          picture: 'http://offersnpals.com/templates/default/images/logopdf.jpg',
                          name: 'Offersnpals',
                          caption: keyword,
                          description: review
                    };

                    function callback(response) {
                        if(response){
                         window.close();
                        }
                    }

                    FB.ui(obj, callback);
   }
}
</script>
{/literal}
{literal}
<style type="text/css">

.profile-name {
    color: #2B587A;
    cursor: pointer;
    float: left;
    font: bold 12px Arial,Helvetica,sans-serif;
    padding-top: 4px;
    width: 135px; text-align:left; vertical-align:top;
}
.message{
	color:#504F4E; font:normal 11px Arial;
}
</style>
{/literal}
<form name="frm" id="frm" action="" method="post" >

  {if $numrets eq 0}
  <table border="0" width="100%" cellspacing="0" cellpadding="0" style="padding:0 20px">
    <col width="135" />
    <col />
    <tr>
      <td colspan="2">&nbsp;&nbsp;</td>
    </tr>
    <tr>
      <td class="profile-name" style="color: #8F8A89;float: left;font:  12px/22px Arial,Helvetica,sans-serif;text-align: right;width: 142px;"><span class="red"></span> Rate:&nbsp;</td>
      <td align="center"><div class="star">
          <select name="fan_ratesel_{$rate_field[r].fieldid}" id="chk">
            <option value="{$rate_field[r].fieldid}#1#fan" {if $rate_field[r].fan_rate_sel eq "$rate_field[r].fieldid#1#fan" } selected="selected" {/if}>Very poor</option>
            <option value="{$rate_field[r].fieldid}#2#fan" {if $rate_field[r].fan_rate_sel eq "$rate_field[r].fieldid#2#fan" } selected="selected" {/if}>Not that bad</option>
            <option value="{$rate_field[r].fieldid}#3#fan" {if $rate_field[r].fan_rate_sel eq "$rate_field[r].fieldid#3#fan" } selected="selected" {/if}>Average</option>
            <option value="{$rate_field[r].fieldid}#4#fan" {if $rate_field[r].fan_rate_sel eq "$rate_field[r].fieldid#4#fan" } selected="selected" {/if} >Good</option>
            <option value="{$rate_field[r].fieldid}#5#fan" {if $rate_field[r].fan_rate_sel eq "$rate_field[r].fieldid#5#fan" } selected="selected" {/if}>Perfect</option>
          </select>
        </div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;&nbsp;</td>
    </tr>
    <tr>
      <td class="profile-name" style="color: #8F8A89;float: left;font:  12px/22px Arial,Helvetica,sans-serif;text-align: right;width: 142px;"><font color="red">*</font> Keywords/Summary:&nbsp;</td>
      <td valign="top">
      <div class="keyword-txtbox">
          <input type="text" name="summary" id="summary" onKeyDown="limitText(this.form.summary,this.form.countdown,150);" 
onKeyUp="limitText(this.form.summary,this.form.countdown,150);" >
          <!--<textarea name="summary" class="keyword-input" id="summary" rows="2" cols="37" class="keyword-input" onKeyDown="limitText(this.form.summary,this.form.countdown,150);" 
onKeyUp="limitText(this.form.summary,this.form.countdown,150);" class="reviw-input"></textarea>-->
          <br>
        </div>
        <div class="message">Max 150 Characters</div>
        <input readonly type="hidden" name="countdown" size="3" value="15">
        <div class="error" htmlfor="summary" generated="true" style="color: #FF0707;
    font-family: Arial,Verdana,Helvetica,sans-serif;"></div></td>
    </tr>
    <tr>
      <td class="profile-name" style="color: #8F8A89;float: left;font:  12px/22px Arial,Helvetica,sans-serif;text-align: right;width: 142px; line-height:25px"><font color="red">*</font> Review:&nbsp;</td>
      
      <td><div class="reviw-txtbox">
          <textarea name="dtlss" id="dtlss" rows="10" "onKeyDown="limitText(this.form.dtlss,this.form.countdown1,1000);" onKeyUp=limitText(this.form.dtlss,this.form.countdown1,1000)" class="reviw-input"></textarea>
        </div>
        <br>
        <div class="message">Max 1000 Characters</div>
        <input readonly type="hidden" name="countdown1" size="3" value="15">
        <div class="error" htmlfor="dtlss" generated="true" style="color: #FF0707;
    font-family: Arial,Verdana,Helvetica,sans-serif;"></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left">
      <!--<input type="submit" name="Submit" id="Submit" value="Submit">-->

        <input id="postbtn" class="previe-btn" type="submit" name="Submit" id="Submit" value="Submit" name="postbtn" style="cursor:pointer; margin:15px 0 0 0" onclick="facebookpublish()"></td>
    </tr>
  </table>
  {else}
  <table>
    <tr>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td align="center">You've already rated this business</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
    </tr>
  </table>
  {/if}
</form>
