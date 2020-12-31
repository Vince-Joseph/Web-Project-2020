<?php
require("connection_file.php");
session_start();

  if(!isset($_SESSION['user_id'])){
    //header("Location: payment.php");
    header("Location: user login.php");
  }
 


?>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <title>Review</title>
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
                        <li><a href="settings.php">Settings</a></li>
                        <li><a href="#">History</a></li>
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
              //get the lodge name
              $sql_get_lodge_details=$db_connection->prepare("SELECT lodge_name,count(user_id) 
              FROM local_admin JOIN payment_history ON payment_history.local_admin_id=local_admin.id 
              WHERE user_id=? AND id=? GROUP BY user_id");

              $sql_get_lodge_details->bind_param("ii",$_SESSION['user_id'],$_REQUEST['id']);
              $sql_get_lodge_details->execute();
              $result=$sql_get_lodge_details->get_result();
              $row=$result->fetch_assoc();

              //select rows from review table where current user has reviewed
              $search_for_feedback=$db_connection->prepare("SELECT * FROM review
              WHERE user_id=? AND local_admin_id=?");
              $search_for_feedback->bind_param("ii",$_SESSION['user_id'],$_REQUEST['id']);
              $search_for_feedback->execute();
              $search_result=$search_for_feedback->get_result();

              if(!($search_result->num_rows>0))
              {
                $sql_get_user_name=$db_connection->prepare("SELECT original_name FROM user WHERE id=?");
                $sql_get_user_name->bind_param("i",$_SESSION['user_id']);
                $sql_get_user_name->execute();
                $user_name=$sql_get_user_name->get_result();
                $user_name=$user_name->fetch_assoc();

                if(isset($_POST['submit']))
                {
                 
                      $user_rating=$_POST['rated_value'];
                      $current_date=date("Y-m-d");
                      $user_message=$_POST['message'];
                      //echo (int)$_SESSION['user_id']."\n".$user_name['original_name']."\n".$_REQUEST['id']."\n".$user_rating,$current_date,$user_message;

                      $sql_insert_rating=$db_connection->prepare("INSERT INTO review VALUES(?,?,?,?,?,?)");
                      $name=$user_name['original_name'];
                      $sql_insert_rating->bind_param("isiiss",$_SESSION['user_id'],$name,$_REQUEST['id'],$user_rating,$current_date,$user_message);

                      if($sql_insert_rating->execute())
                      {
                    ?>
                    <div class="col-sm-12">
                      <div class="alert alert-success alert-dismissible">
                         <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <strong>Thank you for your valuable feedback.</strong>
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
                          <strong>Server error</strong>
                      </div>
                    </div>
                  <?php
                    }
                  }
                  // else
                  // {
                    ?>
                    <!-- <div class="col-sm-12">
                      <div class="alert alert-danger alert-dismissible">
                         <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <strong>You have already reviewed this lodge.</strong>
                      </div>
                    </div> -->
                  <?php
                  // }
                
              ?>
                <i>Feedback for</i>
                <h3>
                <?php
                  echo $row['lodge_name'];
                  ?>
                </h3>

            </div>
          
            <div class="col-sm-12 mt-3 p-3 bg-white border">
          
              <form action=" " method="post">
                <h3>Post your review</h3><?php  //$previous = $_SERVER['REQUEST_URI'];?>
                <!-- <div class="row form-group">
                  
                  <div class="col-md-12">
                    <label class="text-black" for="review-title">Title</label> 
                    <input type="text" id="review-title" class="form-control">
                  </div>
                </div> -->
                
                <div class="row form-group pt-3" id="review">
                  <div class="col-md-12">
                    <label class="text-black" for="message">Message</label> 
                    <textarea name="message" id="message" cols="30" rows="7"
                     class="form-control" placeholder="Write your notes or questions here..." required></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                   <p>
                      <i>Overall rating</i> 
                   </p>
                   <p id="rating">
                      <!-- <span class="icon-star text-warning"></span> -->
                      <a href="#review" class="bg-white p-1" onclick="color(1)" id="1">
                          <span class="icon-star text-secondary"></span>
                      </a>
                      <a href="#review" class=" bg-white p-1" onclick="color(2)" id="2">
                          <span class="icon-star text-secondary"></span>
                      </a>
                      <a href="#review" class=" bg-white p-1" onclick="color(3)" id="3">
                          <span class="icon-star text-secondary"></span>
                      </a>
                      <a href="#review" class=" bg-white p-1" onclick="color(4)" id="4">
                          <span class="icon-star text-secondary"></span>
                      </a>
                      <a href="#review" class=" bg-white p-1" onclick="color(5)" id="5">
                          <span class="icon-star text-secondary"></span>
                      </a>
                     
                     
                   </p> 
                   <input type="text" name="rated_value" id="rated_value" hidden="true">
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-12">
                    <input type="submit" value="POST REVIEW" class="btn btn-primary py-2 px-4 text-white" name="submit">
                  </div>
                </div>
              </form>
          </div>
          <?php
            } 
            else
            {
              ?>
                    <div class="col-sm-12">
                      <div class="alert alert-primary py-5">
                        
                          <strong>Thank You, You have already reviewed this lodge.</strong>
                      </div>
                    </div>
                  <?php
            }
           ?>
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
    function color(id)
    {
      //alert(id);
      var rating=document.getElementById('rating');
      var rated_value=document.getElementById('rated_value');
      rated_value.value=id;
      
      rating.innerHTML="";
      for(var i=1;i<=id;i++)
      {
        rating.innerHTML+="<a href='#review' class='bg-white p-1' onclick='color("+i+")' id='"+i+"'><span class='icon-star text-warning'></span></a>";
      }
      for(var i=id+1;i<=5;i++)
      {
        rating.innerHTML+="<a href='#review' class='bg-white p-1' onclick='color("+i+")' id='"+i+"'><span class='icon-star text-secondary'></span></a>";
      }
    }
  </script>

  </body>
</html>
<?php
  $db_connection->close();
?>