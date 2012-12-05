var IE6 = (navigator.userAgent.indexOf("MSIE 6")>=0) ? true : false;

var protocol =  (("https:" == document.location.protocol) ? "https://" : "http://");


      var serverLocation = protocol + "localoffersnpals.com";

   var SITEROOT = serverLocation;

if(IE6){

	$(function(){
		
		$("<div>")
			.css({
				'position': 'absolute',
				'top': '0px',
				'left': '0px',
				'backgroundColor': 'black',
				'opacity': '0.75',
				'width': '100%',
			//	'height': $(window).height(),
				'height':2500,
				 zIndex: 5000
			})
			.appendTo("body");
			
		$("<div><img src='http://72.29.76.227/~alsteinp/templates/default/images/no-ie6.png' alt='' style='float: left;'/><p><br /><strong>Sorry! This page doesn't support Internet Explorer 6.</strong><br /><br />If you'd like to read our content please <a href=' http://www.microsoft.com/india/windows/ie/IE8.aspx?os=Linux&browser=Firefox'>download and upgrade your browser</a></p>")
			.css({
				backgroundColor: 'white',
				'top': '25%',
				'left': '50%',
				marginLeft: -210,
				marginTop: -100,
				width: 410,
				paddingRight: 10,
				height: 200,
				'position': 'absolute',
				zIndex: 6000	
			})
			.appendTo("body");
	});		
}
