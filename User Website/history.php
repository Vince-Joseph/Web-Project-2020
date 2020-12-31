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
    
    <!-- <link rel="stylesheet" href="css/sorTable.css"> -->

    <link rel="stylesheet" href="css/style.css">

    <style>
        table.sortable thead tr  .order-asc {
        background-image: url(css/imgages/asc.png);
        }
        table.sortable thead tr .order-desc {
            background-image: url(css/images/desc.png);
        }

        table.sortable thead tr th {
            background-repeat: no-repeat;
            background-position: center right;
            cursor: pointer;
            background-image: url(css/images/bg.png);
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
            box-shadow:1px 1px 20px 1px grey;
        }
        th, td {
            border-bottom: 1px solid #666;
            width: 150px;
            padding:20px;
            margin:5px;
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
                  
                <h2>Your Booking History</h2>

            </div>
            <div class="col-sm-12 text-center table-responsive ">
            <div class="table-responsive-md">           
            <?php
                $sql_get_history=$db_connection->prepare("SELECT lodge_name,local_admin_id,
                amount,check_in,check_out,type FROM payment_history JOIN local_admin 
                ON payment_history.local_admin_id=local_admin.id
                WHERE user_id=?");
                $sql_get_history->bind_param("i",$_SESSION['user_id']);
                $sql_get_history->execute();
                $result=$sql_get_history->get_result();

                $i=1;

                    if($result->num_rows>0)
                    {

            ?>
                <table class="sortable mx-auto table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lodge name</th>
                            <th>Room Type</th>
                            <th>From,To</th>
                            <th>Paid amount</th>
                            <th>Extra</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        
                            while($row=$result->fetch_assoc())
                            {

                        
                    ?>
                        <tr>
                            <th><?php  echo $i++; ?></th>
                            <td><?php echo $row['lodge_name'] ?></td>
                            <td><?php echo $row['type'] ?></td>
                            <td><?php echo $row['check_in']." ".$row['check_out'];?></td>
                            <td><?php echo $row['amount'] ?></td>
                            <td><a href="review.php?id=<?php echo $row['local_admin_id']?>" class="btn btn-success">Review</a></td>
                        </tr>
                     <?php
                            }
                        }
                        else
                        {
                            echo "No Booking history";
                        }
                     ?>
                    </tbody>
                </table>
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

  <script src="js/sorTable.min.js"></script>

  </body>
</html>
<?php
  $db_connection->close();
?>