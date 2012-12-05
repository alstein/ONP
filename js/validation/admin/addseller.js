
$(document).ready(function(){

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
			var sthr = parseInt($("#start_hour").val());
			var stmin = parseInt($("#start_min").val());
			var endhr = parseInt($("#end_hour").val());
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

        $("#frmRegistration").validate({
		errorElement:'div',
		rules:{

			email:{
				required: true,
				email: true,
				emailchk:true,
				remote: SITEROOT + "/admin/user/ajax_check_whole_user.php"
		        },
			password:{
				required: true,
				noSpace:true,
				minlength: 6,
				maxlength: 20
				
			},
			cpassword:{
				required: true,
				equalTo: "#password"
			},
			address1:{
				required: true,
				minlength: 3,
				maxlength:500
			},
			city:{
				required: true,
				alphaOnly:true
				
				
			},
			county:{
				required: true
				
			},
			business_webURL:{
				//required: true,
				url_double_dot: true,
				url:true,
				maxlength: 200
				 
				
			},
			about_business:{
				required: true,
				minlength: 3,
				maxlength: 800
			},
			contact_detail:{
				required: true,
				number:true,
			//	minlength: 10,
				maxlength: 12
			},

			business_name:{
                                required: true	
			},
			contact_person:{
				required: true,
				minlength: 3,
				maxlength: 100,
				alphaOnly:true
			},
			about_us:{
				required: true,
				maxlength:500
			},
			maincategory:{
				required: true
			},
			subcategory:{
				required: true	
			},
			specility:{
				required: true,
				maxlength:500
			},
			price_menu_list:{
				required: true,
				//accept:"PDF|pdf|doc|DOC|jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG|xls|XLS|docx|DOCX"
				accept:"jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG|PDF|pdf|doc|DOC|xls|XLS|docx|DOCX"
				
			},
			upload_photo:{
				required: true,
				//accept:"PDF|pdf|doc|DOC|jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG|xls|XLS|docx|DOCX"
				accept:"jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG"
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
			password: {
				required: "please enter password",
				noSpace: "Space is not allowed",
				minlength: $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter at least {0} characters")
			},
			cpassword: {
				required: "please enter confirm password",
				equalTo: "please enter password same as above"
			},
			address1:{
				required: "Please enter address.",
				minlength: $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			city:{
				required: "Please enter Town/City.",
				alphaOnly:  "Please enter valid Town/City name"
			},
			county:{
				required: "Please select County."
			},
			business_webURL:{
				//required: "Please enter website URL.",
				maxlength: $.format("Enter maximum {0} characters"),
				url:"Please enter correct format website URL."
			},
			about_business:{
				required: "Please enter about your business",
				minlength: $.format("Enter maximum {0} characters"),
				maxlength:  $.format("Enter maximum {0} characters")
			},
			contact_detail:{
				required: "Please enter phone number.",
				minlength: $.format("Enter maximum {0} characters"),
				maxlength:  $.format("Enter maximum {0} characters"),
				number: "Please enter valid phone number."
				
			},
			business_name:{
                                required: "Please enter business name."
			},
			contact_person:{
				required: "Please enter contact person",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			},
			about_us:{
				required: "Please enter about us.",
				maxlength: $.format("Enter maximum {0} characters")
			},
			maincategory:{
				required: "Please select deal category"
			},
			subcategory:{
				required: "Please select deal subcategory"
			},
			specility:{
				required: "Please enter specility.",
				maxlength: $.format("Enter maximum {0} characters")
			},
			price_menu_list:{
				required: "Please upload price menu list."
			},
			upload_photo:{
				required: "Please upload photo."
			}
		}
	});


    $("#frmRegistration").submit(function()
	{

            var StartDate1 = new Date($('#from1_Year_ID').val(), $('#from1_Month_ID').val(), $('#from1_Day_ID').val());
            var EndDate1 = new Date($('#to1_Year_ID').val(), $('#to1_Month_ID').val(), $('#to1_Day_ID').val());
			
			 if(StartDate1 > EndDate1)
			 {
				     var error = 'yes';
					 $('#tr1').show();
                     $('#error_EndDate1').show();
                     $('#error_EndDate1').html("To Date should be greater than or equal to From Date");
			 } 

            var StartDate2 = new Date($('#from2_Year_ID').val(), $('#from2_Month_ID').val(), $('#from2_Day_ID').val());
            var EndDate2 = new Date($('#to2_Year_ID').val(), $('#to2_Month_ID').val(), $('#to2_Day_ID').val());
			
			 if(StartDate2 > EndDate2)
			 {
				     var error = 'yes';
					 $('#tr2').show();
                     $('#error_EndDate2').show();
                     $('#error_EndDate2').html("To Date should be greater than or equal to From Date");
			 } 


			if(error=='yes')	
				return false;
			else
				return true;
    });






});

