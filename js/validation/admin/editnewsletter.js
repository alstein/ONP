$(function() {
	
	$('#startdate').datepicker({
		duration: '',
		dateFormat:'yy-mm-dd',
		showTime: true,
		constrainInput: false,
		stepMinutes: 1,
		stepHours: 1,
		altTimeField: '',
		time24h: true
	});
});

function displayUsers(cityid){
		$.post("daily_emails_users.php",{cityid:cityid},function(data){
			$("#users").html(data);
	});
}
$(document).ready(function()
{
var did =$('#did').val();
if(did)
{		

		$.post("demo.php",function(data){$("#demo").html(data)});
}
});
