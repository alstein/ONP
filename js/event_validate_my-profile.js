/******************** Validation for Edit Event ******************/
function validation()
{

//current date calculation
var curdate=new Date();	
var day = curdate.getDate();
var month = curdate.getMonth() + 1;
var year = curdate.getFullYear();
var current_date= year + "-" + month + "-" + day;
var temp_current = current_date.split('-');
var cd=new Date(temp_current[0]+","+temp_current[1]+","+temp_current[2]);
var current_date_ms = cd.getTime();




	dof=document.frmprofile;
	
	/********** Get the date  *************/
	var date1 = dof.birthdate.value;
	
	var temp = date1.split('-');
	var fr=new Date(temp[0]+","+temp[1]+","+temp[2]);

	var ONE_DAY = 1000 * 60 * 60 * 24;

	// Convert both dates to milliseconds
	var date1_ms = fr.getTime();
	if(parseInt(current_date_ms) < parseInt(date1_ms))
	{
		alert("Birth date should be less than current date.");
		return false;
	}
	return true;
}