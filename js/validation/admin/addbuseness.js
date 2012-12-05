$(document).ready(function(){
   
jQuery.validator.addMethod("noSpace", function(value, element) { 
  return value.indexOf(" ") < 0 && value != ""; 
}, "Only A-Z, a-z & _ is allowed without space");

$.validator.addMethod("noSpecialChars", function(value, element) {
       return /^[a-zA-Z\_]+$/i.test(value);
}, "Only A-Z, a-z & _ is allowed without space");

jQuery.validator.addMethod("zipcode", function(value, element) { 
  return /^\d{5}(-\d{4})?$/.test(value);
}, "Please enter valid Postcode");


  $("#frmRegistration").validate({
    errorElement:'div',
    rules: {
      businessname:{
              required: true,
              minlength: 2,
              maxlength:50,

      },

      cname:{
              required: true,
              minlength: 2,
              maxlength:50,
              //noSpace:true,
            //noSpecialChars:true
      },
      state:{
              required: true,
              minlength: 2,
              maxlength:50

      },
      email:{
              required: true,
              email: true
             
      },
      city:{required: true},
      wsite:{required: true},
	phone:{required: true},
	comment:{required: true},
      zipcode:{
               required: true,
               zipcode:true
               }
    },
    messages: {
        businessname:{
                required: "Please enter business name",
                minlength:  $.format("Enter at least {0} characters"),
                maxlength: $.format("Enter maximum {0} characters")
        },
        cname:{
                required: "Please enter contact name",
                minlength: $.format("Enter at least {0} characters"),
                maxlength: $.format("Enter maximum {0} characters")
        },
        state:{
                required: "Please enter state name",
                minlength: $.format("Enter at least {0} characters"),
                maxlength: $.format("Enter maximum {0} characters")
        },
        email:{
                required: "Please enter email address",
                email: "Please enter correct email address"
        },
        city:{required: "Please Select city"},
        wsite:{required: "Please enter website"},
        phone:{required: "Please enter phone"},
        comment:{required: "Please enter comment"},
        zipcode:{required:"Please enter postcode"}
      
         }
  });
});

function changeit(val){
// alert(val);
  if(val == 4 || val == 3 || val == 6 ){
          document.getElementById('hidden_id').style.display='';
          ajax.sendrequest("GET", SITEROOT+"/admin/user/get_city.php", {val:val}, '', 'replace');
  }else{
          document.getElementById('hidden_id').style.display='none';
  }
}

function getCity(val){
        ajax.sendrequest("GET", SITEROOT+"/admin/user/get_city.php", {val:val}, '', 'replace');
}

function add_cities(){
    var city = document.getElementById('city').value;
    if(city != ''){
            var state = document.getElementById('state').value;
            ajax.sendrequest("POST", SITEROOT+"/admin/user/add_city.php", {city:city,state:state}, '', 'display_cities');
    }else{
            alert("Please select city");
            return false;
    }
}

function removecity(val){
  var val1 = 'add_city_'+val;
  var val2 = 'name_city_'+val;
  var val_city = document.getElementById(val2).innerHTML;
  var state_id = "id_state_"+val;
  var stateid = document.getElementById(state_id).value;
  document.getElementById(val1).style.display = 'none';
  ajax.sendrequest("POST", SITEROOT+"/admin/user/add_city.php", {remove_city:val_city,stateid:stateid}, '', 'display_cities');
}
