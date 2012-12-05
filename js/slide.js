$(document).ready(function() {
	
	// Expand Panel
	$("#open").click(function(){
		$("div#panel").slideDown("medium");
	
	});	
	
	// Collapse Panel
	$("#close").click(function(){
		$("div#panel").slideUp("medium");	
	});		
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#welcome-city a").click(function () {
		$("#welcome-city a").toggle();
	});		
		
});