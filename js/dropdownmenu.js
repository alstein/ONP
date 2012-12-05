var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;
function jsddm_open(){
	jsddm_canceltimer();
	jsddm_close();
	ddmenuitem = $(this).find('ul').eq(0).css('visibility', 'visible');
}
function jsddm_close(){
	if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');
}
function jsddm_timer(){
	closetimer = window.setTimeout(jsddm_close, timeout);
}
function jsddm_canceltimer(){
	if(closetimer){
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}
//$(document).ready(function(){
//	$('#nav > li').bind('mouseover', jsddm_open);
//	$('#nav > li').bind('mouseout',  jsddm_timer);
//	$("ul.SubNav li a").mouseover(function(){
//		$(this).parent().parent().parent().addClass('hover');
//	});
//	$("ul.SubNav li a").mouseout(function(){
//		$(this).parent().parent().parent().removeClass('hover');
//	});
//});