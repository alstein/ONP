	var dragElement = false;
	var xDif = 0;
	var yDif = 0;
	
	
	function mouse_down(event, elementName){		
		var leftDim = document.getElementById(elementName).offsetLeft;
		var topDim = document.getElementById(elementName).offsetTop;
		dragElement = true;
		xDif = event.clientX - leftDim;
		yDif = event.clientY - topDim;
	}
	
	function dragWin(event, elementName){
		if(dragElement == true){
			document.getElementById(elementName).style.left = event.clientX - xDif + 'px';
			document.getElementById(elementName).style.top = event.clientY - yDif + 'px';
		}	
	}

	
	function mouse_up(event, elementName){
		dragElement = false;
		document.getElementById(elementName).style.left = event.clientX - xDif + 'px';
		document.getElementById(elementName).style.top = event.clientY - yDif + 'px';

	}

	$(document).ready(function(){
		$("#popupWin").fadeIn('fast');
		$(".close").click(function(){
			$("#popupWin").fadeOut('slow');
		})
		$("#showWin").click(function(){
			$("#popupWin").fadeIn('fast');
		})
		$("#minWin").click(function(){
			$(".content").slideUp("slow");
			$(this).hide();
			$("#maxWin").show();
		})
		$("#maxWin").click(function(){
			$(".content").slideDown("fast");
			$(this).hide();
			$("#minWin").show();
		})
	})
