function keyCatch(e){
	var charCode = (e.which) ? e.which : window.event.keyCode;
	if(charCode == 13){
		searchUser();
	}
}
function changeord(type)
{
	document.getElementById("sorttype").value=type;
	if(document.getElementById("sortord").value == "")
		document.getElementById("sortord").value = "DESC";
	else if(document.getElementById("sortord").value == "ASC")
		document.getElementById("sortord").value = "DESC";
	else
		document.getElementById("sortord").value = "ASC";
	searchUser();

}
function searchUser(page) {

	document.getElementById("UserListDiv").innerHTML = "";
	var sorttype = sorttype || document.getElementById("sorttype").value;
	var sortord = sortord || document.getElementById("sortord").value;
	var searchuser = document.getElementById("searchuser").value;

	var pg;

	var executepage = "ajax_user_list.php";
	if(page){
		$.getJSON(executepage, {searchuser:searchuser, sorttype:sorttype, sortord:sortord, page:page}, function(data){
			$("#UserListDiv").html(data.searchcontent);
		});
	}
	else{
		$.getJSON(executepage, {searchuser:searchuser, sorttype:sorttype, sortord:sortord}, function(data){
			$("#UserListDiv").html(data.searchcontent);
		});
	}

}

function callbackUserFill(data) {
	document.getElementById("UserListDiv").innerHTML = data.searchcontent;
}