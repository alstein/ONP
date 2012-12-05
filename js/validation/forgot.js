$(document).ready(function()
{
   $("#frmforgot").validate(
   {
      errorElement:'div',
      rules: 
      {
         email:
         {
            required: true,
            email: true
         }
      },
      messages: 
      {
         email:
         {
            required: "Enter email address",
            email: "Enter correct email address"
         }
       
      }
   });
});
