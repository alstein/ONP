$(document).ready(function(){



	$("#frmprofile").validate({
		errorElement:'div',
		rules: {
			album_name:{
				required: true,
				minlength:2,
				maxlength:50
			},
			description: {
			//	required: true,
				minlength:2,
				maxlength:40
			},
			Filedata: {
				//required: true,
				accept:".jpg|.jpeg|.png|.gif|.bmp"
			}
		},
		messages: {
				album_name:{
				required: "Please enter album name",
				minlength:"Please enter atleast 2 characters",
				maxlength:"Please enter atmost 10 characters"
			},
			description: {
				//required: "Please enter album description",
				minlength:"Please enter atleast 2 characters",
				maxlength:"Please enter atmost 40 characters"
			},
			Filedata: {
				//required: "Please uplaod image",
				accept:"Please enter valid image type"
			}
		}
		
	});
});
