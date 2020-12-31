<?php
require("connection_file.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>User Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="user_login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="user_login/bootstrap.min.css">
<!--===============================================================================================-->
	<!-- <link rel="stylesheet" type="text/css" href="user_login/font-awesome.min.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="user_login/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="user_login/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="user_login/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="user_login/util.css">
	<link rel="stylesheet" type="text/css" href="user_login/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<?php
				if(isset($_POST['login']))
				{
					$username=$_POST['username'];
					$password=$_POST['password'];
					//echo $username,$password;
					$sql_check_details=$db_connection->prepare("SELECT id FROM USER WHERE user_name=? AND password=?");
					$sql_check_details->bind_param("ss",$username,$password);
					$sql_check_details->execute();
					$result=$sql_check_details->get_result();

					if($result->num_rows>0)
					{
						
						$row=$result->fetch_assoc();
						$_SESSION['user_id']=$row['id'];


						$sql_update_booking_status=$db_connection->prepare("UPDATE rooms SET user_id=NULL,check_in=NULL,check_out=NULL,
						time_in='00:00:00', time_out='00:00:00',total_amount=0 
						WHERE user_id=? AND now()>concat(check_out,' ',time_out) ");
						$sql_update_booking_status->bind_param("i",$row['id']);
						$sql_update_booking_status->execute();

							
						$move_to_location=isset($_SESSION['from'])?$_SESSION['from']:"index.php";
						if($move_to_location==="dashboard.php")
						{
							$move_to_location.="?lodge_id=".$_SESSION['lodge_id'];
						}
						// else if($move_to_location=="contact.php")
						// {

						// }
						//echo $move_to_location;
						header("Location:".$move_to_location);
						exit;
					}
					else
					{
						?>
						<div class="col-sm-6 mt-5 mx-auto">
							<div class="alert alert-danger alert-dismissible">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<strong>Invalid username or password </strong>
							</div>
               			 </div>
						<?php
					}
				}
			?>
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="user_login/images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post" action=" ">
					<span class="login100-form-title font-weight-bold">
						User Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<input class="login100-form-btn text-center" value="Login" name="login" type="submit">
					</div>

					<!-- <div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div> -->

					<div class="text-center p-t-136">
						<a class="txt2 font-weight-bold" href="registration.php">
							Register Here
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="user_login/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="user_login/popper.js"></script>
	<script src="user_login/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="user_login/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="user_login/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="user_login/main.js"></script>

</body>
</html>
<?php
  $db_connection->close();
?>