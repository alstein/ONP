$(document).ready(function(){

        $.validator.addMethod("check_email", function(value, element) {

	var ides=$('#recipient_list').val();

	if(ides=="")
		return false;

	var idesarr=ides.split(',');

	var cnt=idesarr.length;
	for(i=0;i<cnt;i++)
	{
		var filter = /^([\sa-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
		//trim
		function trim(stringToTrim) 
            {
		    return stringToTrim.replace(/^\s+|\s+$/g,"");
		}
		idesarr[i]=trim(idesarr[i]);
		//end

		if (!filter.test(idesarr[i]))
		    return false;
	}
	return true;
    });

    $("#frminvite").validate({
        errorElement:'div',
        rules: {
		recipients:{
		    check_email: true
		},
                message:{
		    maxlength: 500
                }
        },
        messages: {
		recipients: {
		    check_email: "Please enter valid email addresses separated by commas eg:- abc@abc.com,def@abc.com"
		},
                message:{
		    maxlength: jQuery.format("Please enter at most {0} characters")
                }
	}
    });

});