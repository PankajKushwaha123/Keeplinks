<?php
	session_start();
	include 'includes/config.php';
	if($_SESSION['user_id']){
		header('location:dashboard.php');	
	} elseif($_SESSION['alert']){
		$alert=$_SESSION['alert'];
		session_destroy();
	}
	
if(isset($_POST['signin'])){
	$user_pass=mysqli_real_escape_string($conn,md5($_POST['password']));
	$users=mysqli_query($conn,"SELECT * FROM users WHERE username='".$_POST['username']."' AND password='".$user_pass."'");
	$check=mysqli_num_rows($users);
	$users=mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM users WHERE username='".$_POST['username']."'"));
	$user_status=$users['status'];
	if($check==1){
		if($user_status=="Disabled") {
			$alert='<div class="alert alert-danger"><strong>Your Account Has Been Disabled</strong></div>';
		} elseif($user_status=="Inactive") {
			$_SESSION['otp']=substr(str_shuffle('0123456789'),0,8);
			$_SESSION['id']=$users['user_id'];
			$_SESSION['email']=$users['email'];
			header('location:confirm.php');
		} else {
			session_start();
			$users=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE username='".$_POST['username']."'"));
			$_SESSION['user_id']=$users['user_id'];
			header('location:dashboard.php');
		}
	} else {
		$alert='<div class="alert alert-danger"><strong>Invalid Username/Password</strong></div>';
	}
}
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
	$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login | <?php echo $settings['site_name'];?></title>
  <?php include 'includes/head.php';?>
</head>

<body class="bg-default">
  <div class="main-content">
  
    <!-- Navbar -->
    <?php include 'includes/navigation.php';?>
	
    <!-- Header -->
    <div class="header bg-gradient-primary py-7">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">Welcome Once More!</h1>
			  <p class="text-lead text-light">Use this awesome page to login to your account.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
	
    <!-- Login Form -->
	<div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
		  <?php echo $alert;?>
          <div class="card bg-secondary border-0">
            <div class="card-header bg-transparent">
              <div class="text-muted text-center mt-2 mb-3">
				Login To Account
			  </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form action="" method="post">
                <div class="form-group mb-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input class="form-control" name="username" placeholder="Username" type="text" autofocus>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input class="form-control" name="password" placeholder="Password" type="password">
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" name="signin" class="btn btn-primary my-4">Sign in</button>
                </div>
              </form>
            </div>
          </div>
		  <div class="row mt-3">
            <div class="col-6">
              <a href="forgot.php" class="text-light"><small>Forgot password?</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="register.php" class="text-light"><small>Create new account</small></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <?php include 'includes/footer.php';?>
</body>

</html>