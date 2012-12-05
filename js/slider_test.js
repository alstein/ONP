$(document).ready(function(){
  $("#content-slider").slider({
    animate: true,
    change: handleSliderChange,
    slide: handleSliderSlide
  });
});

var uivalue=0;
var contentscrollstep=23;
var uisliderhandlestep=10;


function handlePrevClick()
{
 //alert($("#content-scroll").attr("scrollWidth"));
 //alert($("#content-scroll").width()); 
 //alert(uivalue);
  uisliderhandlecurrentposition=parseInt(($(".ui-slider-handle").css("left")).substring(0,((($(".ui-slider-handle").css("left")).length)-1)));
 // alert(uisliderhandlecurrentposition);
  if((uisliderhandlecurrentposition-uisliderhandlestep)<=0)
    {
	  //alert("left side limit");
	 //uisliderhandlenewposition=uisliderhandlecurrentposition-uisliderhandlestep; 
     uisliderhandlenewposition="0%";
     $(".ui-slider-handle").css("left",uisliderhandlenewposition);
     var maxScroll = $("#content-scroll").attr("scrollWidth") - $("#content-scroll").width();
     uivalue=uivalue-contentscrollstep;
     $("#content-scroll").animate({scrollLeft: uivalue * (maxScroll / 100) }, 1000);
	}
  else
    {
     uisliderhandlenewposition=uisliderhandlecurrentposition-uisliderhandlestep; 
     uisliderhandlenewposition=uisliderhandlenewposition+"%";
     $(".ui-slider-handle").css("left",uisliderhandlenewposition);
     var maxScroll = $("#content-scroll").attr("scrollWidth") - $("#content-scroll").width();
     uivalue=uivalue-contentscrollstep;
     $("#content-scroll").animate({scrollLeft: uivalue * (maxScroll / 100) }, 1000);
	}
}

function handleNextClick()
{
  //alert($("#content-scroll").attr("scrollWidth"));
  //alert($("#content-scroll").width());
  //alert(uivalue);
  //alert($(".ui-slider-handle").css("left"));
  //alert(($(".ui-slider-handle").css("left")).length);
  uisliderhandlecurrentposition=parseInt(($(".ui-slider-handle").css("left")).substring(0,((($(".ui-slider-handle").css("left")).length)-1)));
  //alert(uisliderhandlecurrentposition);
  if((uisliderhandlecurrentposition+uisliderhandlestep)>68)
	{
      //alert("right side limit");
	  //uisliderhandlenewposition=uisliderhandlecurrentposition+uisliderhandlestep; 
     uisliderhandlenewposition="68%";
     $(".ui-slider-handle").css("left",uisliderhandlenewposition);
     var maxScroll = $("#content-scroll").attr("scrollWidth") - $("#content-scroll").width();
     uivalue=uivalue+contentscrollstep;
     $("#content-scroll").animate({scrollLeft: uivalue * (maxScroll / 100) }, 1000);
	}
  else
    {
     uisliderhandlenewposition=uisliderhandlecurrentposition+uisliderhandlestep; 
     uisliderhandlenewposition=uisliderhandlenewposition+"%";
     $(".ui-slider-handle").css("left",uisliderhandlenewposition);
     var maxScroll = $("#content-scroll").attr("scrollWidth") - $("#content-scroll").width();
     uivalue=uivalue+contentscrollstep;
     $("#content-scroll").animate({scrollLeft: uivalue * (maxScroll / 100) }, 1000);
	}
}

function handleSliderChange(e, ui)
{
	//alert(ui);
  var maxScroll = $("#content-scroll").attr("scrollWidth") - $("#content-scroll").width();
  uivalue=ui.value;
  $("#content-scroll").animate({scrollLeft: ui.value * (maxScroll / 100) }, 1000);

}

function handleSliderSlide(e, ui)
{
  var maxScroll = $("#content-scroll").attr("scrollWidth") - $("#content-scroll").width();
  $("#content-scroll").attr({scrollLeft: ui.value * (maxScroll / 100) });
}

function setcontentdiv(innerhtml)
{
 $("#contentdiv").html(innerhtml);
}