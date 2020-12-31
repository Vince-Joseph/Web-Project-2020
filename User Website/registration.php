<?php
    
    require("connection_file.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="registration page/reg.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- validation JavaScript -->
    <script type="text/javascript" src="registration page/reg.js"></script>

    <style type="text/css">
        #error_user_pwd,#error_user_pwd_format,#error_user_phone,#error_admin_phone{
            display: none;
        }
    </style> 
</head>
<body> 
    <?php
    $sql_check_user=$db_connection->prepare("SELECT id FROM user WHERE mobile=?");
    $sql_add_user=$db_connection->prepare("INSERT INTO user(original_name,mobile,gender,user_name,password) 
    VALUES(?,?,?,?,?)");
        if(isset($_POST['user_register']))
        {
            $user_mobile=$_POST['user_phone'];

            $sql_check_user->bind_param("s",$user_mobile);

            $sql_check_user->execute();
            $result=$sql_check_user->get_result();
            if($result->num_rows<1)
            {   
                $original_name=$_POST['user_name'];
                $gender=$_POST['user_gender'];
                $password=$_POST['user_password'];
                $user_name=$_POST['user_name'];
                //echo $original_name,$password,$user_mobile,$gender,$user_name;
                $sql_add_user->bind_param("sssss",$original_name,$user_mobile,$gender,$user_name,$password);
                //echo $sql_add_user->execute();
               if($sql_add_user->execute())
               {
                   
                   $sql_get_user_id=$db_connection->prepare("SELECT id FROM user WHERE mobile=?");
                   $sql_get_user_id->bind_param("s",$user_mobile);
                   $sql_get_user_id->execute();
                   $result_id=$sql_get_user_id->get_result();
                   $row=$result_id->fetch_assoc();
                   //print_r($result_id->fetch_assoc());
                   $_SESSION['reg_status']=1;
                   $_SESSION['user_id']=$row['id'];
                   //echo $_SESSION['user_id'],$_SESSION['reg_status'];
                   header("Location: index.php");
                   exit;
                ?>
                <!-- <div class="col-sm-6 mt-5 mx-auto">
                  <div class="alert alert-success alert-dismissible">
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>You have registered successfully !</strong>
                  </div>
                </div> -->
              <?php
               }
               else
               {
                ?>
                <div class="col-sm-6 mt-5 mx-auto">
                  <div class="alert alert-danger alert-dismissible">
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Server Error</strong>
                  </div>
                </div>
              <?php
               }
            }
            else
            {
                ?>
                <div class="col-sm-6 mt-5 mx-auto">
                  <div class="alert alert-danger alert-dismissible">
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>User already exists with this mobile number   </strong>
                  </div>
                </div>
              <?php
            }
        }
    ?>
<form action=" " method="post">
    <div class="container register">
        <div class="row">
            <div class="col-md-3 register-left pt-5">
                <!-- <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/> -->
                
                <h3>Project Name</h3>
                <p>Welcome, Reserve Room For Family Vacation!</p>
                <!-- <a href="login.php" class="btn bg-white">Login</a><br/> -->
            </div>
            <div class="col-md-9 register-right">
                <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Admin</a>
                    </li>
                </ul> 
                <!-- <form action=" " method="post"> -->
                <div class="tab-content" id="myTabContent"> 
                   
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">Apply as a User</h3>
                       
                        <div class="row register-form">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="User name *" name="user_name" required />
                                </div>
                                <div class="form-group">
                                    <input type="password" id="user_password" onkeyup="check_password('user_password','user_c_password')" 
                                    class="form-control" placeholder="Password *" name="user_password"
                                    required/>
                                </div>
                                <div class="text-danger" id="error_user_pwd_format">
                                   Password fomat doesn't match
                                </div>
                               
                                <div class="form-group">
                                    <input type="text" minlength="10" maxlength="10" name="user_phone" id="user_phone" 
                                    class="form-control" placeholder="Your Mobile Number *" onkeyup="check_phone(this.id,'error_user_phone')" 
                                    required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name *"  required/>
                                </div>
                                <div class="form-group">
                                    <input type="password" id="user_c_password" class="form-control"  placeholder="Confirm Password *"
                                    onkeyup="check_password('user_password','user_c_password')"  required/>
                                   
                                </div> 
                                
                                <span class="text-danger" id="error_user_pwd">
                                    Passwords doesn't match
                                </span>
                                <div class="form-group">
                                    <div class="maxl">
                                        <label class="radio inline"> 
                                            <input type="radio" name="user_gender" value="m" required>
                                            <span> Male </span> 
                                        </label>
                                        <label class="radio inline"> 
                                            <input type="radio" name="user_gender" value="f">
                                            <span>Female </span> 
                                        </label>
                                    </div>
                                    
                                </div>
                               </div>
                               <div class="col-md-12">
                                <span class="text-danger" id="error_user_phone">
                                    Invalid phone number !
                               </span>
                               </div> 
                                <input type="submit" onclick="" class="btnRegister1 mx-auto"  value="Register" id="user_register" name="user_register"/>
                           
                        </div>
                    </div>
                    <!-- </form>


                   <form action=" " method="post"> -->
                    
                    <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3  class="register-heading">Apply as an Admin</h3>
                        <div class="row register-form"> 
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="admin_user_name">User Name:</label>
                                    <input type="text" class="form-control" placeholder="User_name *" 
                                    name="admin_user_name" id="admin_user_name"/>
                                </div>
                                <div class="form-group">
                                <label for="admin_password">Password:</label>
                                    <input type="password" id="admin_password" name="admin_password" class="form-control" placeholder="Password *"/>
                                </div>
                                <div class="form-group">
                                <label for="admin_phone">Phone No.</label>
                                    <input type="phone" maxlength="10" minlength="10" id="admin_phone"
                                     name="admin_phone" class="form-control" placeholder="Phone *" 
                                    onkeyup="check_phone(this.id,'error_admin_phone')" />
                                    <span class="text-danger" id="error_admin_phone">
                                       Invalid phone number !
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="opentime">Opening Time:</label>
                                    <input type="time" id="opentime" class="form-control" placeholder="Opening Time *"/>
                                </div>
                                <div>
                                <label for="location">Lodge Location:</label>
                                    <input type="text" class="form-control" placeholder="Location *" name="location" id="location"/>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="admin_name">Name: </label>
                                    <input type="text" class="form-control" placeholder="Name *" id="admin_name" name="admin_name"/>
                                </div>
                                <div class="form-group">
                                <label for="admin_c_password">Confirm Password:</label>
                                    <input type="password" id="admin_c_password"  name="admin_c_password"
                                    class="form-control" placeholder="Confirm Password *" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Hotel Name *" />
                                </div>

                                <div class="form-group">
                                <label for="closetime">Closing Time:</label>
                                    <input type="time" id="closingtime" class="form-control" name="closingtime" placeholder="Closing Time *"/>
                                </div>
                                    <!-- <div class="maxl">
                                        <label class="radio inline"> 
                                            <input type="radio" name="gender" value="m">
                                            <span> Male </span> 
                                        </label>
                                        <label class="radio inline"> 
                                            <input type="radio" name="gender" value="f">
                                            <span>Female </span> 
                                        </label>
                                    </div> -->
                                </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control"></textarea>
                                        </div>
                                        
                                    </div>

                                <a onclick="" class="btnRegister2 btn"  href="#">Next</a>
                            </div> 
                                
                        </div>
                         
                    </div>
                   
                </div>
            
            </div>
        </div>

    </div>
    </form>
</body>
</html>
<?php
  $db_connection->close();
?>