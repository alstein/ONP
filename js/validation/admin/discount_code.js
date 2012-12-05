$(document).ready(function(){
var id = $('#id').val();
jQuery.validator.addMethod("url_double_dot", function(value, element) {
			for(var i=0; i<value.length; i++)
			{
				if(value[i] == '.' && value[(parseInt(i)+1)] == '.')
					return false;
			}
			return true;
		},"Please enter valid URL");

	$("#frm").validate({
		errorElement:'div',
		rules: {
			iMerchantId:{
				required: true,
				number: true,
				maxlength: 50
			},
			iMerchantName:{
				required: true,
				maxlength: 50,
				accept : "[a-zA-Z]"
			},
			discution:{
				required: true,
				maxlength: 200
			},
			discount_code:{
				required: true,
				maxlength: 50,
				remote: {url:SITEROOT + "/admin/modules/affiliate-marchant/ajax_check_marchant.php?id="+id, type:"post"}
			},
			image:{ 
// 			required: function(){
//                                         if($('#image_chk').val() =='')
//                                         {
//                                             return true;
//                                         }else
//                                         {
//                                             return false;
//                                         }
//                                      },
                                accept: ".jpg,.gif,.png,.jpeg"
                            },
			url:{				
                            	required: true,
                            	url_double_dot: true,
				url:true
			}
		},
		messages: {			
			iMerchantId:{
				required: "Please enter merchant id",
				maxlength: $.format("Enter maximum {0} characters"),
				number: "Enter only numeric value"
			},
			iMerchantName:{
				required: "Please enter merchant name",
				maxlength: $.format("Enter maximum {0} characters"),
				accept: "Enter only alphabetical characters"
			},
			discution:{
				required: "Please enter discount details. ",
				maxlength: $.format("Enter maximum {0} characters")
			},
			discount_code:{
				required: "Please enter discount code. ",
				maxlength: $.format("Enter maximum {0} characters"),
				remote: "This discount code is already in use"
			},
			image:{
				//required: "Please select image",
				accept: "Please provide valid image format."
				
			},
			url:{
				required: "Please enter url link.",
                                url:"Please enter correct format link."
				
			}
		}
	});
	$("#msg").fadeOut(5000);

});
 