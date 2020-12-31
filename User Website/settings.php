<?php

?>

<?php
  require("connection_file.php");

  session_start();
  $user_id=$_SESSION['user_id']; //getting id of current user
  
  if(!isset($_SESSION['user_id'])){
    //header("Location: payment.php");
    header("Location: user login.php");
  }
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Settings</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic:400,700,800" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/rangeslider.css">

    <link rel="stylesheet" href="css/style.css">

    <style>
      #save,#cancel,#mobile-valid,#mobile-invalid,#pwd-invalid
      {
        display:none;
      }
    </style>
    
</head>
  <body>
  
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    <div class="bg-dark py-5">
    <header class="site-navbar container py-0 bg-white" role="banner">

        <div class="container"> 
          <div class="row align-items-center">
            
            <div class="col-6 col-xl-2">
              <h1 class="mb-0 site-logo"><a href="#" class="text-black mb-0">Project<span class="text-primary">Name</span>  </a></h1>
            </div>
            <div class="col-12 col-md-10 d-none d-xl-block">
              <nav class="site-navigation position-relative text-right" role="navigation">
  
                <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                  <li class="active"><a href="index.php">Home</a></li>
                  <!-- <li><a href="blog.html">About Us</a></li> -->
                  <li><a href="aboutus.php">About Us</a></li>
                  <li><a href="contact.php">Contact</a></li>
                    <li class="has-children border-left pl-xl-4">
                    <a href="">Account</a>
                    <ul class="dropdown">
                      <li><a href="history.php">History</a></li>
                      <li><a href="#">Settings</a></li>
                      <li><a href="view_booked_details.php">Booking Details</a></li>
                      <li><a href="logout.php">Sign out</a></li>
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="d-inline-block d-xl-none ml-auto py-3 col-6 text-right" style="position: relative; top: 3px;">
              <a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a>
            </div>
          </div>
        </div> 
    </header>
      <br>
    </div>
    <div class="site-section bg-light">
       
      <div class="container">
        <div class="row">
        <?php
        if(isset($_POST['save']))
         {
              $original_name=$_POST['name'];
              $user_name=$_POST['username'];
              $gender=$_POST['gender'];
              $mobile=$_POST['phone'];
              $password=$_POST['password'];

              //echo $original_name,$user_name,$gender,$mobile,$password;
              $sql_update_details=$db_connection->prepare("UPDATE user SET original_name=?,gender=?,user_name=?,mobile=?,
              password=? WHERE id=?");
              $sql_update_details->bind_param("sssssi",$original_name,$gender,$user_name,$mobile,$password,$user_id);

            if($sql_update_details->execute())
            {
              ?>
                <div class="col-sm-12">
                  <div class="alert alert-success alert-dismissible">
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Updation successful</strong>
                  </div>
                </div>
              <?php
            }
            else
            {
              ?>
                <div class="col-sm-12">
                  <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Some error in updation</strong>
                  </div>
                </div>
              <?php
            }
          }
            $sql_get_user_details=$db_connection->prepare("SELECT * FROM user WHERE id=?");
            $sql_get_user_details->bind_param("i",$user_id);
            $sql_get_user_details->execute();

            $result=$sql_get_user_details->get_result();
            $row=$result->fetch_assoc();
        ?>
          <div class="col-md-7 mb-5 mx-auto "  data-aos="fade">
            <h2>Settings</h2>
            <form action=" " method="post" class="p-5 bg-white border border-1">
              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="fname">Name :</label>
                  <input type="text" id="name" name="name" class="form-control" value="<?php echo $row['original_name']; ?>" required>
                </div>             
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="phone">Phone</label> 
                  <input type="text" id="phone" name="phone" class="form-control" 
                  maxlength="10" value="<?php echo $row['mobile']; ?>" 
                  pattern="^[6-9]\d{9}$" required>
                  <span id="mobile-valid" class="text-success">
                    <i class="fa fa-check"></i>
                        Valid Mobile No
                  </span>  
                  <span id="mobile-invalid" class="text-danger">
                    <i class="fa fa-check"></i>
                        Invalid Mobile No
                  </span>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col-sm-12">
                  <label for="gender">Gender</label>
                </div>
                <div class="col-md-6">
                
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="gender" value="m" 
                    <?php echo ($row['gender']=='m')?'checked':'' ?>>Male
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="gender" value="f" 
                       <?php echo ($row['gender']=='f')?'checked':'' ?>>Female
                      </label>
                    </div>
                </div>
              </div>
               <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="username">User Name:</label>
                  <input type="text" id="username" name="username" class="form-control" value="<?php echo $row['user_name'] ; ?>" required>
                </div>
              </div>
              
              <div class="row">                
                <div class="col-md-12">
                  <label class="text-black" for="password">Password: </label>
                  <div class="input-group">
                   <input type="password" id="password" name="password" class="form-control" value="<?php echo $row['password']; ?>" required>
                  <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="view_password" onclick="view_field('password')">View</button>
                  </div> 
                 
                </div>
                </div>
              </div>
              <div class="row mb-4">                
                <div class="col-md-12">
                  <label class="text-black" for="c_password">Confirm Password: </label>
                  <div class="input-group">
                   <input type="password" id="c_password" class="form-control" value="<?php echo $row['password']; ?>" required>
                  <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="view_c_password" onclick="view_field('c_password')">View</button>
                  </div> 
                </div>
                <span id="pwd-invalid" class="text-danger">
                    <!-- <i class="fa fa-check"></i> -->
                        Passwords dosen't match
                  </span>
                </div>
              </div>            
              <div class="row form-group">
                <div class="col-md-12 text-right">
                  <input type="submit" value="Save Changes" class="btn btn-primary py-2 px-4 text-white mr-3" id="save" name="save">
                  <input type="button" value="Edit" class="btn btn-secondary py-2 px-4 text-white mr-3" id="edit">
                  <input type="button" value="Cancel" class="btn btn-danger py-2 px-4 text-white mr-3" id="cancel">
                </div>            
              </div>
            </form>
          </div>
          <!-- <div class="col-md-5"  data-aos="fade" data-aos-delay="100">
            <h2>Details</h2>
            <div class="p-4 mb-3 bg-white">
              <p class="mb-0 font-weight-bold">Address</p>
              <p class="mb-4">203 Fake St. Mountain View, San Francisco, California, USA</p>

              <p class="mb-0 font-weight-bold">Phone</p>
              <p class="mb-4"><a href="#">+1 232 3235 324</a></p>

              <p class="mb-0 font-weight-bold">Email Address</p>
              <p class="mb-0"><a href="#">youremail@domain.com</a></p>

            </div> -->
<!--             
            <div class="p-4 mb-3 bg-white">
              <h3 class="h5 text-black mb-3">More Info</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa ad iure porro mollitia architecto hic consequuntur. Distinctio nisi perferendis dolore, ipsa consectetur? Fugiat quaerat eos qui, libero neque sed nulla.</p>
              <p><a href="#" class="btn btn-primary px-4 py-2 text-white">Learn More</a></p>
            </div> -->

          </div>
        </div>
      </div>
    </div>
    
     <!-- Footer part here -->
     <?php
    include("footer.php");
    ?>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/rangeslider.min.js"></script>

  <script src="js/main.js"></script>

  <script>
   $(function(){
     $("input").prop('readonly',true)}); // set all inputs with readonly attribute=true

   $(function(){$("#edit").click(function(){
    $("#save").show(); //show the save button
    $("#cancel").show(); //show the cancel button
    $("#edit").hide(); //hide the edit button
    $("input").prop('readonly',false); //remove readonly attribute from all inputs
   })});

   $(function(){$("#cancel").click(function()
   {
    $("#save").hide(); //hide the save button
    $("#cancel").hide(); //show the cancel button
    $("#edit").show(); //hide the edit button
    $("input").prop('readonly',true); //remove readonly attribute from all inputs
   })});

//mobile number validation
   $(function(){$("#phone").keyup(function(){
        var mobNum = $(this).val();
        //alert($(this).val());
        var filter = /^\d*(?:\.\d{1,2})?$/;

          if (filter.test(mobNum)) {
            
            if(mobNum.length==10){
                  //alert("valid");
              $("#mobile-valid").show();
              $("#mobile-invalid").hide();
              $("#save").prop('disabled',false);
             } else {
                //alert('Please put 10  digit mobile number');
               $("#mobile-invalid").show();
               $("#mobile-valid").hide();
               $("#save").prop('disabled',true);
                return false;
              }
            }
            else {
              //alert('Not a valid number');
              $("#mobile-invalid").show();
              $("#mobile-valid").hide();
              $("#save").prop('disabled',true);
              return false;
           }
    
  })});

//toggle view password function
    function view_field(id)
    {      
      var element=document.getElementById(id);
      if(element.type==="password")
      {
        element.type="text";
      }
      else
        element.type="password";
    }

 //remove white space from username
    $('#username').keyup(function() {
       $(this).val($(this).val().replace(/\s+/g, ''));
    });

 //matching passwords
 $(function(){
    $("#password").keyup(function(){
      if($("#c_password").val()!==$(this).val())
      {
        $("#pwd-invalid").show();
        $("#save").prop('disabled',true);
      }
      else
      {
         $("#pwd-invalid").hide();
         $("#save").prop('disabled',false);
      }
     
    });
    $("#c_password").keyup(function(){
      if($("#password").val()!==$(this).val())
      {
        $("#pwd-invalid").show();
        $("#save").prop('disabled',true);
      }
      else
      {
         $("#pwd-invalid").hide();
         $("#save").prop('disabled',false);
      }
    });
 });
  </script>
</html>

<?php
  $db_connection->close();
?>