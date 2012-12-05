$(document).ready(function(){
        $("#frmPhoto").validate({
		errorElement:'div',
		rules:{
			pimage:{
				accept: "jpg|jpeg|gif|png"
			}
		},
		messages:{
			pimage:{
                                accept: "Please provide valid image format"
			}
		},
		success: function(label) {
			// set &nbsp; as text for IE
		        label.hide();
		}

	});

});
