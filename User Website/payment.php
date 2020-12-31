<?php
require("connection_file.php");
session_start();
//echo $_REQUEST['net_amount'];

 
  if(!isset($_SESSION['user_id'])){
    //header("Location: payment.php");
    header("Location: user login.php");
  }
 


  if (isset($_SESSION['net_amount'])) 
  {
      // $_SESSION['no_of_rooms']=$_POST['required_rooms'];
      // $_SESSION['room_type']=$_POST['room_type'];
      // $_SESSION['no_of_guests']=$_POST['no_of_guests'];
      // $_SESSION['rate_hr']=$_POST['rate_hr'];
      // $_SESSION['booking_from_date']=$_POST['booking_from_date'];
      // $_SESSION['booking_to_date']=$_POST['booking_to_date'];
      // $_SESSION['booking_from_time']=$_POST['booking_from_time'];
      // $_SESSION['booking_to_time']=$_POST['booking_to_time'];
      // $_SESSION['net_amount']=$_POST['net_amount'];
      // $_SESSION['local_admin_id']=$_POST['local_admin_id'];

       $amount=$_SESSION['net_amount'];

      
  }
  else if(isset($_POST['upi_payment']) || isset($_POST['card_payment']))
  {
       $amount=$_POST['amount'];
       
  }
  else
     $amount=0;

    //declaring variables
    $upi_id="abcd@apl";
    $upi_pin="654321";

    $card_number="1122334455";
    $card_pin="000111";
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
                        <a href="#">Account</a>
                        <ul class="dropdown">
                        <li><a href="history.php">History</a></li>
                        <li><a href="settings.php">Settings</a></li>
                        <li><a href="view_booked_details.php">Booked Details</a></li>
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
            <div class="col-sm-12 text-center mb-5">
                  <?php
                  //assigning session variable values to other varables for simplicity
                          $local_admin_id=(int)$_SESSION['local_admin_id'];

                          $user_id=$_SESSION['user_id']; //getting id of current user
                          
                          $date_from=$_SESSION['booking_from_date'];
                          $date_to=$_SESSION['booking_to_date'];
                          $room_type=$_SESSION['room_type'];
                          $count=$_SESSION['no_of_rooms'];
                          $time_from=$_SESSION['booking_from_time'].':00:00';
                          $time_to=$_SESSION['booking_to_time'].':00:00';

                          //the update query
                          $sql_update_room_status=$db_connection->prepare("UPDATE rooms 
                          SET user_id=?,check_in=?,check_out=?,time_in=?,time_out=?,total_amount=total_amount+?
                          WHERE room_no = (SELECT room_no FROM rooms WHERE user_id is null 
                          AND local_admin_id =? AND type=? LIMIT 1)");
                          //binding sql update parameters
                          $sql_update_room_status->bind_param("issssiis",$user_id,$date_from,$date_to,$time_from,$time_to,$amount,$local_admin_id,$room_type);


                          $check_in=$date_from.' '.$time_from;
                          $check_out=$date_to.' '.$time_to;

                          //echo $check_in,$check_out;
                          $sql_update_payment_history=$db_connection->prepare("INSERT INTO payment_history VALUES(?,?,?,?,?,?,?)");
                          $sql_update_payment_history->bind_param("iiiisss",$user_id,$local_admin_id,$count,$amount,$room_type,$check_in,$check_out);


                    if(isset($_POST['upi_payment']))
                    {
                      
                        if($_POST['upi_id']==$upi_id && $_POST['upi_pin']==$upi_pin)
                        {
                          
                          for($i=1;$i<=$count;$i++)
                          {
                            //update the database by executing the query.
                            $sql_update_room_status->execute();
                          }
                          
                            $sql_update_payment_history->execute();

                          echo"<script>window.location.replace('http://localhost/CET/Web-Project-2020/User%20Website/view_booked_details.php?id=$local_admin_id');</script>";
                        }
                        else
                        {
                  ?>
                        <div class="alert alert-danger">
                          <strong>Invalid UPI details check again !</strong>
                        </div>
                  <?php

                        }
                    }
                    else if(isset($_POST['card_payment']))
                    {
                      if($_POST['card_number']==$card_number && $_POST['card_pin']==$card_pin)
                        {
                          for($i=1;$i<=$count;$i++)
                          {
                            //update the database by executing the query.
                             $sql_update_room_status->execute();
                          }
                        // $sql_update_payment_history->execute();
                          echo"<script>window.location.replace('http://localhost/CET/Web-Project-2020/User%20Website/view_booked_details.php?id=$local_admin_id');</script>";
                        }
                        else
                        {
                  ?>
                          <div class="alert alert-danger">
                            <strong>Invalid Card details check again !</strong>
                          </div>
                  <?php
                        }
                    }
                   
                      
                  ?>
                <h2>Payment</h2>
            </div>
            <div class="col-lg-6 mx-auto">
                <div class="d-block d-md-flex listing vertical">
                  <a href="#" class="img d-block" style="background-image: url('images/upi\ payment\ image.png')"></a>
                  <div class="lh-content">
                    <span class="category">UPI Payment</span>
                    <h3>Amount : $ <?php echo $amount;?></h3>
                    <form action=" " method="post">
                        <div class="form-group">                       
                           <input type="text" class="form-control" placeholder="UPI Id" name="upi_id" required>  
                           <input type="text" hidden="true" value="<?php echo $amount;?>" name="amount">                       
                        </div>
                        <div class="form-group">                       
                          <input type="password" class="form-control" placeholder="PIN" name="upi_pin" required>                         
                        </div>
                    <div class="form-group">                       
                        <input type="submit" class="form-control btn btn-primary" value="UPI Pay" name="upi_payment">                         
                     </div>
                    </form>
                  </div>
                </div>

              </div>
              <div class="col-lg-6 mx-auto">
                <div class="d-block d-md-flex listing vertical">
                  <a href="#" class="img d-block" style="background-image: url('images/credit\ card\ image.webp')"></a>
                  <div class="lh-content">
                    <span class="category">Credit/ Debit card</span>
                    <h3>Amount : $ <?php echo $amount;?></h3>
                    <form action=" " method="post">
                        <div class="form-group">                       
                          <input type="text" class="form-control" placeholder="card number" name="card_number" required>     
                          <input type="text" hidden="true" value="<?php echo $amount;?>" name="amount">                    
                        </div>
                        <div class="form-group">                       
                            <input type="password" class="form-control" placeholder="PIN" name="card_pin" required>                         
                    </div>
                    <div class="form-group">                       
                        <input type="submit" class="form-control btn btn-primary" value="Card Pay" name="card_payment">                         
                     </div>
                    </form>
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