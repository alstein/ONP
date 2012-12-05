$(document).ready(function(){
	var useridd=$("#userid").val();
	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	},"Only A-Z, a-z & _ is allowed without space");
	
	$.validator.addMethod("noSpecialChars", function(value, element) {
	      return /^[a-zA-Z\_]+$/i.test(value);
	},"Only A-Z, a-z & _ is allowed without space");
	
	jQuery.validator.addMethod("zipcode", function(value, element) { 
	  return /^\d{5}(-\d{4})?$/.test(value);
	},"Please enter valid Postcode");

	$.validator.addMethod("postcodes", function(value, element){
			var temp;
			temp = true;
			str = /[^a-zA-Z0-9 ]/;
			temp = !str.test(value);
			return temp;
	}, "Only 0 to 9, a to z, A to Z and space is allowed.");

	jQuery.validator.addMethod("emailchk", function(value, element) {
			var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			return rege.test($('#email').val());
	},"Please enter valid email address");


	jQuery.validator.addMethod("cat_referance", function(value, element) { 
			var cat_checked = $("input[id=cat_ref]:checked").length;alert(cat_checked);
			if(cat_checked==0){
				return true;
			}else{
				return false;
			}
	},"testing category");

jQuery.validator.addMethod("letterspaceonly", function(value, element) {
	return this.optional(element) || /^([a-z]+([\s][a-z]+)?)+$/i.test(value);
	}, "Letters and Single space only");



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

	$("#frmUserProfile").validate({
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
			rel_status:{
				required: true
			},
			email:{
				required: true,
				email: true,
			    remote: {url:SITEROOT + "/admin/user/ajax_check_user.php?userid="+useridd , type:"post"}
			},
			password:{
			    minlength: 6,
			    maxlength: 20
			},
			gender:{
				required:true
			},
			photo:{
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
			password:{
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			},
			gender:{
				required: "Please select gender"
			},
			photo:{
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
