
function removeimage(){
   var x=window.confirm("Are you sure want to remove profile photo?")
   if (x){
      $.post(SITEROOT + '/my-account/remove-photo',{},function(data){
               $('#removeimg').html('<span class="Success"><strong>Profile photo removed</strong></span>');
            },'html');
   }else{
      
   }
}