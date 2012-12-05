$(document).ready(function()
{
    $("#frmRegistration").validate({
      errorElement:'div',
	rules: {
		catname:{required:true},
		qes:{required:true,minlength:1,maxlength:200},
		ans:{required:true}
                },
		messages:{
			catname:{required:"Please select category"},
			qes:{required:"Please enter Question",minlength:"Enter at least 1 characters",maxlength:"Enter maximum 200 characters"},
			ans:{required:"Please enter Answer"}
			}
});

});
