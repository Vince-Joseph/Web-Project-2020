
//password check function
function check_password(password,c_password)
 {
     var error_match = document.getElementById('error_user_pwd');
     var error_format=document.getElementById('error_user_pwd_format');
   var given_password = document.getElementById(password);
   var given_c_password = document.getElementById(c_password);
   var button=document.getElementById('user_register');
   
   var passformat = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
  
   if(passformat.test(given_password.value))
   {
          if (given_c_password.value!=given_password.value) 
          {
            error_match.style.display = "block";
            button.disabled = true;
           
            //return false;
          }
          else
          {
            error_match.style.display = "none";
            button.disabled = false;
            //return true;
          }
          error_format.style.display = "none";
         // button.disabled= false;
   }
   else
   {
        error_format.style.display = "block";
        button.disabled = true;
        given_password.focus();
      //return false;
   }
 }

 function check_phone(id,error_id)
{ 
 
  var checkPhone=document.getElementById(id);
  var error_phone=document.getElementById(error_id);
   var phonePatt=/^[6-9]\d{9}$/;
  //alert(checkPhone.value);
  	if(phonePatt.test(checkPhone.value))
   {
      error_phone.style.display="none";
      
   }
  else 
  { //alert(error_phone.id);
          error_phone.style.display="block";
           checkPhone.focus();
    
  }
// }

}
