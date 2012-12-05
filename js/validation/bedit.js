$(document).ready(function(){
	$("#frmbEdit").validate({
	errorElement:'div',
	rules:{
	buyername:{
            required:true,
            maxlength: 100
         },
	fname:{
            required:true,
            maxlength: 100
         },
	lname:{
            required:true,
            maxlength: 100
         },	
	addrline1:{
	   	required:true,
           	maxlength: 255
	},
	cities:{
		required:true
	},
	country:{
		required:true
	},
		
         zip:{
            required:true
         },
	agree:{
		required:true
	}
	},
	
	messages:{
	buyername:{
		required: "Please enter  name",
            maxlength: "Please enter not more than 100 characters"
	},
	fname:{
            required: "Please enter first name",
            maxlength: "Please enter not more than 100 characters"
         },
	lname:{
            required: "Please enter last name",
            maxlength: "Please enter not more than 100 characters"
         },	
	addrline1:{
	   	required: "Please enter address",
            	maxlength: "Please enter not more than 255 characters"
	},
	cities:{
		required:"Please select city."
	},
	country:{
		required:"Please select country."
	},
	
	zip:{
            required: "Enter a zip code"
         },	
	agree:{
		required: "Tick on notes for approval"
	}
	},
	success: function(label) {
		label.hide();
		}
	});
});