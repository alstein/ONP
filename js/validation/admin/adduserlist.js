$(document).ready(function(){

	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	},"Only A-Z, a-z & _ is allowed without space");
	
	$.validator.addMethod("noSpecialChars", function(value, element) {
	      return /^[a-zA-Z\_]+$/i.test(value);
	},"Only A-Z, a-z & _ is allowed without space");
	
	jQuery.validator.addMethod("zipcode", function(value, element) { 
	  return /^\d{5}(-\d{4})?$/.test(value);
	},"Please enter valid Postcode");


	jQuery.validator.addMethod("emailchk", function(value, element) {
			var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			return rege.test($('#email').val());
	},"Please enter valid email address");


jQuery.validator.addMethod("letterspaceonly", function(value, element) {
	return this.optional(element) || /^([a-z]+([\s][a-z]+)?)+$/i.test(value);
	}, "Letters and Single space only");

// 	jQuery.validator.addMethod("cat_referance", function(value, element) { 
// 			var cat_checked = $("input[id=cat_ref]:checked").length;
// 			alert(cat_checked);
// 			if(cat_checked==0){
// 				return true;
// 			}else{
// 				return false;
// 			}
// 	},"testing category");
// 







$.validator.addMethod("yearchk", function(value, element) {

var day = $("#sel_dd").val();
var month = $("#sel_mm").val();
var year = $("#sel_yy").val();
var age = 18;
var mydate = new Date();
mydate.setFullYear(year, month-1, day);
var currdate = new Date();
currdate.setFullYear(currdate.getFullYear() - age);

	if ((currdate - mydate) < 0){
	//alert("Sorry, only persons over the age of " + age + " may enter this site");
	return false;
	}
	return true;

}, "You should be 18 years old.");





 $.validator.addMethod("CheckDOB", function (value, element) {
        var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!

	var yyyy = today.getFullYear();
	if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
	var today = yyyy+'-'+mm+'-'+dd;
	
        var DOB = $('#birthday').val();
        if(DOB <= today) {  
            return true;  
        }  
        return false;  
    }, "Birth Date must be less than today's date.");

	$("#frmRegistration").validate({
		errorElement:'div',
		rules: {
			first_name:{
				required: true,
				//noSpace:true,
				//noSpecialChars:true,
				letterspaceonly:true,
				minlength: 2,
				maxlength:50
			},
			last_name:{
				required: true,
				//noSpace:true,
				//noSpecialChars:true,
				letterspaceonly:true,
				minlength: 2,
				maxlength:50
			},
			sel_yy:{
				yearchk:true
			},
			rel_status:{
				required: true
			},
			email:{
				required: true,
				email: true,
				remote: SITEROOT + "/admin/user/ajax_check_whole_user.php"
				
			},
			reenter_email: {
				required: true,
				equalTo:'#email'
			},
			password:{
			    required:true,
			    noSpace: true,
			    minlength: 6,
			    maxlength: 20
			},
			gender:{
				required:true
			},
			photo:{
				required: true,
				accept: "jpg|jpeg|gif|png"	
			},
			grad_collage:{
				minlength: 2,
				maxlength:100
			},
			under_grad_collage:{
				minlength: 2,
				maxlength:100
			},
			music:{
				minlength: 2,
				maxlength:100
			},
			activity:{
				minlength: 2,
				maxlength:100
			}

		},
		messages: {
			first_name:{
				required: "Please enter first name",
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			last_name:{
				required: "Please enter last name",
				minlength: $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			rel_status:{
				required: "Please select Relationship status"
			},
			email:{
				required: "Please enter email",
// 				email: "Please enter a valid email address.",
				remote: "This email address is already in use"
							
			},
			reenter_email: {
				required: "Please enter your email again.",
				equalTo: "Please enter the same email as above"
			},
			password:{
				required: "Please enter password",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			},
			gender:{
				required: "Please select gender"
			},
			photo:{
				 required: "Please upload profile picture.",
				 accept: "Please provide valid image format"
			},
			grad_collage:{
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			under_grad_collage:{
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			music:{
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			activity:{
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			}
		}
	});
});
