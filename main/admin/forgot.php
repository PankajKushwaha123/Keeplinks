<?php
	session_start();
	include '../includes/config.php';
	$alert=NULL;
	if($_SESSION['admin']){
		header('location:dashboard.php');	
	} elseif ($_SESSION['alert']) {
		$alert=$_SESSION['alert'];
		session_destroy();
	}
	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require("../includes/Exception.php");
	require("../includes/PHPMailer.php");
	
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
	$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
	$form='<div class="form-group">
                    <label>Username</label>
					<input class="form-control" type="text" name="username" required autofocus>
                  </div>
                  <div class="form-group">
                    <label>Email ID</label>
					<input class="form-control" type="email" name="email" required >
                  </div>
                  <div class="form-group">
					<input type="submit" class="btn btn-primary btn-lg btn-block" name="sendotp" value="Send OTP">
                  </div>
				  <div class="text-center mt-4 mb-3">
                    <a href="./"><div class="text-job text-muted">Login Now</div></a>
                  </div>';
	
	if(isset($_POST['sendotp'])){
		$admin=mysqli_query($conn,"SELECT * FROM admin WHERE username='".$_POST['username']."' AND email='".$_POST['email']."'");
		$check=mysqli_num_rows($admin);
		if($check==1){
			$admin=mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM admin WHERE username='".$_POST['username']."'"));
			$_SESSION['otp']=substr(str_shuffle('0123456789'),0,8);
			$mail = new PHPMailer();
			$mail->From = 'noreply@'.strtolower(str_replace(array("www.","subdomain.","other."),"",$_SERVER['SERVER_NAME']));
			$mail->FromName = $settings['site_name'];
			$mail->AddAddress($admin['email']);
			$mail->Subject = "One Time Password For Password Reset";
			$mail->Body = '<html><head><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Montserrat|Noto+Sans);#outlook a{padding:0}.ReadMsgBody{width:100%}.ExternalClass{width:100%}.ExternalClass, .ExternalClass div, .ExternalClass font, .ExternalClass p, .ExternalClass span, .ExternalClass td{line-height:100%}a,body,table,td{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}table,td{mso-table-lspace:0;mso-table-rspace:0}img{-ms-interpolation-mode:bicubic}body{margin:0;padding:0}img{border:0;height:auto;line-height:100%;outline:0;text-decoration:none}table{border-collapse:collapse !important}body{height:100% !important;margin:0;padding:0;width:100% !important}*{-ms-text-size-adjust:100%;-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%}.appleBody a{color:#68440a;text-decoration:none}.appleFooter a{color:#999;text-decoration:none}@media screen and (max-width:525px){table[class=wrapper]{width:100% !important}td[class=logo]{text-align:left;padding:0 !important}td[class=logo] img{margin:0 auto !important;padding:30px 0 !important}td[class=mobile-hide]{display:none}img[class=mobile-hide]{display:none !important}img[class=img-max]{max-width:100% !important;height:auto !important}table[class=responsive-table]{width:100% !important}td[class=padding-copy]{text-align:center}td[class=padding-meta]{text-align:center}td[class=no-pad]{padding:0 0 20px 0 !important}td[class=no-padding]{padding:0 !important}td[class=mobile-wrapper]{padding:10px 5% 15px 5% !important}table[class=mobile-button-container]{margin:0 auto;width:100% !important}a[class=mobile-button]{width:80% !important;padding:15px !important;border:0 !important;font-size:16px !important}}</style></head><body bgcolor="#f2f3f8" style="margin: 0; padding: 0;"><div align="center" width="100%" bgcolor="#ffffff" style="table-layout: fixed; padding: 0 15px 0 15px; border-radius: 4px 0 0 0;"> <a href="'.$site_url.'" target="_blank"><img alt="Logo" src="'.$site_url.'/assets/img/logo.png" width="180" height="120" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #666666; font-size: 16px; padding: 30px 0 30px 15px;" border="0"> </a></div><table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;"><tr><td bgcolor="f2f3f8" align="center" style="padding: 0 15px 0 15px;" class="section-padding"><table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"><tr><td align="left" style="font-size: 35px; font-family: Montserrat, Arial, sans-serif; color: #2c304d; padding: 30px 15px 0 15px;" class="padding-copy"> Hi '.$admin['username'].'</td></tr><tr><td align="left" style="padding: 20px 15px 0 15px; font-size: 15px; line-height: 25px; font-family: Noto Sans, Arial, sans-serif; color: #2c304d;" class="padding-copy">You tried to reset your password. But in order to reset the password, it is required to be verified if this is really you. So here is an OTP (One Time Password) that will be be required to verify your autheticity.</td></tr></table></td></tr><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container" bgcolor="#ffffff"><tr><td align="center" style="padding: 25px 0 0 0;" class="padding-copy"><table border="0" cellspacing="0" cellpadding="0" class="responsive-table"><tr><td align="center" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #e23f83; border-top: 15px solid #e23f83; border-bottom: 15px solid #e23f83; border-left: 35px solid #e23f83; border-right: 35px solid #e23f83; border-radius: 35px; -webkit-border-radius: 35px; -moz-border-radius: 35px; display: inline-block;" class="mobile-button"> '.$_SESSION['otp'].'</td></tr></table></td></tr></table></td></tr><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"><tr><td align="left" style="padding: 50px 15px 0 15px; font-size: 15px; line-height: 25px; font-family: Noto Sans, Arial, sans-serif; color: #2c304d;" class="padding-copy"> Please mind not to share this one time password with anyone.</td></tr></table></td></tr></table></td></tr></table></td></tr></table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;"><tr><td bgcolor="#f2f3f8" align="center" style="padding: 0 15px 0 15px;" class="section-padding-bottom-image"><table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" style="padding: 20px 15px 35px 15px; font-size: 15px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #aea9c3;" class="padding-copy"> <small>"The information contained in this electronic message and any attachments to this message are intended for the exclusive use of the addressee(s) and may contain confidential or privileged information. If you are not the intended recipient, destroy all copies of this message and any attachments. The views expressed in this E-mail message/attachments are those of the individual sender."</small></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;"><tr><td bgcolor="#f2f3f8" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td style="padding-top: 30px;"><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="responsive-table"><tr><td align="center" valign="middle" style="font-size: 12px; line-height: 24px; font-family: Noto Sans, Arial, sans-serif; color:#aea9c3; padding-bottom: 35px;"> <span class="appleFooter" style="color:#aea9c3;">You received this email because you tried to reset your password at '.$settings['site_name'].'</span></td></tr></table></td></tr></table></td></tr></table></body></html>';
			$mail->WordWrap = 70;
			$mail->IsHTML(true);
			if($mail->Send()){
				$alert='<div class="alert alert-success">A One Time Password (OTP) has been sent to to your email.</div>';
				$form='<div class="form-group">
                    <label>Username</label>
					<input class="form-control" value="'.$admin['username'].'" disabled>
                  </div>
                  <div class="form-group">
                    <label>Email ID</label>
					<input class="form-control" value="'.$admin['email'].'" disabled>
                  </div>
				  <div class="form-group">
                    <label>One Time Password</label>
					<input class="form-control" type="text" name="otp" placeholder="One Time Password" required autofocus>
                  </div>
                  <div class="form-group">
					<input type="submit" class="btn btn-primary btn-lg btn-block" name="verifyotp" value="Verify OTP">
                  </div>';
				$_SESSION['username']=$admin['username'];
			} else {
				$_SESSION['alert']='<div class="alert alert-danger">Following Error Occured >> '.$mail->ErrorInfo.'.</div>';
				header('location:forgot.php');
			}
		} else {
			$_SESSION['alert']='<div class="alert alert-danger">Invalid combination of Username and Email!</div>';
			header('location:forgot.php');
		}
	}

	if(isset($_POST['verifyotp'])){
		$admin=mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM admin WHERE username='".$_SESSION['username']."'"));
		if($_POST['otp']==$_SESSION['otp']){
			$alert='<div class="alert alert-success">Enter new password for your account.</div>';
			$form='<div class="form-group">
                    <label>Username</label>
					<input class="form-control" value="'.$admin['username'].'" disabled>
                  </div>
                  <div class="form-group">
                    <label>Email ID</label>
					<input class="form-control" value="'.$admin['email'].'" disabled>
                  </div>
				  <div class="form-group">
                    <label>New Password</label>
					<input class="form-control" type="password" name="password" placeholder="Enter New Password" required autofocus>
                  </div>
				  <div class="form-group">
                    <label>Confirm New Password</label>
					<input class="form-control" type="password" name="confirm-password" placeholder="Confirm New Password" required>
                  </div>
                  <div class="form-group">
					<input type="submit" class="btn btn-primary btn-lg btn-block" name="updatepass" value="Change Password">
                  </div>';
		} else {
			$alert='<div class="alert alert-danger">Invalid OTP! Please enter the otp sent to your email.</div>';
			$form='<div class="form-group">
                    <label>Username</label>
					<input class="form-control" value="'.$admin['username'].'" disabled>
                  </div>
                  <div class="form-group">
                    <label>Email ID</label>
					<input class="form-control" value="'.$admin['email'].'" disabled>
                  </div>
				  <div class="form-group">
                    <label>One Time Password</label>
					<input class="form-control" type="text" name="otp" placeholder="One Time Password" required autofocus>
                  </div>
                  <div class="form-group">
					<input type="submit" class="btn btn-primary btn-lg btn-block" name="verifyotp" value="Verify OTP">
                  </div>';
		}
	}
	
	if(isset($_POST['updatepass'])){
		$admin=mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM admin WHERE username='".$_SESSION['username']."'"));
		if($_POST['password']==$_POST['confirm-password']){
			$password=mysqli_real_escape_string($conn,$_POST['password']);
			$updatepass=mysqli_query($conn,"UPDATE admin SET password='".$password."' WHERE username='".$admin['username']."'");
			if($updatepass) {
				$_SESSION['alert']='<div class="alert alert-success">Your Password has successfully been updated! You can sign in now.</div>';
				header('location:index.php');
			} else {
				$alert='<div class="alert alert-danger">Something Went Wrong! Please Try Again.</div>';
			}
		} else {
			$alert='<div class="alert alert-danger">Password and Confirm Password are not same!</div>';
			$form='<div class="form-group">
                    <label>Username</label>
					<input class="form-control" value="'.$admin['username'].'" disabled>
                  </div>
                  <div class="form-group">
                    <label>Email ID</label>
					<input class="form-control" value="'.$admin['email'].'" disabled>
                  </div>
				  <div class="form-group">
                    <label>One Time Password</label>
					<input class="form-control" type="password" name="password" placeholder="Enter New Password" required autofocus>
                  </div>
				  <div class="form-group">
                    <label>One Time Password</label>
					<input class="form-control" type="password" name="confirm-password" placeholder="Confirm New Password" required>
                  </div>
                  <div class="form-group">
					<input type="submit" class="btn btn-primary btn-lg btn-block" name="updatepass" value="Change Password">
                  </div>';
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'head.php';?>
  <title>Password Reset | <?php echo $settings['site_name'];?></title>
  </head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="dist/img/logo.png" alt="logo" width="100" class="shadow-light rounded-circle"><br><?php echo $settings['site_name'];?>
            </div>
			<?php echo $alert;?>
            <div class="card card-primary">
              <div class="card-header" style="text-align:center;"><h4>Admin Password Reset</h4></div>
              <div class="card-body">
                <form method="post" action>
                  <?php echo $form;?>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="dist/modules/jquery.min.js"></script>
  <script src="dist/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="dist/js/stisla.js"></script>
  
  <!-- Template JS File -->
  <script src="dist/js/scripts.js"></script>
</body>
</html>