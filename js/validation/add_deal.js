$(document).ready(function(){

// $.validator.addMethod("morevalue", function(value, element) {
// var fristtextbox = $('.price').val();
// return parseFloat(price) < parseFloat(originalprice);
// }, "orignal price should be greater than price.");

             $("#dealfrm").validate({
		errorElement:'div',
		rules: {
			category:{
				required: true	
			},
			subcategory: {
				required: true
			},
			subcategory: {
				required: true
			},
                        title:{
				required: true,
			},
			price:{
				required: true,
				number: true
			},
			originalprice:{
				required: true,
				number: true
			},
                        min_buyer:{
				required: true,
				number: true
			},
			max_buyer:{
				required: true,
				number: true
			},
			desc:{
				required: true,
				maxlength: 500
			},
			highlight:{
				required: true
				
			},
			fineprint:{
				required: true
			}
		},
		messages: {
			category:{
				required: "Please select deal category"
			},
			subcategory:{
				required: "Please select sub category"
			},
			title:{
				required: "Please enter title"
			},
                       	price:{
				required: "Please enter group buy price",
				number: "Please enter numbers only."
			},
			originalprice:{
				required:"Please enter original price",
				number: "Please enter numbers only."
			},
                        min_buyer:{
				required:"Please enter minimum buyers ",
				number: "Please enter numbers only."
			},
			max_buyer:{
				required:"Please enter maximum buyers ",
				number: "Please enter numbers only."
			},
			desc:{
				required:"Please enter description ",
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			highlight:{
				required:"Please enter highlights "
				
			},
			fineprint:{
				required:"Please enter fine print"
			}
		}
		
	});

//         $("#dealfrm").submit(function(){
// 
//             if((document.getElementById('deal_type1').checked == false) && (document.getElementById('deal_type2').checked == false))
//             {
//                 $('#dealtype_err').show();
//                 $('#dealtype_err').addClass('error');
//                 $('#dealtype_err').html("Please select deal type.");
//                 return false;
//             }


            /*var d1=$('#sdate').val();
            var s1=$('#start_hour').val();
            var m1=$('#start_min').val();

            var d2=$('#edate').val();
            var s2=$('#end_hour').val();
            var m2=$('#end_min').val();


            var syear = d1.substring(0,4);
            var smonth = d1.substring(5,7);
            var sday = d1.substring(8,10);

            var eyear = d2.substring(0,4);
            var emonth = d2.substring(5,7);
            var eday = d2.substring(8,10);

            var sd = new Date(syear,(smonth-1),sday);
            var ed = new Date(eyear,(emonth-1),eday);
            var cd = new Date();

            if(sd.getTime() > ed.getTime())
            {
                $('#err_date').show();
                $('#err_date').addClass('error');
                $('#err_date').html("Start date should be less than end date.");
                return false;
            }
            else if(cd.getTime() > ed.getTime())
            {
                $('#err_date').show();
                $('#err_date').addClass('error');
                $('#err_date').html("End date should be greater than current date.");
                return false;
            }
            else
            {
                $('#err_date').hide();
                $('#err_date').removeClass('error');
                $('#err_date').html("");
            }*/
//             return true;
//         });

});
