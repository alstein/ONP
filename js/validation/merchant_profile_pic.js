$(document).ready(function() {
jQuery.validator.addMethod("noSpace", function(value, element) {
	return value.indexOf(" ") < 0 && value != ""; 
}, "Only A-Z, a-z & _ is allowed without space");

	$.validator.addMethod("noSpecialChars", function(value, element) {
		return /^[a-zA-Z\_]+$/i.test(value);
	}, "Only A-Z, a-z & _ is allowed without space");

	$.validator.addMethod("postcodes", function(value, element){
		var temp;
		temp = true;
		str = /[^a-zA-Z0-9 ]/;
		temp = !str.test(value);
		return temp;
	}, "Only 0 to 9, a to z, A to Z and space is allowed.");

	$.validator.addMethod("alphaOnly", function(value, element){
		var temp;
		temp = true;
		str = /[^a-zA-Z -]/;
		temp = !str.test(value);
		return temp;
	}, "Only a to z, A to Z and - is allowed.");

	jQuery.validator.addMethod("url_double_dot", function(value, element) {
		for(var i=0; i<value.length; i++)
		{
			if(value[i] == '.' && value[(parseInt(i)+1)] == '.')
				return false;
		}
		return true;
	},"Please enter valid URL");


jQuery.validator.addMethod("emailchk", function(value, element) {
		var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		return rege.test($('#email').val());
},"Please enter valid email address");

	$('#frm_profilepic').validate({
		    errorElement:'div',
		    rules: {
			about_business: {
				required: true,
				minlength: 3,
				maxlength: 800
				
			},
			maincategory:{
			    	required: true
		
			},
			subcategory:{
				required: true
			},
			speciality:{
				required: true
				
			},
			price_menu_list:{
				//required: true,
				accept:"PDF|pdf|doc|DOC|jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG|xls|XLS|docx|DOCX|txt|TXT"
// 				accept:"jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG|PDF|pdf"
				
			},
			upload_photo:{
			//	required: true,
				//accept:"PDF|pdf|doc|DOC|jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG|xls|XLS|docx|DOCX"
				accept:"jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG"
			}

		    },
		    messages: {
			about_business:{
				required: "Please enter about business",
				minlength: $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			maincategory:{
				required: "Please select category"
			},
			subcategory:{
				required: "Please select sub category ."
			},
			speciality:{
				required: "Please enter speciality."
			},
			price_menu_list:{
			//	required: "Please upload price menu list."
			},
			upload_photo:{
			//	required: "Please upload photo."
			}

			
		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
        });
		
});

