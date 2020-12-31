<?php
  
  require('connection_file.php');
  session_start();
  
  if(isset($_POST['submit']))
  { 
      $_SESSION['no_of_rooms']=$_POST['required_rooms'];
      $_SESSION['room_type']=$_POST['room_type'];
      $_SESSION['no_of_guests']=$_POST['no_of_guests'];
      $_SESSION['rate_hr']=$_POST['rate_hr'];
      $_SESSION['booking_from_date']=$_POST['booking_from_date'];
      $_SESSION['booking_to_date']=$_POST['booking_to_date'];
      $_SESSION['booking_from_time']=$_POST['booking_from_time'];
      $_SESSION['booking_to_time']=$_POST['booking_to_time'];
      $_SESSION['net_amount']=$_POST['net_amount'];
      $_SESSION['local_admin_id']=$_POST['local_admin_id'];
    if(isset($_SESSION['user_id'])){
      
      header("Location: payment.php");
    }
    else
    {//echo"hasdjfasdfjasdlkf";
      header("Location: user login.php");
      $_SESSION['from']="dashboard.php";
      $_SESSION['lodge_id']=$_POST['local_admin_id'];
      exit;
    }
  }

  $local_admin_id=$_REQUEST['lodge_id'];
  
   // sql query for retreiving lodges with given id
    $sql_get_lodge=$db_connection->prepare("SELECT ucase(lodge_name) AS lodge_name,
    ucase(lodge_location) AS lodge_location,
    lodge_address,capacity,car_parking ,swimming_pool ,restaurent ,security,
    type, count(type)as vacant,rate_hr as rate,image_01,image_02,image_03,image_04 
    FROM local_admin LEFT JOIN rooms
    ON local_admin.id=rooms.local_admin_id JOIN room_images ON local_admin.id=room_images.local_admin_id
    WHERE id=? AND lodge_status=1 AND user_id IS null
    GROUP BY type");

//binding parameters -   page sql
   $sql_get_lodge->bind_param("i",$local_admin_id);
   $sql_get_lodge->execute();
  $result_lodge_details=$sql_get_lodge->get_result(); // excecute the above sql query and store result
 
//   if(empty($rows)) //means no rooms available
//   {
//     $local_admin_id=$_REQUEST['lodge_id'];
  
//    // sql query for retreiving lodges with given id
//     $sql_get_lodge=$db_connection->prepare("SELECT ucase(lodge_name) AS lodge_name,ucase(lodge_location) AS lodge_location,
//     lodge_address FROM local_admin 
//      WHERE id=? AND lodge_status=1");

// //binding parameters -   page sql
//    $sql_get_lodge->bind_param("i",$local_admin_id);
//    $sql_get_lodge->execute();
//     $result_lodge_details=$sql_get_lodge->get_result(); // excecute the above sql query and store result
//   }
  // else
  // {
    //taking only one row - home page sql
   $rows = $result_lodge_details->fetch_assoc(); 
   $lodge_location=$rows['lodge_location'];
   $lodge_name=$rows['lodge_name'];
  // }
   
   
  

    $sql_get_similar_lodges=$db_connection->prepare("SELECT id,ucase(lodge_name) AS lodge_name,lodge_location 
            FROM local_admin 
            WHERE (TIME(NOW()) BETWEEN opening_time AND closing_time) AND lodge_status=1 
            AND lodge_location=lcase(?) AND id NOT IN (?)");
            
          
   //binding parameters - similar rooms lodge name and location
   $sql_get_similar_lodges->bind_param("si",$lodge_location,$local_admin_id);
   $sql_get_similar_lodges->execute();
    $result_get_similar_lodges=$sql_get_similar_lodges->get_result();


   if(isset($_REQUEST['type']))
   {
     $room_type=$_REQUEST['type'];
     $no_of_guests=$_REQUEST['guests'];
     
   }
   else
   {
     $room_type=$rows['type'];
     $no_of_guests="1";
     //$total_rooms="1";
   }
   //calculate the required rooms
   
   $no_of_guests=(int)$no_of_guests;
   $vacant_rooms=(int)$rows['vacant'];

   $rate=(int)$rows['rate']>0?$rows['rate']:0;
   
   switch($room_type)
   {
     case "single":case "single deluxe": {$required_rooms=$no_of_guests;$capacity=1; break;} 
                   
     case "double":case "double deluxe":case "twin": {$required_rooms=ceil($no_of_guests/2);$capacity=2;break;}
    
     case "tripple": {$required_rooms=ceil($no_of_guests/3);$capacity=3; break;}
   }

?>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <title>User dashboard</title>
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
      .responsive-table{
        padding:0;
      }
      .responsive-table>li {
        
          border-radius: 3px;
          padding: 25px 30px;
          display: flex;
          justify-content: space-between;
          margin-bottom: 25px;
        }
        .table-header {
          background-color: #95A5A6;
          font-size: 14px;
          text-transform: uppercase;
          letter-spacing: 0.03em;
        }
        .table-row {
          background-color: #ffffff;
          box-shadow: 0px 0px 9px 0px rgba(0,0,0,0.1);
        }
        .col-1 {
          flex-basis: 10%;
        }
        .col-2 {
          flex-basis: 40%;
        }
        .col-3 {
          flex-basis: 25%;
        }
        .col-4 {
          flex-basis: 25%;
        }
        
        @media all and (max-width: 767px) {
          .table-header {
            display: none;
          }
          .table-row{
            
          }
          li {
            display: block;
          }
          .col {
            
            flex-basis: 100%;
            
          }
          .col {
            display: flex;
            padding: 10px 0;
            /* &:before {
              color: #6C7A89;
              padding-right: 10px;
              content: attr(data-label);
              flex-basis: 50%;
              text-align: right;
            } */
          }
        }

        #error_room_count,#error_date{
          display:none;
        }

        .black-transparent{
          background-image: linear-gradient(to left, rgba(000,000,000,0.0),rgba(000,000,000,0.5),rgba(000,000,000,0.0));
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
                <li><a href="#about">Address</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li class="has-children border-left pl-xl-4">
                  <a href="about.html">Account</a>
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

                <!-- <li><a href="#" class="cta"><span class="bg-primary text-white rounded">Account</span></a></li> -->
              </ul>
            </nav>
          </div>


          <div class="d-inline-block d-xl-none ml-auto py-3 col-6 text-right" style="position: relative; top: 3px;">
            <a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a>
          </div>

        </div>
      </div> 
      
    </header>

  
    <?php
      $image_url="images//room images//$rows[image_02]"; 
    ?>
    <div class="site-blocks-cover inner-page-cover overlay" 
        style="background-image: url('<?php echo $image_url?>');" data-aos="fade" 
        data-stellar-background-ratio="0.5">
      <div class="container black-transparent">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-10" data-aos="fade-up" data-aos-delay="400">
            
            
            <div class="row justify-content-center mt-5" >
              <div class="col-md-8 text-center">
                <h1>
                  <?php
                      echo $lodge_name;
                  ?>
                </h1>
                <p class="mb-0">
                 <?php
                      echo $lodge_location;
                  ?>
                  </p>
                  <p>
                  
                    <?php
                  
                       //checking for additional features of the lodge
                       foreach($rows as $key=> $value)
                       {
                          if($rows[$key]==1)
                          {
                            $modified_key=strtolower(str_replace("_"," ",$key));
                             echo "* $modified_key ";
                          }
                       }
                       
                    ?>
                   
                  </p>
              </div>
            </div>

            
          </div>
        </div>
      </div>
    </div>  

    <div class="site-section"  data-aos="fade" id="table_section">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <form action="">
              <!-- <div class="container"> -->
                <?php
                //echo $vacant_rooms;
                    if($vacant_rooms > 0)
                    {
                     
                ?>
                  <h2>Room catalog</h2>
                    <ul class="responsive-table">
                      <li class="table-header">
                        <div class="col col-2">Type</div>
                        <div class="col col-2">Availability</div>
                        <div class="col col-2">Rate/Hr</div>
                        <div class="col col-2">Capacity</div>
                        <div class="col col-2">Images</div>
                        <div class="col col-2">Payment</div>
                     </li>
                <?php
                      //binding parameters
                      $sql_get_lodge->bind_param("i",$local_admin_id);
                      $sql_get_lodge->execute();

                      
                      // excecute the above sql query and store result.
                      $result_lodge_details=$sql_get_lodge->get_result();
                
                      // get each row
                      while($rows = $result_lodge_details->fetch_assoc()) 
                      {
                        //print_r($rows);

                        $href="dashboard.php?lodge_id=$local_admin_id&room_type=".$rows['type'].
                          "&vacant_rooms=".$rows['vacant']."&rate_room=".$rows['rate']."&capacity_of_room=".$rows['capacity'].
                          "#table_section";
                ?>

                  <li class="table-row">
                    <div class="col col-2" ><?php echo $rows['type']; ?></div>
                    <div class="col col-2 text-center" ><?php echo $rows['vacant']; ?></div>
                    <div class="col col-2 text-center" ><?php echo $rows['rate']; ?></div>
                    <div class="col col-2 text-center" ><?php echo $rows['capacity']; ?></div>
                    <div class="col col-2 text-center"><a href="#room-images">View Images</a></div>
                    <div class="col col-2 text-center" data-label="Payment Status"> 
                      <a class="btn btn-primary text-white" href="<?php echo $href;?>">
                          Select This
                      </a>
                    </div>
                  </li>
                
                <?php
               
                      }//closing of while loop
                      ?>  
                    </ul>
                    
                  
                  <?php
                    // }//closing of if
                    // else
                    // {
                    //   echo"Sorry no rooms available at this time";
                    // }
                ?>
              <!-- </div> -->
            </form>
          </div>
          <div class="col-lg-4 ml-auto"style="position:relative;" >
            <div style="position:sticky;top:0;">
            <div class="mb-6" id="selected_lodge">
           
              <h3 class="h5 text-black mb-3">Your Requirements</h3>
              <form action=" " method="POST">
              <div id="selected_lodge">
                  <?php

                      // if(!$room_type=="")//means that some filters has been applied and then redirected to here.
                      // {

                      if(isset($_REQUEST['room_type']))
                      {
                        $room_type=$_REQUEST['room_type'];
                        $no_of_guests=1;
                        $capacity=$_REQUEST['capacity_of_room'];
                        $vacant_rooms=$_REQUEST['vacant_rooms'];
                        $rate=$_REQUEST['rate_room'];
                        $required_rooms=1;
                      }
                  ?>
                      <div class="form-group">
                        <!-- select-wrap, .wrap-icon -->
                        <div class="wrap-icon">
                          <label for="room_type">Room Type:</label>
                          <input type="text" placeholder="Room Type" class="form-control" 
                          value="<?php echo (!$room_type=="")?$room_type:""; ?>" 
                          readonly id="room_type" required name="room_type">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm">
                        <label for="no_of_guests">No. of guests</label>
                          <input type="text" placeholder="Number of Guests" class="form-control" 
                          value="<?php echo $no_of_guests; ?>" id="no_of_guests"
                           onkeyup="calculate_rooms()" name="no_of_guests"> 
                           <!-- hidden fields -->
                           <input type="number" value="<?php echo $capacity; ?>" hidden="true" id="capacity">  
                           <input type="number" value="<?php echo $vacant_rooms; ?>" hidden="true" id="availability">  
                           <input type="number" value="<?php echo $rate; ?>" hidden="true" id="rate" name="rate_hr">
                           <input type="number" value="<?php echo $local_admin_id;?>" hidden="true" name="local_admin_id">  
                        </div>
                        <div class="col-sm">
                          <label for="rooms">Required rooms</label>
                          <input type="text" placeholder="Required Rooms" class="form-control"
                          value="<?php echo $required_rooms!=' '?$required_rooms:'0'; ?>" id="required_rooms" readonly name="required_rooms">
                        </div>
                        <div id="error_room_count" class="text-danger">Sorry rooms not available for this much guests</div>
                      </div>                      
                    <div class="form-group">
                      From:
                      <div class="d-flex">
                        <input type="date" placeholder="Booking from" class="form-control" 
                        onchange="date_checker()" style="width: 50%;"  required id="booking_from_date"
                        name="booking_from_date">
                        <select name="booking_from_time" id="booking_from_time" 
                        onchange="date_checker()"class="form-control" required 
                          style="width: 50%;">
                          <option value="00">00</option>
                          <option value="01">01</option>
                          <option value="02">02</option>
                          <option value="03">03</option>
                          <option value="04">04</option>
                          <option value="05">05</option>
                          <option value="06">06</option>
                          <option value="07">07</option>
                          <option value="08">08</option>
                          <option value="09">09</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                          <option value="13">13</option>
                          <option value="14">14</option>
                          <option value="15">15</option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                          <option value="19">19</option>
                          <option value="20">20</option>
                          <option value="21">21</option>
                          <option value="22">22</option>
                          <option value="23">23</option>
                        </select>
                         
                      </div>
                    </div>
                    <div class="form-group">
                      To:
                      <div class="d-flex">
                      <input type="date" placeholder="Booking to" class="form-control" style="width: 50%;" 
                      required id="booking_to_date" onchange="date_checker()"  name="booking_to_date">
                      <select name="booking_to_time" id="booking_to_time" class="form-control"
                      onchange="date_checker()" required 
                          style="width: 50%;">
                          <option value="00">00</option>
                          <option value="01">01</option>
                          <option value="02">02</option>
                          <option value="03">03</option>
                          <option value="04">04</option>
                          <option value="05">05</option>
                          <option value="06">06</option>
                          <option value="07">07</option>
                          <option value="08">08</option>
                          <option value="09">09</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                          <option value="13">13</option>
                          <option value="14">14</option>
                          <option value="15">15</option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                          <option value="19">19</option>
                          <option value="20">20</option>
                          <option value="21">21</option>
                          <option value="22">22</option>
                          <option value="23">23</option>
                        </select>
                    </div>
                    <div id="error_date" class="text-danger">Please check date and time fields</div>
                    </div> 
                      <div class="form-group">
                        <!-- select-wrap, .wrap-icon -->
                        <div class="wrap-icon">
                          <label for="room_type">Net Amount</label>
                          <input type="text" placeholder="Net amount" class="form-control" 
                           readonly id="net_amount" name="net_amount">
                        </div>
                      </div>
                    <div class="form-group">
                      <!-- select-wrap, .wrap-icon -->
                      <div class="wrap-icon">
                        <!-- <input type="submit"class="form-control btn btn-primary txt-black" value="Pay Now"> -->
                        <input type="submit" class="form-control btn btn-primary txt-black"
                         value="Pay Now" id="pay_now" name="submit">
                         
                      </div>
                    </div> 
                </div>            
              </form>
            </div>
             <div class="mb-5">
             <?php
                    //binding parameters
                      //$sql_get_lodge->bind_param("i",$local_admin_id);
                      $sql_get_lodge->execute();
                      $result_lodge_details=$sql_get_lodge->get_result();
                    //taking only one row
                      $rows = $result_lodge_details->fetch_assoc(); 
                    
              ?>
              <!-- <h3 class="h6 mb-3">Other Facilities:</h3> -->
            
              <p>
               <ul class="list-group-horizontal list-unstyled">
              <?php
                  $flag=0;
                          //checking for additional features of the lodge
                          foreach($rows as $key=> $value)
                          {
                              if($rows[$key]==1 && ($key=="car_parking" || $key=="restaurent"||$key=="security"||$key=="swimming_pool"))
                              {
                                echo $flag==0?"Additional Features | ":"";
                                $flag=1;
                                $modified_key=strtolower(str_replace("_"," ",$key));
                                echo "<li class='list-inline-item'> $modified_key | </li> ";
                              }
                          }
                    
              ?>
                </ul>
              </p>
            </div> 
            </div><?php
                    }//closing of if
                    else
                    {
                      echo"Sorry no rooms available at this time";
                    }
                ?>
          </div>
         
        </div>
        
     
        <div class="row mb-5" id="room-images">
          <div class="col-md-4 text-left border-primary">
            <h2 class="font-weight-light text-primary pb-3">Images</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-12  block-13">
            <div class="owl-carousel nonloop-block-13">
            <?php
              $image_url="images//room images//"; 
            ?>
              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('<?php echo $image_url.$rows['image_01']?>')"></a>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('<?php echo $image_url.$rows['image_02']?>')"></a>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('<?php echo $image_url.$rows['image_03']?>')"></a>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('<?php echo $image_url.$rows['image_04']?>')"></a>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('<?php echo $image_url.$rows['image_01']?>')"></a>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('<?php echo $image_url.$rows['image_02']?>')"></a>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('<?php echo $image_url.$rows['image_03']?>')"></a>
              </div>

              <div class="d-block d-md-flex listing vertical">
                <a href="listings-single.html" class="img d-block" style="background-image: url('<?php echo $image_url.$rows['image_04']?>')"></a>
              </div>

            </div>
          </div>
        </div>
       </div>
    </div>

    
    <div class="site-section" id="about">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <img src="<?php echo $image_url.$rows['image_01']?>" alt="Image" class="img-fluid rounded">
          </div>
          <div class="col-md-5 ml-auto">
            <h2 class="text-primary mb-3">Our location</h2>
            <p>
            <?php
                //taking only one row
               // $rows = $result_lodge_details->fetch_assoc();
                echo $rows['lodge_address'];
            ?>          
            </p>
            <p class="mb-4">Adipisci dolore reprehenderit est et assumenda veritatis, ex voluptate odio consequuntur quo ipsa accusamus dicta laborum exercitationem aspernatur reiciendis perspiciatis!</p>

            <ul class="ul-check list-unstyled primary">
              <li>Adipisci dolore reprehenderit</li>
              <li>Accusamus dicta laborum</li>
              <li>Delectus sed labore</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 order-md-2">
            <img src="<?php echo $image_url.$rows['image_02']?>" alt="Image" class="img-fluid rounded">
          </div>
          <div class="col-md-5 mr-auto order-md-1">
            <h2 class="text-primary mb-3">Customer Centered Co.</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam voluptates a explicabo delectus sed labore dolor enim optio odio at!</p>
            
            <ul class="ul-check list-unstyled primary">
              <li>Adipisci dolore reprehenderit</li>
              <li>Accusamus dicta laborum</li>
              <li>Delectus sed labore</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php
      // echo $result_get_similar_lodges->num_rows;
      // echo $lodge_location,$local_admin_id,$lodge_location;
      if($result_get_similar_lodges->num_rows > 0)
      {
    ?>
    <div class="site-section bg-light">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-7 text-left border-primary">
            <h2 class="font-weight-light text-primary">Similar Rooms</h2>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-lg-6">
              <?php
                
                    while($rows_similar_rooms=$result_get_similar_lodges->fetch_assoc())
                    {
                      
                      $sql_get_similar_lodges_room=$db_connection->prepare("SELECT COUNT(ROOM_NO) AS total_rooms,min(rate_hr) AS minimum_rate 
                      FROM ROOMS 
                      WHERE user_id IS NULL AND LOCAL_ADMIN_ID=?");

                      //binding parameters - similar rooms room details
                      $sql_get_similar_lodges_room->bind_param("i",$rows_similar_rooms['id']);
                      $sql_get_similar_lodges_room->execute();
                        $result_get_similar_lodges_room=$sql_get_similar_lodges_room->get_result();
                       $row_room_details=$result_get_similar_lodges_room->fetch_assoc();

                       $href="dashboard.php?lodge_id=".$rows_similar_rooms['id'];

              ?>
            <div class="d-block d-md-flex listing">
              <a href="<?php echo $href;?>" class="img d-block" style="background-image: url('images/img_2.jpg')"></a>
              <div class="lh-content" >
                <span class="category"><?php echo $row_room_details['total_rooms']." Rooms"; ?></span>
                <span class="category"><?php echo "Starting - ₹ ".$row_room_details['minimum_rate']." /hr"; ?></span>
                <h3><a href="<?php echo $href;?>"><?php echo $rows_similar_rooms['lodge_name']; ?></a></h3>
                <address><?php echo $rows_similar_rooms['lodge_location']; ?></address>
                <p class="mb-0">
                  <?php

                    $sql_get_rating=$db_connection->prepare("SELECT AVG(RATING) AS RATING,COUNT(RATING) AS REVIEWERS
                    FROM REVIEW WHERE LOCAL_ADMIN_ID=?
                    GROUP BY local_admin_id");

                    //binding parameters
                    $sql_get_rating->bind_param("i",$rows_similar_rooms['id']);
                    $sql_get_rating->execute();

                    // fetching results
                    $result_rating=$sql_get_rating->get_result();

                    //converting into associative array
                    $converted_array=$result_rating->fetch_assoc();
                    $rating=(int)$converted_array['RATING'];
                    for($i=1;$i<=$rating;$i++)
                    {
                  ?>
                  
                    <span class="icon-star text-warning"></span>
                    <?php
                      }

                      for($i=5;$i>$rating;$i--)
                      {
                    ?>
                      <span class="icon-star text-secondary"></span>

                  <?php
                      }
                  ?>
                    <span class="review">
                    <?php if($converted_array['REVIEWERS']>0) 
                              print("( ".$converted_array['REVIEWERS']." Reviews )");
                          else
                              echo ("( 0 Reviews )") ; 
                      ?>
                    </span>
                </p>
              </div>
            </div>
              <?php
                      }

              ?>
          </div>
          <!-- <div class="col-lg-6">

            <div class="d-block d-md-flex listing">
              <a href="#" class="img d-block" style="background-image: url('images/img_1.jpg')"></a>
              <div class="lh-content">
                <span class="category">Cars &amp; Vehicles</span>
                <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                <h3><a href="#">Red Luxury Car</a></h3>
                <address>Don St, Brooklyn, New York</address>
                <p class="mb-0">
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-secondary"></span>
                  <span class="review">(3 Reviews)</span>
                </p>
              </div>
            </div>

            <div class="d-block d-md-flex listing">
              <a href="#" class="img d-block" style="background-image: url('images/img_2.jpg')"></a>
              <div class="lh-content">
                <span class="category">Real Estate</span>
                <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                <h3><a href="#">House with Swimming Pool</a></h3>
                <address>Don St, Brooklyn, New York</address>
                <p class="mb-0">
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-warning"></span>
                  <span class="icon-star text-secondary"></span>
                  <span class="review">(3 Reviews)</span>
                </p>
              </div>
            </div>
            <div class="d-block d-md-flex listing">
                <a href="#" class="img d-block" style="background-image: url('images/img_3.jpg')"></a>
                <div class="lh-content">
                  <span class="category">Furniture</span>
                  <a href="#" class="bookmark"><span class="icon-heart"></span></a>
                  <h3><a href="#">Wooden Chair &amp; Table</a></h3>
                  <address>Don St, Brooklyn, New York</address>
                  <p class="mb-0">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-secondary"></span>
                    <span class="review">(3 Reviews)</span>
                  </p>
                </div>
              </div>

          </div> -->
        </div>
      </div>
    </div>
      <?php
        }
      ?>

    <div class="site-section bg-white border border-1">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-7 text-left border-primary">
            <h2 class="font-weight-light text-primary">User Ratings</h2>
          </div>
        </div>
        <?php
          $sql_review=$db_connection->prepare("SELECT * FROM review WHERE local_admin_id=? ORDER BY time DESC");
          //binding parameters - review sql
          $sql_review->bind_param("i",$local_admin_id);
          $sql_review->execute();
          $result_review=$sql_review->get_result(); // excecute the above sql query and store result
  
            if($result_review->num_rows>0)
            {
              
            
        ?>
        <div class="row mt-5">
          <div class="col-lg-12">
            <?php
              while($rows_review=$result_review->fetch_assoc())
              {

              
            ?>
            <div class="media border p-3 bg-white mb-2">
              <img src="images/user avatar 001.png" alt="John Doe" class="mr-3 mt-3 rounded-circle" style="width:60px;">
              <div class="media-body">
                <big> <b><?php echo $rows_review['user_name'];?></b></big> <small>
                  <i><?php echo "Posted on ". $rows_review['time'];?></i></small>
                <p><?php echo $rows_review['comment'];?></p>
                <p class="mb-0">
                <?php
                    $rating=(int)$rows_review['rating'];
                    for($i=1;$i<=$rating;$i++)
                    {
                    ?>

                    <span class="icon-star text-warning"></span>
                    <?php
                      }

                      for($i=5;$i>$rating;$i--)
                      {
                    ?>
                      <span class="icon-star text-secondary"></span>

                    <?php
                      }
                    ?>
                   
                </p>
              </div>
            </div>           
         
            <?php
              
                }//closing of while

            ?>
             <!-- <div class="col-sm-12">
                <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item active"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul> 
            </div> -->
            <?php
                }//closing of if
                else
                {
              ?>
              <div class="alert alert-warning">
                <strong>Be the first one to review !</strong> Book a room to enable review.
              </div>
            <?php
              }
            ?> 

            <?php
              if(isset($_POST['post_review']))
              {
                    //get user name
                    $sql_get_user_name=$db_connection->prepare("SELECT original_name FROM user WHERE id=?");
                    $sql_get_user_name->bind_param("i",$_SESSION['user_id']);
                    $sql_get_user_name->execute();
                    $user_name=$sql_get_user_name->get_result();
                    $user_name=$user_name->fetch_assoc();

                      $user_rating=$_POST['rated_value'];
                      $current_date=date("Y-m-d");
                      $user_message=$_POST['message'];

                      $sql_insert_rating=$db_connection->prepare("INSERT INTO review VALUES(?,?,?,?,?,?)");
                      $name=$user_name['original_name'];                      
                     // echo $_SESSION['user_id'],$name,$local_admin_id,$user_rating,$current_date,$user_message;

                      $sql_insert_rating->bind_param("isiiss",$_SESSION['user_id'],$name,$local_admin_id,$user_rating,$current_date,$user_message);

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
            //check whether this user has already stayed in this lodge or not.
              $sql_get_history=$db_connection->prepare("SELECT lodge_name,local_admin_id,
              amount,check_in,check_out,type FROM payment_history JOIN local_admin 
              ON payment_history.local_admin_id=local_admin.id
              WHERE user_id=? AND local_admin_id=?");
              $sql_get_history->bind_param("ii",$_SESSION['user_id'],$local_admin_id);
              $sql_get_history->execute();
              $result=$sql_get_history->get_result();

           
                //if he/she stayed then 
                if($result->num_rows>0)
                {
                  
                  //check wheter he/she has already reviewed this lodge.
                    $search_for_feedback=$db_connection->prepare("SELECT * FROM review
                    WHERE user_id=? AND local_admin_id=?");
                    $search_for_feedback->bind_param("ii",$_SESSION['user_id'],$local_admin_id);
                    $search_for_feedback->execute();
                    $search_result=$search_for_feedback->get_result();

                    //if not reviewed then show the form for review
                    if(!($search_result->num_rows>0))
                    {
            ?>
          <div class="col-sm-12 mt-3 bg-white border p-3">
            <form action=" " method="post">
              <h3>Post your review</h3>  

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="message">Message</label> 
                  <textarea name="message" id="message" cols="30" rows="7" class="form-control" placeholder="Write your notes or questions here..."></textarea>
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
                  <input type="submit" value="POST REVIEW" class="btn btn-primary py-2 px-4 text-white" name="post_review">
                </div>
              </div>
            </form>
          </div>
          <?php
                    }//closing of if
                    else
                    {
                      if(!isset($_POST['post_review']))
                      {
                      ?>
                        <div class="alert alert-primary">
                          <strong>Thank you.</strong> You have already reviewd this lodge.
                       </div>
                      <?php
                      }
                    }
                  }

          ?>
        </div>
      </div>
        
      </div>
    </div>
<!-- 
    <div class="newsletter bg-primary py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <h2>Write to us</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
          </div>
          <div class="col-md-6">
            
            <form class="d-flex">
              <input type="text" class="form-control" placeholder="Email">
              <input type="submit" value="Send" class="btn btn-white"> 
            </form>
          </div>
        </div>
      </div>
    </div>
-->
  
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
  // function get_lodge()
  // {
  //   xhttp = new XMLHttpRequest();
  //   xhttp.onreadystatechange = function() {
  //     if (this.readyState == 4 && this.status == 200) {
  //       //alert(this.responseText);
  //     document.getElementById("selected_lodge").innerHTML = this.responseText;
  //     }
  //   };
  // xhttp.open("GET", "select_lodge_dashboard_ajax.php?id="+2, true);
  // xhttp.send();
  // }

    

    var required_rooms_count;
    var date_book_from ;
    var date_book_to ;
    var current_date;

  function calculate_rooms()
  {
    var guests=document.getElementById('no_of_guests');
    var capacity=document.getElementById('capacity');
    var availability=document.getElementById('availability');
    var error_message_room_count=document.getElementById('error_room_count');
    var rate=document.getElementById('rate');
    var required_rooms=document.getElementById('required_rooms');
    var paynow_button=document.getElementById('pay_now');

    var booking_from_date=document.getElementById('booking_from_date');
    var booking_to_date=document.getElementById('booking_to_date');
    //alert(capacity.value);
     guests=parseInt(guests.value);
     capacity=parseInt(capacity.value);
     availability=parseInt(availability.value);

    //alert(guests);
        required_rooms_count=Math.ceil(guests/capacity);

    if(required_rooms_count<=availability)
      {
        //alert(required_rooms_count);
        required_rooms.value=required_rooms_count;
        error_message_room_count.style.display="none";
        paynow_button.disabled=false;
       //alert("hai");
      }
    else
       {
        //alert("hai");
        error_message_room_count.style.display="block";
        paynow_button.disabled=true;
       }
     if(booking_from_date.value.length != 0 && booking_to_date.value.length != 0)
     {
       date_checker();
     }
  }

  function date_checker()
  {
    
    var booking_from_date=document.getElementById('booking_from_date');
    var booking_to_date=document.getElementById('booking_to_date');
    //checking whether all the from and to dates are set or not
    if(booking_from_date.value.length != 0 && booking_to_date.value.length != 0)
     {
        var booking_from_time=document.getElementById('booking_from_time');
        var booking_to_time=document.getElementById('booking_to_time');
        var error_date=document.getElementById('error_date');
        var rate=document.getElementById('rate');

        var required_rooms=document.getElementById('required_rooms');
        var paynow_button=document.getElementById('pay_now');
        var net_amount=document.getElementById('net_amount');

        date_book_from = new Date(booking_from_date.value).getDate();
        date_book_to = new Date(booking_to_date.value).getDate();
        current_date=new Date().getDate();

        required_room_count=parseInt(required_rooms.value);
        rate=parseInt(rate.value);
        booking_from_time=parseInt(booking_from_time.value);
        booking_to_time=parseInt(booking_to_time.value);

        //check if book from date is < current date or book to date is < current date or <book from date
        if(date_book_from < current_date || date_book_to < current_date || (date_book_to < date_book_from || booking_from_time>booking_to_time && date_book_to==date_book_from))
        {
          error_date.style.display="block";
          paynow_button.disabled=true;
          net_amount.value="";
          //   return false;
        }
        else
        {
          
          //converting current date to milliseconds
            date_book_from = new Date(booking_from_date.value).getTime();
            date_book_to = new Date(booking_to_date.value).getTime();
          
          
          error_date.style.display="none";
          paynow_button.disabled=false; 
          var amount=required_room_count*rate;
          var date_count=(date_book_to - date_book_from)/(1000 * 60 * 60);
          //alert(date_count);
          if(date_count==0)
            net_amount.value=(amount*(booking_to_time-booking_from_time));
          else
          {
            //alert(date_count); 
            net_amount.value=(amount*(date_count-((24-booking_to_time)-(24-booking_from_time))));
          }
        

        }
     }
  }

  </script>
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
   <?php
    $db_connection->close();
  ?>
  </body>
</html>