// JavaScript Document

// To use any effect just remove the comment &amp; change respective selectors

 $(document).ready(function(){							
//Dropdown with slide effect 
// $("ul.topnav li").hover(function(){
//$("ul", this).slideDown("fast");
// return false;
// },function(){
//   $("ul", this).slideUp("slow");
// });

//Normal Dropdown with IE6 Compatible 
//$("ul.topnav li").hover(function(){
//   $("ul", this).slideDown("fast");
//    return false;
// },function(){
//   $("ul", this).slideUp("slow");
// });
// 

//accordian effect 1
//     $("dd").hide();
//		$("dt").click(function(){
//		if ($(this).next("dd").is(":hidden")) {					   
//		$(this).next("dd:visible").hide("slow");
//		$(this).addClass("open");
//		$("dd").hide("slow");
//	    $(this).next("dd").show("slow");		
//		$("span").removeClass("arrow2");
//		$("span", this).addClass("arrow2");	
//		} else {
//			$("span").removeClass("arrow2");
//			$("dd").hide("slow");			
//		}
//	    return false;
//		
//      });
		
		
//accordian effect 2
		//$("dd").hide();
//		$("dt").click(function(){
//		if ($(this).next("dd").is(":hidden")) {					   
//		$(this).next("dd:visible").slideUp("slow");
//		$(this).addClass("open");
//		$("dd").slideUp("slow");
//	    $(this).next("dd").slideDown("slow");		
//		$(this).removeClass("horarw");
//		$(this).addClass("horarw");	
//		} else {
//			$(this).removeClass("horarw");
//			$("dd").slideUp("slow");			
//		}
//	    return false;
//		
//      });
//	

//Simple fading effect						
$(".midmnu a span").hover(function(){
$(this).fadeTo("opacity", 0.33);   
$(this).fadeTo("opacity", 1);	
return false;
},function(){
$(this).fadeTo("opacity", 1);	
});

$(".topnav a").hover(function(){
$(this).fadeTo("opacity", 0.33);  
$(this).fadeTo("opacity", 1);	
return false;
},function(){
$(this).fadeTo("opacity", 1);	
});
   				
		
  });		