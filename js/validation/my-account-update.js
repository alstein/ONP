$(document).ready(function() {
	jQuery.validator.addMethod("noSpace", function(value, element) {
		return value.indexOf(" ") < 0 && value != "";
	},"Space is not allowed");

	jQuery.validator.addMethod("noSpaceForPass", function(value, element) {
		return value.indexOf(" ") < 0;
	},"Space is not allowed");

	$.validator.addMethod("alphaOnly", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z -]/;
                temp = !str.test(value);
                return temp;
         }, "Only a to z, A to Z and - is allowed.");

          $.validator.addMethod("numbersonly",
	function(value, element)
	{
		return this.optional(element) || /^[0-9]+$/i.test(value);
	}, "Enter number only");

	jQuery.validator.addMethod("emailchk", function(value, element) {
			var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			return rege.test($('#email').val());
	},"Please enter valid email address");

    /*$.validator.addMethod("postcodes",function(value, element) {
            var regularex="^([a-zA-Z]){1}([0-9][0-9]|[0-9]|[a-zA-Z][0-9][a-zA-Z]|[a-zA-Z][0-9][0-9]|[a-zA-Z][0-9]){1}([        ])([0-9][a-zA-z][a-zA-z]){1}$";
					var check = false;
            var re = new RegExp(regularex);
            return this.optional(element) || re.test(value);
        },
        "Please enter a valid postcode."
    );*/
    $.validator.addMethod("postcodes", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z0-9 ]/;
                temp = !str.test(value);
                return temp;
         }, "Only 0 to 9, a to z, A to Z and space is allowed.");

	$('#frmregistration').validate({
		errorElement:'div',
		rules: {
			first_name:{
				required:true,
				minlength: 4,
				maxlength: 50,
				noSpace: true,
				alphaOnly: true
			},
			last_name:{
				required:true,
				minlength: 4,
				maxlength: 50,
				noSpace: true,
				alphaOnly: true
			},
			address1:{
				required:true
			},
			address2: {
				maxlength: 200
			},
			email:{
				required: true,
				email: true,
				emailchk: true,
				minlength: 4,
				maxlength: 50,
 				remote: SITEROOT + "/modules/registration/ajax_check_user.php?userid="+$("#userid").val()
			},
			password:{
				minlength: 6,
				maxlength: 20,
				noSpaceForPass: true
			},
			re_password: {
				equalTo:'#password'
			},
			countryid: {
				required: true
			},
			state_id: {
				required: true
			},
			city: {
				required: true/*,
				alphaOnly: true*/
			},
			postalcode: {
				required: true,
				postcodes: true,
				minlength: 6,
				maxlength: 8
			},
// 			terms: {
// 				required: true
// 			},
			p_card_holder_f_name: {
				minlength: 2,
				maxlength: 50,
				noSpaceForPass: true,
				alphaOnly: true
			},
			p_card_holder_l_name: {
				minlength: 2,
				maxlength: 50,
				noSpaceForPass: true,
				alphaOnly: true
			},
			p_sec_code: {
				minlength: 3,
				maxlength: 4,
				noSpaceForPass: true,
				numbersonly: true
			},
			p_credit_card_no: {
				minlength: 13,
				maxlength: 16,
				noSpaceForPass: true,
				numbersonly: true
			},
// 			b_add1: {
// 				minlength: 5,
// 				maxlength: 200
// 			},
//			b_add2: {
//				maxlength: 200
//			},
// 			b_city: {
// 				minlength: 2,
// 				maxlength: 50,
// 				alphaOnly:  true
// 			},
// 			b_zip_code: {
// 				postcodes: true,
// 				minlength: 6,
// 				maxlength: 8
// 			},
			s_add1: {
				minlength: 5,
				maxlength: 200
			},
			s_add2: {
				maxlength: 200
			},
			s_city: {
				//minlength: 2,
				//maxlength: 50/*,
				//alphaOnly:  true*/
			},
			s_zip_code: {
				postcodes: true,
				minlength: 6,
				maxlength: 8
			}
		},
		messages: {
			first_name:{
				required: "Please enter first name",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
				noSpace:  "Please enter valid first name",
				alphaOnly:  "Please enter valid first name"
			},
			last_name:{
				required: "Please enter last name",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
				noSpace:  "Please enter valid last name",
				alphaOnly:  "Please enter valid last name"
			},
			address1:{
				required: "Please enter address"
			},
			address2: {
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			email:{
				required: "Please enter an email address",
				email: "Please enter a valid email address",
				emailchk: "Please enter a valid email address",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
				remote: "This email address is already registered"
			},
			password:{
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			re_password: {
				equalTo: "Please enter the same password as above"
			},
			countryid: {
				required: "Please select country"
			},
			state_id: {
				required: "Please select state"
			},
			city: {
				required: "Please select city/town"/*,
				alphaOnly:  "Please enter valid city/town name"*/
			},
			postalcode: {
				required: "Please enter post code/zip code",
				postcodes: "Please enter valid post code/zip code",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
// 			terms: {
// 				required: "Please accept the terms and conditions"
// 			},
			p_card_holder_f_name:{
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
				alphaOnly:  "Please enter valid first name"
			},
			p_card_holder_l_name:{
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
				alphaOnly:  "Please enter valid last name"
			},
			p_sec_code: {
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
				numbersonly: "Please enter valid security code"
			},
			p_credit_card_no: {
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
				numbersonly: "Please enter valid card number"
			},
// 			b_add1: {
// 				minlength: jQuery.format("Enter at least {0} characters"),
// 				maxlength: jQuery.format("Enter at most {0} characters")
// 			},
// 			b_add2: {
// 				maxlength: jQuery.format("Enter at most {0} characters")
// 			},
// 			b_city: {
// 				minlength: jQuery.format("Enter at least {0} characters"),
// 				maxlength: jQuery.format("Enter at most {0} characters"),
// 				alphaOnly:  "Please enter valid city/town name"
// 			},
// 			b_zip_code: {
// 				postcodes: "Please enter valid post code/zip code",
// 				minlength: jQuery.format("Enter at least {0} characters"),
// 				maxlength: jQuery.format("Enter at most {0} characters")
// 			},
			s_add1: {
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			s_add2: {
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			s_city: {
				//minlength: jQuery.format("Enter at least {0} characters"),
				//maxlength: jQuery.format("Enter at most {0} characters")/*,
				//alphaOnly:  "Please enter valid city/town name"*/
			},
			s_zip_code: {
				postcodes: "Please enter valid post code/zip code",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			}
		},
	      success: function(label) {
		      // set &nbsp; as text for IE
		      label.hide();
	      }
	});
});


//function for Shipping Information is Same as billing address
function fun_shipaddrsameasbilladdr()
{

   if(document.getElementById("chksameasbilladdr").checked==true)
   {
   
      //var stValue = $("#state_id").val();
      // var stText = $("#state_id :selected").text();
      // alert(stValue);
       //alert(stText);
//       $('#s_state').append('<option value='+stValue+'>'+stText+'</option>');
//       $('#s_state').val(stValue);
   
     $("#s_add1").val($("#address1").val());
     $("#s_add2").val($("#address2").val());
    // $("#s_city").val($("#city").val());
     $("#s_zip_code").val($("#postalcode").val());
     //$("#s_state").append($("#state_id").val());
     $('#s_state').append('<option value='+$("#state_id").val()+' selected="selected">'+$("#state_id :selected").text()+'</option>');
     $('#s_city').append('<option value='+$("#city").val()+' selected="selected">'+$("#city :selected").text()+'</option>');
     //$("#s_state").val($("#state_id").val());
     $("#s_countryid").val($("#countryid").val());
   }else
   {
     $("#s_add1").val('');
     $("#s_add2").val('');
     $("#s_city").val('');
     $("#s_zip_code").val('');
     $("#s_state").val('');
     $("#s_countryid").val('');
   }
   return false;
}

//$('#s_state').append($("#state_id").val());
//$('#s_state').append('<option value="foo" selected="selected">Foo</option>');
