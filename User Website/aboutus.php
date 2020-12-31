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
     
   
    <div class="site-section">
    <div class="site-section bg-light" id="about">
       <div class="container">
            <div class="row justify-content-center mb-5">
              <div class="col-md-7 text-center border-primary">
                <h2 class="font-weight-light text-primary">Why Us</h2>
                <p class="color-black-opacity-5">Let's find out</p>
              </div>
            </div>
          <div class="row mb-3 align-items-stretch">
              <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
                <div class="h-entry">
                  <img src="images/reliability.png" alt="Image" class="img-fluid rounded">
                  <h2 class="font-size-regular"><a href="#" class="text-black">Reliability</a></h2>
                  <p>Since 1999, We are the best company that provides reliable service across 4 different nations</p>
                </div> 
              </div>
              <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
                <div class="h-entry">
                  <style>
                    .h-entry img{
                      height:250px;
                      /* width:100%; */
                    }
                  </style>
                  <img src="images/customization.jpg" alt="Image" class="img-fluid rounded">
                  <h2 class="font-size-regular"><a href="#" class="text-black">Easy access and customization</a></h2>
                  <p>Provides easy access to informations regarding rooms and lodges and also
                      allows the user to customize the search according to his/her wish.
                  </p>
                </div> 
              </div>
              <div class="col-md-6 col-lg-4 mb-4 mb-lg-4">
                <div class="h-entry">
                  <img src="images/availability.png" alt="Image" class="img-fluid rounder">
                  <h2 class="font-size-regular"><a href="#" class="text-black">Availability</a></h2>
                  <p>Greater selection due to participation of almost all lodges around the country.</p>
                </div>
              </div>
  
          </div>
        </div>
      </div>
      <div class="site-section bg-white">
      <div class="container">

        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center border-primary">
            <h2 class="font-weight-light text-primary">Our Journey</h2>
          </div>
          <div class="col-md-12 text-center">
            <p>
                
            </p>
            <ul class="list-group">
                <li class="list-group-item">Establishment: 1999</li>
                <li class="list-group-item">Acquired BLS award: 2003</li>
                <li class="list-group-item">Establishing branches across two continents: 2005- 2007</li>
                <li class="list-group-item">Launch of Project XT: 2010</li>
                <li class="list-group-item">Further widening: 2014-2017</li>
            </ul>
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
    </div>
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
