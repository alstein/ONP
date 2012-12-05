$(document).ready(function() {

var userid=$("#uid").val();

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

	jQuery.validator.addMethod("custmchh", function(value, element) {
			var sthr = $("#start_hour").val();
			if(value >= sthr) return true;
	},"Please select valid end hour");

	jQuery.validator.addMethod("custmchm", function(value, element) {
			var sthr = $("#start_hour").val();
			var stmin = $("#start_min").val();
			var endhr = $("#end_min").val();
					if(endhr == sthr) 
			{	
				if(value > stmin) return true;	
			}else return true;


	},"Please select valid end time");
	jQuery.validator.addMethod("custmchh1", function(value, element) {
			var sthr = $("#start_hour1").val();
			if(value >= sthr) return true;
	},"Please select valid end hour");

	jQuery.validator.addMethod("custmchm1", function(value, element) {
			var sthr = $("#start_hour1").val();
			var stmin = $("#start_min1").val();
			var endhr = $("#end_min1").val();
						if(endhr == sthr) 
			{	
				if(value > stmin) return true;	
			}else return true;

	},"Please select valid end time");

	$('#frmRegistration').validate({
		    errorElement:'div',
		    rules: {
					email:{
						
						required: true,
						email: true,
						emailchk:true,
						remote: SITEROOT + "/admin/user/ajax_check_user.php?userid="+userid
					},
					/*password:{
                                                required: false,
						minlength: 6,
						maxlength: 20,
						noSpace: true
					},
					new_password:{
                                                    required: false,
							equalTo: "#password",
							minlength: 6,
							maxlength: 20,
							noSpace: true
					},*/
					business_name: {
						required: true,
						minlength: 3,
						maxlength: 100,
						alphaOnly:true
						
					},
					contact_person:{
						required: true,
						minlength: 3,
						maxlength: 100,
						alphaOnly:true
					
					},
					address1:{
						required: true,
						minlength: 3,
						maxlength:500
					},
					countryid:{
						required: true,
						minlength: 3,
						maxlength: 100
					},
					cityid:{
						required: true,
						minlength: 3,
						maxlength: 100
					},
					contact_detail:{
						required: true,
						number:true,
						//minlength: 10,
						maxlength: 12 
					},
					website:{
					//  url:true,
						maxlength:255
					},
					about_us: {
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
					specility:{
						required: true,
						minlength: 3,
						maxlength: 500
					},
					price_menu_list:{
						accept:"PDF|pdf|doc|DOC|jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG|xls|XLS|docx|DOCX|txt|TXT"
					},
					end_hour:{
						custmchh:true
					},
					end_min:{
						custmchm:true
					},
					end_hour1:{
						custmchh1:true
					},
					end_min1:{
						custmchm1:true
					}
		    },
		    messages: {
					email:{
						required: "Please enter email address",
						email: "Please enter correct email address",
						emailchk:"Please enter correct email address",
						remote: "This email address is already in use"
						
					},
					/*password:{
						required: "please enter password",
						noSpace: "Space is not allowed",
						minlength: $.format("Enter at least {0} characters"),
						maxlength: $.format("Enter at least {0} characters")
					},
					new_password:{
							equalTo: "please enter password same as above",
						minlength: jQuery.format("Enter at least {0} characters"),
						maxlength: jQuery.format("Enter at most {0} characters")
					},*/
					business_name:{
						required: "Please enter business name",
						minlength: $.format("Enter at least {0} characters"),
						maxlength: $.format("Enter maximum {0} characters")
					},
					contact_person:{
						required: "Please enter contact person",
						minlength: jQuery.format("Enter at least {0} characters."),
						maxlength: jQuery.format("Enter at most {0} characters.")
					},
					address1:{
						required: "Please enter address.",
						minlength: $.format("Enter at least {0} characters"),
						maxlength: $.format("Enter maximum {0} characters")
					},
					countryid:{
						required: "Please select Country.",
						minlength: $.format("Enter at least {0} characters"),
						maxlength: $.format("Enter maximum {0} characters")
					},
					cityid:{
						required: "Please select city.",
						minlength: $.format("Enter at least {0} characters"),
						maxlength: $.format("Enter maximum {0} characters")
					},
					contact_detail:{
						required: "Please enter Phone number",
						number: "Please enter number",
						minlength: $.format("Enter at least {0} characters"),
						maxlength: $.format("Enter maximum {0} characters")
					},
					website:{
						url: "Please enter valid URL",
						maxlength:$.format("Enter maximum {0} characters")
					},
					about_us:{
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
					specility:{
						required: "Please enter speciality.",
						minlength: $.format("Enter at least {0} characters"),
						maxlength: $.format("Enter maximum {0} characters")
					}
		},
					success: function(label) {
						// set &nbsp; as text for IE
						label.hide();
					}
        });
});
