<?php
require("connection_file.php");
session_start();
//the admin id is passed via url take care of it when accessing this page via menu

if(!isset($_SESSION['user_id'])){
  //header("Location: payment.php");
  header("Location: user login.php");
}


if(isset($_REQUEST['id']))
  $local_admin_id=(int)$_REQUEST['id'];

  // SELECT room_no,type,rate_hr as rate,
  // check_in,check_out,time_in,time_out,total_amount,(SELECT count(type) from rooms WHERE user_id=?  and local_admin_id=?) as no_of_rooms from rooms 
  // WHERE user_id=?  and local_admin_id=?

  $sql_get_details=$db_connection->prepare("SELECT id as local_admin_id,lodge_name,room_no,type,rate_hr as rate,
  check_in,check_out,time_in,time_out,total_amount,count(type) as no_of_rooms from 
  rooms join local_admin on rooms.local_admin_id=local_admin.id  
  WHERE user_id=?  GROUP BY check_in,check_out,total_amount,id");

  $sql_cancel_booking=$db_connection->prepare("UPDATE rooms SET user_id=NULL,check_in=NULL,check_out=NULL,time_in='00:00:00',
  time_out='00:00:00',total_amount=0 
  WHERE local_admin_id=? AND user_id=? AND type=?  AND total_amount=?");

   $sql_cancel_payment=$db_connection->prepare("DELETE FROM payment_history WHERE user_id=? AND type=? 
   AND local_admin_id=? AND check_in=? AND
   check_out=?");


  $user_id=$_SESSION['user_id']; //getting id of current user

if(isset($_POST['value']))
  {
   
    //print_r($_POST);
    $cancelled_room_type=$_POST['value'];
    $current_local_admin_id=$_POST['current_local_admin_id'];
    $cancelled_amount=$_POST['cancelled_amount']; //echo $current_local_admin_id;
     //echo $cancelled_amount,$cancelled_room_type;
    $sql_cancel_booking->bind_param("iisi",$current_local_admin_id,$user_id,$cancelled_room_type,$cancelled_amount);
    //$sql_cancel_payment->bind_param("isi",$user_id,$cancelled_room_type,$local_admin_id,$check_in,$check_out);

      if(!$sql_cancel_booking->execute())
      {
        echo "<script>alert('Some Error occured while cancelling');</script>";
      }
    }
    
  $sql_get_details->bind_param("i",$user_id);
  $sql_get_details->execute();
  $result_details=$sql_get_details->get_result();

?>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <title>Payments</title>
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
       .bottom-border{
           border-bottom:1px solid black;
           margin-bottom:10px
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
                      <li><a href="aboutus.php">About Us</a></li>
                      <li><a href="contact.php">Contact</a></li>
                        <li class="has-children border-left pl-xl-4">
                        <a href="#">Account</a>
                        <ul class="dropdown">
                            <li><a href="history.php">History</a></li>
                            <li><a href="settings.php">Settings</a></li>
                            <li><a href="#">Booked Details</a></li>
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
     
   
    <div class="site-section">
      <div class="container">
        <div class="row">
          <?php
         
            if($result_details->num_rows>0)
            {
           
          ?>
              <div class="col-sm-12 text-center mb-5">
                  <div class="alert alert-primary">
                      <strong>Congradulations ! You have booked rooms</strong>
                  </div>
          
                  <h2>Booking Details</h2>
              </div>
          <?php
              while($row=$result_details->fetch_assoc())
              {
                $lodge_name=$row['lodge_name'];
                $room_type=$row['type'];
                $no_of_rooms=$row['no_of_rooms'];
                // $no_of_guests=$_SESSION['no_of_guests'];
                $rate_hr=$row['rate'];
                $booking_from_date=$row['check_in'];
                $booking_to_date=$row['check_out'];
                $booking_from_time=$row['time_in'];
                $booking_to_time=$row['time_out'];
                $amount=$row['total_amount'];
           ?>  
              <div class="col-lg-6 mx-auto">
                <div class="d-block d-md-flex listing vertical p-5">
                <div class="row bottom-border">
                      <div class="col-md-6">Lodge Name: </div>
                      <div class="col-md-6 mb-2"><?php echo $lodge_name;?></div>
                      <hr>
                  </div>
                  <div class="row bottom-border">
                      <div class="col-md-6">Room Type: </div>
                      <div class="col-md-6 mb-2"><?php echo $room_type;?></div>
                      <hr>
                  </div>
                  <div class="row bottom-border">
                      <div class="col-md-6">Number of rooms: </div>
                      <div class="col-md-6 mb-2"><?php echo $no_of_rooms;?></div>
                      <hr>
                    </div>
                    <div class="row bottom-border">
                      <div class="col-md-6">Rate / Hr: </div>
                      <div class="col-md-6 mb-2"><?php echo $rate_hr;?></div>
                      <hr>
                    </div>
                    <div class="row bottom-border">
                      <div class="col-md-6">Booking Date From: </div>
                      <div class="col-md-6 mb-2"><?php echo $booking_from_date;?></div>
                      <hr>
                    </div>
                    <div class="row bottom-border">
                      <div class="col-md-6">Booking From time: </div>
                      <div class="col-md-6 mb-2"><?php echo $booking_from_time;?></div>
                      <hr>
                    </div>
                    <div class="row bottom-border">
                      <div class="col-md-6">Booking To Date: </div>
                      <div class="col-md-6 mb-2"><?php echo $booking_to_date;?></div>
                      <hr>
                    </div>
                    <div class="row bottom-border">
                      <div class="col-md-6">Booking To time: </div>
                      <div class="col-md-6 mb-2"><?php echo $booking_to_time;?></div>
                      <hr>
                    </div>
                    <div class="row bottom-border">
                      <div class="col-md-6">Total paid amount: </div>
                      <div class="col-md-6 mb-2"><?php echo $amount;?></div>
                    </div>
                    <div class="row">
                     <form>  <!-- no action and method attributes required in this form -->
                        <div class="col-md-12 my-5">
                         
                          <input type="text" name="current_value" value="<?php echo $room_type ?>" hidden="true">
                          
                            <input type="button" value="CANCEL"  
                            class="form-control btn btn-danger" onclick="assign_value(this.previousElementSibling.value,<?php echo $amount;?>,this.nextElementSibling.value)" 
                            data-toggle="modal" data-target="#myModal">
                            <input type="text" name="local_admin_id" value="<?php echo $row['local_admin_id'] ?>" hidden="true">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            </div>
            
              <?php

                  }//closing of while loop
                }
                else
                {
               ?>
                 <div class="alert alert-success mx-auto">
                    <strong>No booked rooms</strong> You should <a href="index.php" class="alert-link">Go to home page</a>.
                  </div>

               <?php
                  }
               ?>
         </div> 
      </div>
    </div>
    <form action=" " method="post" id="confirm">
            <!-- The Modal -->
          <div class="modal fade" id="myModal">
            <div class="modal-dialog">
              <div class="modal-content">
              
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Check again </h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                  Do you really wish to cancel the booking ?
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                <input type="text" name="current_local_admin_id"  hidden="true" id="current_local_admin_id">
                <input type="text" name="value" hidden="true" id="value">
                <input type="text" name="cancelled_amount" hidden="true" id="cancelled_amount">

                  <input type="submit" class="btn btn-danger" 
                  data-dismiss="modal" name="continue" value="Continue" onclick="form_submit()">
                </div>
                
              </div>
            </div>
          </div>
      </form>
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
  <!-- <script src="js/rangeslider.min.js"></script> -->

  <script src="js/main.js"></script>

  
  <script type="text/javascript">
  
  function form_submit() {
  
    document.getElementById("confirm").submit();
    
   }    
  
  </script>
  <script>
  
      // This is the jquery to prevent going back from this page to payments page., redirects to home page
    //  jQuery(document).ready(function($) 
    //  {

    //         if (window.history && window.history.pushState) {

    //         $(window).on('popstate', function() {
    //             var hashLocation = location.hash;
    //             var hashSplit = hashLocation.split("#!/");
    //             var hashName = hashSplit[1];

    //             if (hashName !== '') {
    //             var hash = window.location.hash;
    //             if (hash === '') {
    //                 //alert('Back button was pressed.');
    //                 window.location='index.php';
    //                 return false;
    //             }
    //             }
    //         });

    //         window.history.pushState('forward', null, './');
    //         }

    //     });

    function assign_value(value_given,a,b)
    { //
      var x=document.getElementById('value');
      var y=document.getElementById('cancelled_amount');
      var z=document.getElementById('current_local_admin_id');
      //alert(b);
      x.value=value_given;
      y.value=a;
      z.value=b;
      //alert(y.value);
    }
    </script> 
  </script>
  </body>
</html>