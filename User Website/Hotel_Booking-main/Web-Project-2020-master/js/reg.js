function validation1()
{
	if(password())
	{
		if(phone())
		{
			return true;
			alert("form submitted sucessfully");
		}

	}
	else
	{
		return false;
	}

}

function password()
 {
 	var error = document.getElementById('error_pswrd');
   var pswd1 = document.getElementById('pass1').value;
   var pswd2 = document.getElementById('pass2').value;
   var passformat = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
   if(passformat.test(pswd1))
   {
   if(pswd2=='')
    {
      alert("confirm password empty");
      document.getElementById("pass2").focus();
      return false;
    }
    else if (pswd1!=pswd2) 
    {
      alert("passwords doesnt match");
      return false;
    }
    else
    {
    error.style.display = "none";
      return true;
    }
   }
   else if (pswd1=='') 
   {
     alert("password empty");
     return false;
   }
   else
   {
   	error.style.display = "block";
   //alert("You have entered an invalid password.Password should contain at least 7 characters, including at least one digit, one special character, and one uppercase letter.");
   document.getElementById("pass1").focus();
   return false;
   }
 }

 function phone()
{ 
	var checkPhone=document.getElementById('phn1').value;
   var phonePatt=/^[6-9]\d{9}$/;
   if(checkPhone=='')
   {
     alert("Phone Number empty");
     document.getElementById("phn1").focus();
     return false;
   }
   else 
   {
  	if(phonePatt.test(checkPhone))
   {

      return true;
   }
  else {
    alert(" Phone Number wrong ");
    document.getElementById("phn1").focus();
     return false;
  }
}

}


function validation2()
{
	if(pswrd())
	{
		if(phn())
		{
			alert("form submitted sucessfully");
		}
	}
}

function pswrd()
 {
   var pwd1 = document.getElementById('pass3').value;
   var pwd2 = document.getElementById('pass4').value;
   var format = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
   if(format.test(pwd1))
   {
   if(pwd2=='')
    {
      alert("confirm password empty");
      document.getElementById("pass4").focus();
      return false;
    }
    else if (pwd1!=pwd2) 
    {
      alert("passwords doesnt match");
      return false;
    }
    else
    {
      return true;
    }
   }
   else if (pwd1=='') 
   {
     alert("password empty");
     return false;
   }
   else
   {
   alert("You have entered an invalid password.Password should contain at least 7 characters, including at least one digit, one special character, and one uppercase letter.");
   document.getElementById("pass3").focus();
   return false;
   }
 }

 function phn()
{ 
	var checkPhn=document.getElementById('phn2').value;
   var phnPatt=/^[6-9]\d{9}$/;
   if(checkPhn=='')
   {
     alert("Phone Number empty");
     document.getElementById("phn2").focus();
     return false;
   }
   else 
   {
  	if(phnPatt.test(checkPhn))
   {

      return true;
   }
  else {
    alert(" Phone Number wrong ");
    document.getElementById("phn2").focus();
     return false;
  }
}

}