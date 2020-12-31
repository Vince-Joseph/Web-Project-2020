<?php
  require("connection_file.php");
  session_start();
  $user_id=isset($_SESSION['user_id'])?$_SESSION['user_id']:0; //getting id of current user
  // if(!isset($_SESSION['user_id'])){
  //   //header("Location: payment.php");
  //   header("Location: user login.php");
  // }
 
?>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <title>Contact us</title>
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
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                      <li class="has-children border-left pl-xl-4">
                      <a href="">Account</a>
                      <ul class="dropdown">
                            <?php
                            if(isset($_SESSION['user_id']))
                            {

                            ?>
                            <li><a href="view_booked_details.php">Booked Details</a></li>
                            <li><a href="history.php">History</a></li>
                            <li><a href="settings.php">Settings</a></li>
                            <li><a href="logout.php">Logout</a></li>
                          <?php
                            }
                            else
                            {
                              ?>
                          <li><a href="user login.php">Login As User</a></li>
                          <li><a href="admin login.html">Login As Admin</a></li>
                          <li><a href="registration.php">Register</a></li>
                          <?php
                            }
                        ?>
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
          if(isset($_POST['submit']))
          {
                  if(!isset($_SESSION['user_id'])){
                    //header("Location: payment.php");
                    $_SESSION['from']="contact.php";
                    header("Location: user login.php");
                  }
            $email=$_POST['email'];
            $subject=$_POST['subject'];
            $message=$_POST['message'];
           
          
              $sql_send_mail=$db_connection->prepare("INSERT INTO user_mails (email,subject,message,user_id) VALUES(?,?,?,?)");
              $sql_send_mail->bind_param("sssi",$email,$subject,$message,$user_id);
              if($sql_send_mail->execute())
              {
              ?>
                <div class="col-sm-12">
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Mail has been sent successfully !</strong>
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
                      <strong>Server error !</strong>
                  </div>
                </div>
                <?php
              }
           }
          ?>
          <div class="col-md-7 mb-5"  data-aos="fade">
            <form action=" " class="p-5 bg-white" method="post">
              <h2>Write to us:</h2>
              <!-- <div class="row form-group">
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black" for="fname">First Name</label>
                  <input type="text" id="fname" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="text-black" for="lname">Last Name</label>
                  <input type="text" id="lname" class="form-control">
                </div>
              </div> -->

              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black" for="email">Email</label> 
                  <input type="email" id="email" class="form-control" required placeholder="Your mail id" name="email">
                </div>
              </div>

              <div class="row form-group">
                
                <div class="col-md-12">
                  <label class="text-black" for="subject">Subject</label> 
                  <input type="subject" id="subject" class="form-control" required placeholder="Subject title" name="subject">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="message">Message</label> 
                  <textarea name="message" id="message" cols="30" rows="7" class="form-control" required placeholder="Write your notes or questions here..."></textarea>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Send Message" name="submit" class="btn btn-primary py-2 px-4 text-white">
                </div>
              </div>

  
            </form>
          </div>
          <div class="col-md-5"  data-aos="fade" data-aos-delay="100">
            
            <div class="p-4 mb-3 bg-white">
              <h2>Contact details:</h2>
              <p class="mb-0 font-weight-bold">Address</p>
              <p class="mb-4">203 Fake St. Mountain View, San Francisco, California, USA</p>

              <p class="mb-0 font-weight-bold">Phone</p>
              <p class="mb-4"><a href="#">+1 232 3235 324</a></p>

              <p class="mb-0 font-weight-bold">Email Address</p>
              <p class="mb-0"><a href="#">youremail@domain.com</a></p>

            </div>
            
            <div class="p-4 mb-3 bg-white">
              <h3 class="h5 text-black mb-3">More Info</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa ad iure porro mollitia architecto hic consequuntur. Distinctio nisi perferendis dolore, ipsa consectetur? Fugiat quaerat eos qui, libero neque sed nulla.</p>
              <p><a href="#" class="btn btn-primary px-4 py-2 text-white">Learn More</a></p>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center border-primary">
            <h2 class="font-weight-light text-primary">Frequently Ask Question</h2>
            <p class="color-black-opacity-5">Let's find out</p>
          </div>
        </div>


        <div class="row justify-content-center">
          <div class="col-8">
            <div class="border p-3 rounded mb-2">
              <a data-toggle="collapse" href="#collapse-1" role="button" aria-expanded="false" aria-controls="collapse-1" class="accordion-item h5 d-block mb-0">
               How to cancel a booking?
              </a>

              <div class="collapse" id="collapse-1">
                <div class="pt-2">
                  <p class="mb-0">
                    <br>
                    Step 01: Sign in to your account<br>
                    Step 02: On top right menu, select view my bookings<br>
                    Step 03: Click on the cancel button of the rooms you want to cancel.
                  </p>
                </div>
              </div>
            </div>

            <div class="border p-3 rounded mb-2">
              <a data-toggle="collapse" href="#collapse-4" role="button" aria-expanded="false" aria-controls="collapse-4" class="accordion-item h5 d-block mb-0">
                What are the payment options available ?
              </a>

              <div class="collapse" id="collapse-4">
                <div class="pt-2">
                  <p class="mb-0">
                    <br>
                    Only two payment options are available 
                    01.) UPI payment<br>
                    02.) Credit/ Debit card payment
                  </p> 
              </div>
              </div>
            </div>

            <div class="border p-3 rounded mb-2">
              <a data-toggle="collapse" href="#collapse-2" role="button" aria-expanded="false" aria-controls="collapse-2" class="accordion-item h5 d-block mb-0">
                Can I book multiple types of rooms at once ?</a>

              <div class="collapse" id="collapse-2">
                <div class="pt-2">
                  <p class="mb-0">
                    <br>
                    No, You can't. you have book them separately
                  </p>
                </div>
              </div>
            </div>

            <div class="border p-3 rounded mb-2">
              <a data-toggle="collapse" href="#collapse-3" role="button" aria-expanded="false" aria-controls="collapse-3" class="accordion-item h5 d-block mb-0">
                How to rate a lodge ?
              </a>

              <div class="collapse" id="collapse-3">
                <div class="pt-2">
                  <p class="mb-0">
                    <br>
                    You can rate a lodge after you have stayed on that lodge. The option to rate the lodge
                    will be visible on your dashboard
                  </p>
                </div>
              </div>
            </div>
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


  </body>

</html>
<?php
  $db_connection->close();
?>