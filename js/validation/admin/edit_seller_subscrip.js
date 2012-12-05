$(document).ready(function(){

  	$("#frmModifSubs").validate({
    		errorElement:'div',
		rules: {
				subscription:{
					required: true	
				}
	
		},
		messages: {
				subscription:{
					required: "Please select any one subscription pack."
				}
				
			}
	});
});