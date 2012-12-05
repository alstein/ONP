$(document).ready(function(){
jQuery.validator.addMethod("zipcode", function(value, element) { 
  return /^[0-9]+$/.test(value);
}, "Enter only digits");

////FCK editor validation code --->>>Nilesh G. Pangul 19/10/2010 ////////////////////////
if(typeof jQuery.fn.fckEditorValidate =='function'){
jQuery.fn.fckEditorValidate({instanceName:'description',validationErrorClass: 'error',validationErrorMessage: 'Provide a description.'
});
}

if(typeof jQuery.fn.fckEditorValidate =='function'){
jQuery.fn.fckEditorValidate({instanceName:'highlight',validationErrorClass: 'error',validationErrorMessage: 'Provide a highlight.'
});
}

if(typeof jQuery.fn.fckEditorValidate =='function'){
jQuery.fn.fckEditorValidate({instanceName:'fineprint',validationErrorClass: 'error',validationErrorMessage: 'Provide a fine print.'
});
}
////end fck validation code

$("#frm").validate({
    errorElement:'div',
    rules: {
               cities:{
               required:true
               },
               merchant_id:{
               required:true
               },
               merchant_sub_id:{
               required:true
               },
               deal_product_id:{
               required:true
               },
               title:{
               required:true
               },
               youtube_link:{
               required:true
               },

               website:{
               required:true
               },
               address:{
               required:true
               },
               price:{
               zipcode:true
               },
               cupon_price:{
               zipcode:true
               },
               orignal_price:{
                zipcode:true
               },
               rrp_group_price:{
               zipcode:true
               },
               quantity:{
               zipcode:true
               },
               min_buyer:{
               zipcode:true
               },
               max_buyer:{
               zipcode:true
               },
               max_purchase:{
               zipcode:true
               }
          }

});

});
