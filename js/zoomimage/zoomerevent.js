
(function($){$.fn.Zoomer=function(b){var c=$.extend({speedView:200,speedRemove:400,altAnim:false,speedTitle:400,debug:false},b);var d=$.extend(c,b);function e(s){if(typeof console!="undefined"&&typeof console.debug!="undefined"){console.log(s)}else{alert(s)}}if(d.speedView==undefined||d.speedRemove==undefined||d.altAnim==undefined||d.speedTitle==undefined){e('speedView: '+d.speedView);e('speedRemove: '+d.speedRemove);e('altAnim: '+d.altAnim);e('speedTitle: '+d.speedTitle);return false}if(d.debug==undefined){e('speedView: '+d.speedView);e('speedRemove: '+d.speedRemove);e('altAnim: '+d.altAnim);e('speedTitle: '+d.speedTitle);return false}if(typeof d.speedView!="undefined"||typeof d.speedRemove!="undefined"||typeof d.altAnim!="undefined"||typeof d.speedTitle!="undefined"){if(d.debug==true){e('speedView: '+d.speedView);e('speedRemove: '+d.speedRemove);e('altAnim: '+d.altAnim);e('speedTitle: '+d.speedTitle)}
$(this).hover(function()
{$(this).css({'z-index':'10'});$(this).find('img').addClass("hover").stop().animate({marginTop:'-110px',marginLeft:'-110px',top:'50%',left:'50%',width:'175px',height:'181px',padding:'20px'},d.speedView);if(d.altAnim==true)
{
var stckcheck=jQuery("#imgstck").val();
var a=$(this).find("img").attr("alt");
var aval=$(this).find("a").attr("href");
var eventdate=$(this).find("a").attr("id");
var eventtime=$(this).find("a").attr("name");
var eventprice=$(this).find("a").attr("rel");

if(a.length!=0)
{
		if(stckcheck=="medium")
		{
		$(this).append('<span class="txttype1"><a style="color:green;" href="'+aval+'">'+a+'</a><br/><font style="color:red;">Party Date : </font><font style="color:gray;">'+eventdate+'</font><br/><font style="color:red;">Party Time : </font><font style="color:gray;"> '+eventtime+'</font><br/><font style="color:red;">Admission Price: </font><font style="color:gray;"> $'+eventprice+'</font></span>');
		// $(this).css({'z-index':'10','border':'1px solid #000'});
		}
		else if(stckcheck=="small")
		{
		$(this).append('<span class="txttype2"><a style="color:green;" href="'+aval+'">'+a+'</a><br/><font style="color:red;">Party Date : </font><font style="color:gray;">'+eventdate+'</font><br/><font style="color:red;">Party Time : </font><font style="color:gray;"> '+eventtime+'</font><br/><font style="color:red;">Admission Price: </font><font style="color:gray;"> $'+eventprice+'</font></span>');
		// $(this).css({'z-index':'10','border':'1px solid #000'});
		}
		else
		{


			$(this).append('<span class="txttype"><a style="color:green;" href="'+aval+'">'+a+'</a><br/><font style="color:red;">Party Date : </font><font style="color:gray;">'+eventdate+'</font><br/><font style="color:red;">Party Time : </font><font style="color:gray;"> '+eventtime+'</font><br/><font style="color:red;">Admission Price: </font><font style="color:gray;"> $'+eventprice+'</font></span>');


		}
}
}
}
,function(){
var stck=jQuery("#imgstck").val();
if(stck=="medium")
{
$(this).css({'z-index':'0'});$(this).find('img').removeClass("hover").stop().animate({marginTop:'0',marginLeft:'0',top:'0',left:'0',width:'70px',height:'100px',padding:'2px'},d.speedRemove);$(this).find('.txttype1').remove()
}
else if(stck=="small")
{
$(this).css({'z-index':'0'});$(this).find('img').removeClass("hover").stop().animate({marginTop:'0',marginLeft:'0',top:'0',left:'0',width:'50px',height:'90px',padding:'2px'},d.speedRemove);$(this).find('.txttype2').remove()
}
else
{
$(this).css({'z-index':'0'});$(this).find('img').removeClass("hover").stop().animate({marginTop:'0',marginLeft:'0',top:'0',left:'0',width:'100px',height:'150px',padding:'2px'},d.speedRemove);$(this).find('.txttype').remove()
}

})}}})(jQuery);