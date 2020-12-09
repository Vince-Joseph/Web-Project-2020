<?php
  require('connection_file.php');
 
  $sql_get_total_hotel_details="SELECT id,lodge_name,lodge_location FROM local_admin  
  WHERE (TIME(NOW()) BETWEEN opening_time AND closing_time) AND lodge_status=1";
  $sql_get_total_rooms="SELECT COUNT(ROOM_NO) AS total_rooms,min(rate_hr) AS minimum_rate FROM ROOMS WHERE user_id IS NULL AND LOCAL_ADMIN_ID=";
  
 
  //defining variables
  // $search_location="none";
  // $room_type="none";
  // $no_of_guests=0;
  // crate an array with select tag elements
  $types = array('single','double','twin','tripple','single deluxe','double deluxe');
  //$db_connection->set_charset('utf8');
?>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <title>Project Name</title>
    <meta charset="utf-8" http-equiv="content-type" content="text/html">
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
    
    <header class="site-navbar container py-0 bg-white" role="banner">

      <div class="container"> 
        <div class="row align-items-center">
          
          <div class="col-6 col-xl-2">
            <h1 class="mb-0 site-logo"><a href="#" class="text-black mb-0">Project<span class="text-primary">Name</span>  </a></h1>
          </div>
          <div class="col-12 col-md-10 d-none d-xl-block">
            <nav class="site-navigation position-relative text-right" role="navigation">

              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                <li class="active"><a href="index.html">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="has-children border-left pl-xl-4">
                  <a href="#">Account</a>
                  <ul class="dropdown">
                    <li><a href="user login.html">Login As User</a></li>
                    <li><a href="admin login.html">Login As Admin</a></li>
                    <li><a href="registration.html">Register</a></li>
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
    
    <div class="site-blocks-cover overlay" style="background-image: url(images/room\ image\ 004.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center text-center">
  
            <div class="col-md-12">
              <div class="row justify-content-center mb-4">
                <div class="col-md-8 text-center">
                  <h1 class="" data-aos="fade-up">Lorem ipsum dolor sit amet.</h1>
                  <p data-aos="fade-up" data-aos-delay="100">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, dolorum?</p>
                </div>
              </div>
  
              <div class="form-search-wrap" data-aos="fade-up" data-aos-delay="200">
                <form  action="" method="post">

                <?php

                  if(isset($_POST['submit']) && ($_POST['submit'] == 'Apply Filter' || $_POST['submit'] == 'Search'))
                  {

                  
                ?>
                      <div class="row align-items-center">
                        <div class="col-lg-12 mb-4 mb-xl-0 col-xl-4">
                          <div class="wrap-icon">
                            <span class="icon icon-room"></span>
                            <input type="text" class="form-control rounded" 
                            placeholder="Search a location" name="location_search" 
                            value="<?php echo $_POST['location_search']; ?>" required>
                          </div>
                        </div>
                        <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                          <input type="text" class="form-control rounded" 
                          placeholder="Number of guests" name="no_of_guests"
                          value="<?php echo $_POST['no_of_guests']; ?>">
                        </div>
                        
                        <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                          <div class="select-wrap">
                            <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                            <?php
                                //print select tag with the help of an array.
                                echo '<select name="room_type" class="form-control">';
                                foreach($types as $option) {
                                  // pritnt option values and if current option value matches with the 
                                  //previously selected value then set selected
                                    echo '<option value="'.$option.'"'.(strcmp($option,$_POST["room_type"])==0?' selected="selected"':'').'>'.$option.'</option>';
                                }
                                echo '</select>';
                                
                            ?>
                          </div>
                        </div>
                        <div class="col-lg-12 col-xl-2 ml-auto text-right">
                          <input type="submit" class="btn btn-primary btn-block rounded" value="Search" name="submit">
                        </div>
                        
                      </div>
                  <?php
                      
                      }
                      else
                      {    
                  ?>  
                      <div class="row align-items-center">
                        <div class="col-lg-12 mb-4 mb-xl-0 col-xl-4">
                          <div class="wrap-icon">
                            <span class="icon icon-room"></span>
                            <input type="text" class="form-control rounded" 
                            placeholder="Search a location" name="location_search" required>
                          </div>
                        </div>
                        <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                          <input type="text" class="form-control rounded" 
                          placeholder="Number of guests" name="no_of_guests" required>
                        </div>
                        
                        <div class="col-lg-12 mb-4 mb-xl-0 col-xl-3">
                          <div class="select-wrap">
                            <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                            <select class="form-control rounded" name="room_type" required>
                              <option disabled selected>Room Type</option>
                              <!-- <option value="all" >All</option> -->
                              <option value="single" >Single Room</option>
                              <option value="double">Double Room</option>
                              <option value="twin">Twin Room</option>
                              <option value="triple">Triple Room</option>
                              <option value="single_deluxe">Single Deluxe</option>
                              <option value="double_deluxe">Double Deluxe</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-12 col-xl-2 ml-auto text-right">
                          <input type="submit" class="btn btn-primary btn-block rounded" value="Search" name="submit">
                        </div>
                        
                      </div>
                      <?php
                          }
                      ?>
                </form>
              </div>
  
            </div>
          </div>
        </div>
      </div>  

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">

            <div class="row">
                    <?php

                        if (isset($_POST['submit']))  // checks whether if any of the buttons are clicked
                        { 
                          if ($_POST['submit'] == 'Search') 
                          {   // checks whether buttons clicked is home search button

                            // assign values to variables.
                            $search_location=$_POST['location_search'];
                            $no_of_guests=$_POST['no_of_guests'];
                            $room_type=$_POST['room_type'];

                          // sql query for retreiving lodges with given location
                          $sql_search_lodges_home="SELECT id,ucase(lodge_location) AS lodge_location,lodge_name,COUNT(ROOM_NO) AS total_rooms,rate_hr AS rate 
                          FROM local_admin JOIN ROOMS ON local_admin.id=rooms.local_admin_id 
                          WHERE user_id IS NULL AND type='$room_type' AND lodge_status=1 AND lodge_location=lcase('$search_location')
                          GROUP BY LOCAL_ADMIN_ID HAVING SUM(CAPACITY)>=$no_of_guests 
                          ORDER BY capacity";
                          // excecute the above sql query and store result.
                          $result_lodge_details=$db_connection->query($sql_search_lodges_home);
                          
                            if ($result_lodge_details->num_rows > 0) // iff the result contains userful non empty results
                            {
                              // get each row
                              while($rows = $result_lodge_details->fetch_assoc()) 
                              {
                                  $local_admin_id=$rows['id'];// this is a must step for rating display

                    ?>

                          <div class="col-lg-6">
                            <div class="d-block d-md-flex listing vertical">
                              <a href="about.html" class="img d-block" style="background-image: url('images/room\ image\ 001.jpg')"></a>
                              <div class="lh-content">
                                <span class="category">

                                  <?php echo $rows['total_rooms']." Rooms"; ?>

                                </span>
                                <span class="category">Starting - ₹ <?php echo $rows['rate']; ?>/hr</span>
                                <!-- <a href="#" class="bookmark"><span class="icon-heart"></span></a> -->
                                <h3><a href="about.html">
                                    <?php echo $rows['lodge_name']; ?>
                                </a></h3>
                                <address>
                                    <?php echo $rows['lodge_location'] ?>
                                </address>
                                
                                <p class="mb-0">
                                <?php
                                // $sql_hotel_reviewed_or_not="SELECT COUNT(local_admin_id) FROM REVIEW WHERE local_admin_id=$local_admin_id
                                // GROUP BY  local_admin_id";

                                // $result_hotel_reviewed_or_not=$db_connection->query($sql_hotel_reviewed_or_not);

                                // while($rows_of_reviewed = $result_hotel_reviewed_or_not->fetch_assoc()) 
                                // {
                                 $sql_get_rating="SELECT AVG(RATING) AS RATING,COUNT(RATING) AS REVIEWERS
                                 FROM REVIEW WHERE LOCAL_ADMIN_ID=$local_admin_id
                                GROUP BY local_admin_id";

                                  $result_rating=$db_connection->query($sql_get_rating);
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
                          </div>

                            <?php
                                           
                                        }//closing of while loop   
                                    }// closing of if 
                                  else 
                                    {
                                      ?>
                         
                            <div class="alert alert-danger w-100">
                              <strong>Sorry !</strong> No lodges match your selection criteria.
                            </div>
                            
                            <?php              
                                     }
                                } 
                                else if($_POST['submit'] == 'Apply Filter') // filter serach button
                                {
                                  // assign values of filter search block
                                $search_location=$_POST['location_search'];
                                $no_of_guests=$_POST['no_of_guests'];
                                $room_type=$_POST['room_type'];
                                $rate_slider=$_POST['slider'];
                               
                               // echo "\n\n".$rate_slider,$parking,$swimming_pool,$restaurent;

                                 // sql query for retreiving lodges with given location
                                 $sql_search_lodges_home="SELECT id,ucase(lodge_location) AS lodge_location,lodge_name,COUNT(ROOM_NO) AS total_rooms,rate_hr AS rate 
                                 FROM local_admin JOIN ROOMS ON local_admin.id=rooms.local_admin_id 
                                 WHERE user_id IS NULL AND type='$room_type' AND rate_hr<=$rate_slider AND lodge_status=1 AND lodge_location=lcase('$search_location')";

                                  $associative_array['car_parking']=(isset($_POST['parking']))? 1 : 0 ;
                                  $associative_array['security']=(isset($_POST['security']))? 1 : 0 ;
                                  $associative_array['restaurent']=(isset($_POST['restaurent']))? 1 : 0 ;
                                  $associative_array['swimming_pool']=(isset($_POST['swimming_pool']))? 1 : 0 ;

                                    foreach ($associative_array as $key => $value) {
                                      if($value)
                                      $sql_search_lodges_home.=" AND $key=$value "; // adds this field to sql command if it is checked ie 1
                                    }
                                
                                 $sql_search_lodges_home.=" GROUP BY LOCAL_ADMIN_ID HAVING SUM(CAPACITY)>=$no_of_guests 
                                 ORDER BY capacity";
                                 
                                

                                 //echo $sql_search_lodges_home;
                                    // excecute the above sql query and store result.
                                   $result_lodge_details=$db_connection->query($sql_search_lodges_home); 
                                   if ($result_lodge_details->num_rows > 0) // iff the result contains userful non empty results
                                    {
                                     
                                      // get each row
                                      while($rows = $result_lodge_details->fetch_assoc()) 
                                      {
                                          $local_admin_id=$rows['id']; // this is a must step for rating display
                          ?>      
                          

                          <div class="col-lg-6">
                            <div class="d-block d-md-flex listing vertical">
                              <a href="about.html" class="img d-block" style="background-image: url('images/room\ image\ 001.jpg')"></a>
                              <div class="lh-content">
                                <span class="category">

                                  <?php echo $rows['total_rooms']." Rooms"; ?>

                                </span>
                                <span class="category">Starting - ₹ <?php echo $rows['rate']; ?>/hr</span>
                                <!-- <a href="#" class="bookmark"><span class="icon-heart"></span></a> -->
                                <h3><a href="about.html">
                                    <?php echo $rows['lodge_name']; ?>
                                </a></h3>
                                <address>
                                    <?php echo $rows['lodge_location'] ?>
                                </address>
                                <p class="mb-0">
                                <?php
                                
                                 $sql_get_rating="SELECT AVG(RATING) AS RATING,COUNT(RATING) AS REVIEWERS
                                 FROM REVIEW WHERE LOCAL_ADMIN_ID=$local_admin_id
                                GROUP BY local_admin_id";

                                  $result_rating=$db_connection->query($sql_get_rating);
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
                          </div>
                          

                        <?php 
                                          
                                        }//closing of while loop   
                                    }// closing of if 
                                    else
                                     {
                         ?>
                         
                            <div class="alert alert-danger w-100">
                              <strong>Sorry !</strong> No lodges match your selection criteria.
                            </div>
                            
                         <?php              
                                     }
                              }
                              else 
                                    {
                                      ?>
                         
                                    <div class="alert alert-danger w-100">
                                      <strong>Sorry !</strong> No lodges match your selection criteria.
                                    </div>
                            
                         <?php              
                                     }
                              } 
                              else
                              {         
                                
                                $result_lodge_details=$db_connection->query($sql_get_total_hotel_details);

                                    if ($result_lodge_details->num_rows > 0) 
                                    {
                                      // output data of each row
                                      while($row = $result_lodge_details->fetch_assoc()) 
                                      {
                                          
                                          $rooms_result=$db_connection->query($sql_get_total_rooms.$row['id']);
                                        if($rooms_result->num_rows>0)
                                        {
                                            while($total_rows = $rooms_result->fetch_assoc()) 
                                            {
                                                $local_admin_id=$row['id'];
                          ?>    
                
                            <div class="col-lg-6">
                              <div class="d-block d-md-flex listing vertical">
                                <a href="about.html" class="img d-block" style="background-image: url('images/room\ image\ 001.jpg')"></a>
                                <div class="lh-content">
                                  <span class="category">

                                    <?php echo $total_rows['total_rooms']." Rooms"; ?>

                                  </span>
                                  <span class="category">Starting - ₹ <?php echo $total_rows['minimum_rate']; ?>/hr</span>
                                  <!-- <a href="#" class="bookmark"><span class="icon-heart"></span></a> -->
                                  <h3><a href="about.html">
                                      <?php echo $row['lodge_name']; ?>
                                  </a></h3>
                                  <address>
                                      <?php echo $row['lodge_location'] ?>
                                  </address>
                                  <p class="mb-0">
                                <?php
                                
                                 $sql_get_rating="SELECT AVG(RATING) AS RATING,COUNT(RATING) AS REVIEWERS
                                 FROM REVIEW WHERE LOCAL_ADMIN_ID=$local_admin_id
                                GROUP BY local_admin_id";

                                  $result_rating=$db_connection->query($sql_get_rating);
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
                            </div>
                        <?php
                                    }// closing of while loop

                                  } // and the closing of if 

                              }//closing of while loop   
                            }// closing of if 
                          else 
                            {
                              ?>
                         
                            <div class="alert alert-danger w-100">
                              <strong>Sorry !</strong> No lodges match your selection criteria.
                            </div>
                            
                         <?php              
                            }
                          
                          }// final else clause closing
                        ?>
              
            </div>

            <div class="col-12 mt-5 text-center">
              <div class="custom-pagination">
                <span>1</span>
                <a href="#">2</a>
                <a href="#">3</a>
                <span class="more-page">...</span>
                <a href="#">10</a>
              </div>
            </div>

          </div>
          <div class="col-lg-3 ml-auto" >
            <div style="position:sticky;top:0;">
            <div class="mb-5">
              <h3 class="h5 text-black mb-3">Filters</h3>

              <form action="" method="post">
                  <?php

                        if(isset($_POST['submit']) && ($_POST['submit'] == 'Apply Filter' || $_POST['submit'] == 'Search'))
                        {


                  ?>
                    <div class="form-group">
                        <!-- select-wrap, .wrap-icon -->
                        <div class="wrap-icon">
                          <span class="icon icon-room"></span>
                          <input type="text" placeholder="Enter a Location" class="form-control" name="location_search"
                          value="<?php echo $_POST['location_search'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                      <input type="text" placeholder="Number of guests" class="form-control" name="no_of_guests"
                      value="<?php echo $_POST['no_of_guests']; ?>" required>
                    </div>
                
                    <div class="form-group">
                      <div class="select-wrap">
                          <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                          <?php
                          //check whether any of the submit fields are set and is applyfilter or search
                          if(isset($_POST['submit']) && ($_POST['submit'] == 'Apply Filter' || $_POST['submit'] == 'Search'))
                          {
                            
                          
                            //print select tag with the help of an array.
                            echo '<select name="room_type" class="form-control" required> ';
                            foreach($types as $option) {
                              // pritnt option values and if current option value matches with the 
                              //previously selected value then set selected
                                echo '<option value="'.$option.'"'.(strcmp($option,$_POST["room_type"])==0?' selected="selected"':'').'>'.$option.'</option>';
                            }
                            echo '</select>';
                          }
                         ?>
                        
                        </div>
                    </div>
                
             
            </div>
            
            <div class="mb-5">
             
                <div class="form-group">
                  <p>Rate</p>
                </div>
                <div class="form-group">
                  <input type="range" min="0" max="500" data-rangeslider name="slider"
                  value="<?php echo $rate_slider; ?>">
                </div>
              
            </div>

            <div class="mb-5">
              
                <div class="form-group">
                  <p>More filters</p>
                </div>
                <div class="form-group">
                  <ul class="list-unstyled">
                    <li>
                      <label for="option1">
                        <input type="checkbox" id="option1" name="parking" 
                        <?php if(isset($_POST['parking']))  echo 'checked'; else echo '';?>>
                        Car parking
                      </label>
                    </li>
                    <li>
                      <label for="option2">
                        <input type="checkbox" id="option2" name="security" 
                        <?php if(isset($_POST['security']))  echo 'checked'; else echo '';?>>
                        Security
                      </label>
                    </li>
                    <li>
                      <label for="option3">
                        <input type="checkbox" id="option3" name="swimming_pool" 
                        <?php if(isset($_POST['swimming_pool']))  echo 'checked'; else echo '';?>>
                        Swimming Pool
                      </label>
                    </li>
                    <li>
                      <label for="option4">
                        <input type="checkbox" id="option4" name="restaurent" 
                        <?php if(isset($_POST['restaurent']))  echo 'checked'; else echo '';?>>
                        Restaurent
                      </label>
                    </li>
                  </ul>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-primary btn-block rounded" value="Apply Filter" name="submit">
                </div>
             
            </div>
            <?php
                    }
                    else
                    {
                    
                   // else case strts here 
            ?>

                    <div class="form-group">
                        <!-- select-wrap, .wrap-icon -->
                        <div class="wrap-icon">
                          <span class="icon icon-room"></span>
                          <input type="text" placeholder="Enter a Location" class="form-control" name="location_search" required>
                        </div>
                    </div>
                    <div class="form-group">
                      <input type="text" placeholder="Number of guests" class="form-control" name="no_of_guests" required>
                    </div>
                
                    <div class="form-group">
                      <div class="select-wrap">
                          <span class="icon"><span class="icon-keyboard_arrow_down"></span></span>
                         
                            <select class="form-control" name="room_type" required>
                            <option disabled selected>Room Type</option>
                            <!-- <option value="all" >All</option> -->
                              <option value="single" >Single Room</option>
                              <option value="double">Double Room</option>
                              <option value="twin">Twin Room</option>
                              <option value="triple">Triple Room</option>
                              <option value="single_deluxe">Single Deluxe</option>
                              <option value="double_deluxe">Double Deluxe</option>
                          </select>
                         
                        
                        </div>
                    </div>
                
             
            </div>
            
            <div class="mb-5">
             
                <div class="form-group">
                  <p>Rate</p>
                </div>
                <div class="form-group">
                  <input type="range" min="0" max="500" data-rangeslider name="slider">
                </div>
              
            </div>

            <div class="mb-5">
              
                <div class="form-group">
                  <p>More filters</p>
                </div>
                <div class="form-group">
                  <ul class="list-unstyled">
                    <li>
                      <label for="option1">
                        <input type="checkbox" id="option1" name="parking">
                        Car parking
                      </label>
                    </li>
                    <li>
                      <label for="option2">
                        <input type="checkbox" id="option2" name="security">
                        Security
                      </label>
                    </li>
                    <li>
                      <label for="option3">
                        <input type="checkbox" id="option3" name="swimming_pool">
                        Swimming Pool
                      </label>
                    </li>
                    <li>
                      <label for="option4">
                        <input type="checkbox" id="option4" name="restaurent">
                        Restaurent
                      </label>
                    </li>
                  </ul>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-primary btn-block rounded" value="Apply Filter" name="submit">
                </div>
             
            </div>
            <?php
            //else case closes here
                    }
            ?>
           </form>
        </div>
          </div>

        </div>
      </div>
    </div>

    <div class="site-section bg-light" id="about">
        <div class="container">
          <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center border-primary">
              <h2 class="font-weight-light text-primary">Why Us</h2>
              <p class="color-black-opacity-5">See Our Daily News &amp; Updates</p>
            </div>
          </div>
          <div class="row mb-3 align-items-stretch">
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
              <div class="h-entry">
                <img src="images/hero_1.jpg" alt="Image" class="img-fluid rounded">
                <h2 class="font-size-regular"><a href="#" class="text-black">Many People Selling Online</a></h2>
                <div class="meta mb-3">by Mark Spiker<span class="mx-1">&bullet;</span> Jan 18, 2019 <span class="mx-1">&bullet;</span> <a href="#">News</a></div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus eligendi nobis ea maiores sapiente veritatis reprehenderit suscipit quaerat rerum voluptatibus a eius.</p>
              </div> 
            </div>
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
              <div class="h-entry">
                <img src="images/hero_1.jpg" alt="Image" class="img-fluid rounded">
                <h2 class="font-size-regular"><a href="#" class="text-black">Many People Selling Online</a></h2>
                <div class="meta mb-3">by Mark Spiker<span class="mx-1">&bullet;</span> Jan 18, 2019 <span class="mx-1">&bullet;</span> <a href="#">News</a></div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus eligendi nobis ea maiores sapiente veritatis reprehenderit suscipit quaerat rerum voluptatibus a eius.</p>
              </div> 
            </div>
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
              <div class="h-entry">
                <img src="images/hero_1.jpg" alt="Image" class="img-fluid rounded">
                <h2 class="font-size-regular"><a href="#" class="text-black">Many People Selling Online</a></h2>
                <div class="meta mb-3">by Mark Spiker<span class="mx-1">&bullet;</span> Jan 18, 2019 <span class="mx-1">&bullet;</span> <a href="#">News</a></div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus eligendi nobis ea maiores sapiente veritatis reprehenderit suscipit quaerat rerum voluptatibus a eius.</p>
              </div>
            </div>
  
            <div class="col-12 text-center mt-4">
              <!-- <a href="#" class="btn btn-primary rounded py-2 px-4 text-white">View All Posts</a> -->
            </div>
          </div>
        </div>
      </div>
    <div class="site-section bg-white">
      <div class="container">

        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center border-primary">
            <h2 class="font-weight-light text-primary">Testimonials</h2>
          </div>
        </div>

        <div class="slide-one-item home-slider owl-carousel">
          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_3.jpg" alt="Image" class="img-fluid mb-3">
                <p>John Smith</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>
          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_2.jpg" alt="Image" class="img-fluid mb-3">
                <p>Christine Aguilar</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>

          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_4.jpg" alt="Image" class="img-fluid mb-3">
                <p>Robert Spears</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>

          <div>
            <div class="testimonial">
              <figure class="mb-4">
                <img src="images/person_5.jpg" alt="Image" class="img-fluid mb-3">
                <p>Bruce Rogers</p>
              </figure>
              <blockquote>
                <p>&ldquo;Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur unde reprehenderit aperiam quaerat fugiat repudiandae explicabo animi minima fuga beatae illum eligendi incidunt consequatur. Amet dolores excepturi earum unde iusto.&rdquo;</p>
              </blockquote>
            </div>
          </div>

        </div>
      </div>
    </div>
    
    <?php
              // echo"hadkfjsdklfj";
              // //echo $_POST['submit'];
              //   if(isset($_POST['submit'])&& ($_POST['submit']=='Send'))
              //   {
              //     //echo"settedd";
                 
           
             ?>              
                <!-- <div class="alert alert-success w-100">
                  <strong>Success !</strong> We will contact you soon !.
                </div> -->
            <?php       
                // }
                // else
                // {
                //   //echo"this must work";
                // }
            ?>
   
    <div class="newsletter bg-primary py-5" id="contact">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6">
              <h2>Write to us</h2>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            </div>
            <div class="col-md-6">
              
              <form action="" method="post">
                <div class="form-group">
                  <input type="email" class="form-control" placeholder="Email" name="customer_email" required>
                </div>
                <div class="form-group">
                  <textarea name="contact_message" id="contact_message" 
                  cols="30" rows="5" class="form-control"
                  placeholder="Your message here:" required></textarea>
                </div>
                 <div class="form-group">
                   <input type="submit" value="Send" class="btn btn-white">
                 </div>
              </form>
              
            </div>
          </div>
        </div>
      </div>
    
    
      <footer class="site-footer" >
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="row text-center">
                <div class="col-md-4">
                  <h2 class="footer-heading mb-4">About</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident rerum unde possimus molestias dolorem fuga, illo quis fugiat!</p>
                </div>
                
                <div class="col-md-4">
                  <h2 class="footer-heading mb-4">Navigations</h2>
                  <ul class="list-unstyled">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Testimonials</a></li>
                    <li><a href="#">Contact Us</a></li>
                  </ul>
                </div>
                <div class="col-md-4">
                  <h2 class="footer-heading mb-4">Follow Us</h2>
                  <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                  <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                  <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                  <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
                </div>
              </div>
            </div>
            
          </div>
          <div class="row pt-5 mt-5 text-center">
            <div class="col-md-12">
              <div class="border-top pt-5">
              <p>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              </p>
              </div>
            </div>
            
          </div>
        </div>
      </footer>
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

<?php
$db_connection->close(); 
?>
  </body>
</html>