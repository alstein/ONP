/******************** Validation for Edit Event ******************/
function validation(id)
{
var days=id;
// alert(id);


//current date calculation
var curdate=new Date();	
var day = curdate.getDate()
var month = curdate.getMonth() + 1;
var year = curdate.getFullYear()
var current_date= year + "-" + month + "-" + day;
var temp_current = current_date.split('-');
var cd=new Date(temp_current[0]+","+temp_current[1]+","+temp_current[2]);
var current_date_ms = cd.getTime();




	dof=document.dealfrm;
	
	/********** Get the date  *************/
	var date1 = dof.sdate.value;
	var date2 = dof.edate.value;
	
var temp = date1.split('-');
var temp1 = date2.split('-');
var fr=new Date(temp[0]+","+temp[1]+","+temp[2]);
var fr1=new Date(temp1[0]+","+temp1[1]+","+temp1[2]);

	

  var ONE_DAY = 1000 * 60 * 60 * 24;

    // Convert both dates to milliseconds
    var date1_ms = fr.getTime();
    var date2_ms = fr1.getTime();
	
	//alert("current " + current_date_ms);	
	//alert("start " + date1_ms);	
		
//     // Calculate the difference in milliseconds
    var difference_ms = Math.abs(date1_ms - date2_ms);

//     alert(Math.round(difference_ms/ONE_DAY));
//     // Convert back to days and return
   var totalval=Math.round(difference_ms/ONE_DAY);
		
		
            if(current_date_ms > date1_ms)
            {
            alert("Deal start date must not be in the past.");
            dof.start_hour.focus();
            return false;
            }
	     else	
            if(totalval >= days  && days !='')
            {

            alert("Deal End Date must be within "+days+" days from start date.");
            dof.edate.focus();
            return false;
            }

    return true;
}