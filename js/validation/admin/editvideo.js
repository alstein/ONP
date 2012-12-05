$(document).ready(function()
{

//  $.validator.addMethod('positiveNumber',
//     function (value) { 
//         return Number(value) > 0;
//     }, 'Enter a positive number.');
    
//     $.validator.addMethod("numGreatZero", function(value, element){
//                 var temp;
//                 temp = true;
//                 temp = !(value<=0);
//                 return temp;
//          }, "Please enter value use be greater than zero(0)");



    $.validator.addMethod("chkvideotype", function(value, element){
                var temp = document.getElementById('videotype').checked;
//                 alert(temp);
                return true;
         }, "Please enter value use be greater than zero(0)");

    
    $("#home_form").validate({
        errorElement:'div',
        rules: {
                    videotitle:
                            {
                            	required: true
                            },
                    videotype:
                            {
                            	required: true
                            },
                    video:
                            {/*
                            	required: function(value, element){
                                                var temp = document.getElementById('videotype').checked;
                                                // alert(temp);
                                                return temp;
                                            },*/
                            	accept: "mp4"
                            	
                            },
                   videolink:
                            {
                            	required: function(value, element){
                                                var temp = document.getElementById('videotypee').checked;
                                                // alert(temp);
                                                return temp;
                                            }
                            },
                   status:
                            {
                            	required: true
                            	
                            }
                
                },
                     messages:
                        {
                    videotitle:
                            {
                                required: "Please enter video title"
//                                 remote: "This package name is already in use."
                            },
                    videotype:
                            {
                                required: "Please select video type"
                                
                            },
                    video:
                            {
                                required: "Please upload .mp4 file.",
                                accept: "Please provide valid file format"
                                
                            },
                   videolink:
                            {
                                required: "Please enter video link"
                               
                            },
                  status:
                            {
                                required: "Please select status"
                                
                            }
               
                        }
                                });

});