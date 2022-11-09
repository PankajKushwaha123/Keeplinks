<?php
	session_start();
	include 'includes/config.php';
	if($_SESSION['user_id']){
		header('location:dashboard.php');	
	}
	$alert=NULL;
	
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
    if(isset($_POST['signup'])) {
    	$username=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE username='".$_POST['username']."'"));
    	$email=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE email='".$_POST['email']."'"));
		
		// Verify Captcha
    	if(isset($_POST['h-captcha-response'])){
            $secret = $settings["secret_key"];
            $verifyResponse = file_get_contents('https://hcaptcha.com/siteverify?secret='.$secret.'&response='.$_POST['h-captcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR']);
            $responseData = json_decode($verifyResponse);
            if($responseData->success){
                $captcha="passed";
            } else {
                $captcha="failed";
            }
        }
		
		// Process Registration
    	if($username>0){
    		$alert='<div class="alert alert-danger">Username "'.$_POST['username'].'" already used!</div>';
    	} elseif ($email>0){
    		$alert='<div class="alert alert-danger">Already Registered with '.$_POST['email'].'!</div>';
    	} elseif (empty($_POST['h-captcha-response'])){
    	    $alert='<div class="alert alert-danger">Please check the captcha box.</div>';
    	} elseif ($captcha=='failed') {
    	     $alert='<div class="alert alert-danger">Captcha Verification Failed. Please try Again.</div>';
    	} else {
    		$password=mysqli_real_escape_string($conn,md5($_POST['password']));
    		$register=mysqli_query($conn,"INSERT INTO users (`username`,`password`,`email`,`email2`,`wallet`,`name`,`status`,`pay_method`,`details`,`date`) VALUES ('".$_POST['username']."','".$password."','".$_POST['email']."','','0','".$_POST['name']."','Inactive','','','".date("Y-m-d")."')");
    		if($register){
    			$users=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE username='".$_POST['username']."'"));
    			$_SESSION['otp']=substr(str_shuffle('0123456789'),0,8);
    			$_SESSION['id']=$users['user_id'];
    			$_SESSION['email']=$_POST['email'];
    			header('location:confirm.php');
    		} else {
    			$alert='<div class="alert alert-danger">Invalid Data!</div>';
    		}
    	}
    }

	$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register | <?php echo $settings['site_name'];?></title>
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
              <h1 class="text-white">Start by creating an account!</h1>
              <p class="text-lead text-light">Use below form to register with us and get started for free.</p>
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
	
    <!-- Page content -->
    <div class="container mt--8 pb-5">
	
      <!-- Table -->
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
		<?php echo $alert;?>
          <div class="card bg-secondary border-0">
            <div class="card-header bg-transparent">
              <div class="text-muted text-center mt-2 mb-3">
			  Register With Us
			  </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form action="" method="post" role="form" autocomplete="off">
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input class="form-control" name="name" placeholder="Full Name" type="text" required autofocus>
                  </div>
                </div>
				<div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input class="form-control" name="username" placeholder="Userame (Publicly Visible)" type="text" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input class="form-control" name="email" placeholder="Email" type="email" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input class="form-control" name="password" placeholder="Password" type="password" required>
                  </div>
                </div>
                <div class="form-group">
                    <div class="text-muted text-center mt-2 mb-4">
				        <div style="display: inline-block;" class="h-captcha" data-sitekey="<?php echo $settings['site_key'];?>"></div><br>
				        <script src='https://www.hCaptcha.com/1/api.js' async defer></script>
			        </div>
                </div>
                <div class="row my-4">
                  <div class="col-12">
                    <div class="form-control form-control-alternative text-center">
                      By registering with us, you agree with our <a href="privacy.php" target="_blank">Privacy Policy</a>
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" name="signup" class="btn btn-primary mt-4">Create account</button>
                </div>
              </form>
            </div>
          </div>
		  <div class="row mt-3">
            <div class="col-6">
              <a href="login.php" class="text-light"><small>Login To Your Account</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="forgot.php" class="text-light"><small>Forgot Password?</small></a>
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