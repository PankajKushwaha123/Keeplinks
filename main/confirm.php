<?php
	session_start();
	include 'includes/config.php';
	if(!$_SESSION['id']){
		header('location:login.php');	
	}
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
	$user=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_id='".$_SESSION['id']."'"));

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require("includes/Exception.php");
	require("includes/PHPMailer.php");

	if(isset($_POST['confirm'])){
		if ($_POST['otp']==$_SESSION['otp'] && $user['status']=='Active') {
			$confirmed=mysqli_query($conn,"UPDATE users SET email='".$_SESSION['email']."', email2=NULL WHERE user_id='".$_SESSION['id']."'");
			if($confirmed) {
				$_SESSION['alert']='<div class="alert alert-success">Your email has been confirmed successfully! You can sign in now.</div>';
				header('location:login.php');
			} else {
				$alert='<div class="alert alert-danger">Something Went Wrong! Please Try Again.</div>';
			}
		} elseif($_POST['otp']==$_SESSION['otp'] && $user['status']!='Active'){
			$confirmed=mysqli_query($conn,"UPDATE users SET status='Active' WHERE email='".$_SESSION['email']."'");
			if($confirmed) {
				$_SESSION['alert']='<div class="alert alert-success">Your Account has successfully been confirmed! You can sign in now.</div>';
				header('location:login.php');
			} else {
				$alert='<div class="alert alert-danger">Something Went Wrong! Please Try Again.</div>';
			}
		} else {
			$alert='<div class="alert alert-danger">Wrong OTP entered! Please Try Again.</div>';
		}
	} else {
        $mail = new PHPMailer();
        $mail->From = 'noreply@'.strtolower(str_replace(array("www.","subdomain.","other."),"",$_SERVER['SERVER_NAME']));
        $mail->FromName = $settings['site_name'];
    	$mail->AddAddress($_SESSION['email']);
    	$mail->Subject = "One Time Password For User Registration";
    	$mail->Body = '<html><head><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Montserrat|Noto+Sans);#outlook a{padding:0}.ReadMsgBody{width:100%}.ExternalClass{width:100%}.ExternalClass, .ExternalClass div, .ExternalClass font, .ExternalClass p, .ExternalClass span, .ExternalClass td{line-height:100%}a,body,table,td{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}table,td{mso-table-lspace:0;mso-table-rspace:0}img{-ms-interpolation-mode:bicubic}body{margin:0;padding:0}img{border:0;height:auto;line-height:100%;outline:0;text-decoration:none}table{border-collapse:collapse !important}body{height:100% !important;margin:0;padding:0;width:100% !important}*{-ms-text-size-adjust:100%;-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%}.appleBody a{color:#68440a;text-decoration:none}.appleFooter a{color:#999;text-decoration:none}@media screen and (max-width:525px){table[class=wrapper]{width:100% !important}td[class=logo]{text-align:left;padding:0 !important}td[class=logo] img{margin:0 auto !important;padding:30px 0 !important}td[class=mobile-hide]{display:none}img[class=mobile-hide]{display:none !important}img[class=img-max]{max-width:100% !important;height:auto !important}table[class=responsive-table]{width:100% !important}td[class=padding-copy]{text-align:center}td[class=padding-meta]{text-align:center}td[class=no-pad]{padding:0 0 20px 0 !important}td[class=no-padding]{padding:0 !important}td[class=mobile-wrapper]{padding:10px 5% 15px 5% !important}table[class=mobile-button-container]{margin:0 auto;width:100% !important}a[class=mobile-button]{width:80% !important;padding:15px !important;border:0 !important;font-size:16px !important}}</style></head><body bgcolor="#f2f3f8" style="margin: 0; padding: 0;"><div align="center" width="100%" bgcolor="#ffffff" style="table-layout: fixed; padding: 0 15px 0 15px; border-radius: 4px 0 0 0;"> <a href="'.$site_url.'" target="_blank"><img alt="Logo" src="'.$site_url.'/assets/img/logo.png" width="180" height="120" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #666666; font-size: 16px; padding: 30px 0 30px 15px;" border="0"> </a></div><table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;"><tr><td bgcolor="f2f3f8" align="center" style="padding: 0 15px 0 15px;" class="section-padding"><table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"><tr><td align="left" style="font-size: 35px; font-family: Montserrat, Arial, sans-serif; color: #2c304d; padding: 30px 15px 0 15px;" class="padding-copy"> Hi '.$user['username'].'</td></tr><tr><td align="left" style="padding: 20px 15px 0 15px; font-size: 15px; line-height: 25px; font-family: Noto Sans, Arial, sans-serif; color: #2c304d;" class="padding-copy"> We received your registration request. But to proceed, we need to verify your email. So find below your One Time Password (OTP) to prove your authenticity.</td></tr></table></td></tr><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container" bgcolor="#ffffff"><tr><td align="center" style="padding: 25px 0 0 0;" class="padding-copy"><table border="0" cellspacing="0" cellpadding="0" class="responsive-table"><tr><td align="center" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #e23f83; border-top: 15px solid #e23f83; border-bottom: 15px solid #e23f83; border-left: 35px solid #e23f83; border-right: 35px solid #e23f83; border-radius: 35px; -webkit-border-radius: 35px; -moz-border-radius: 35px; display: inline-block;" class="mobile-button"> '.$_SESSION['otp'].'</td></tr></table></td></tr></table></td></tr><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"><tr><td align="left" style="padding: 50px 15px 0 15px; font-size: 15px; line-height: 25px; font-family: Noto Sans, Arial, sans-serif; color: #2c304d;" class="padding-copy"> Please mind not to share this one time password with anyone.</td></tr></table></td></tr></table></td></tr></table></td></tr></table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;"><tr><td bgcolor="#f2f3f8" align="center" style="padding: 0 15px 0 15px;" class="section-padding-bottom-image"><table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" style="padding: 20px 15px 35px 15px; font-size: 15px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #aea9c3;" class="padding-copy"> <small>"The information contained in this electronic message and any attachments to this message are intended for the exclusive use of the addressee(s) and may contain confidential or privileged information. If you are not the intended recipient, destroy all copies of this message and any attachments. The views expressed in this E-mail message/attachments are those of the individual sender."</small></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;"><tr><td bgcolor="#f2f3f8" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td style="padding-top: 30px;"><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="responsive-table"><tr><td align="center" valign="middle" style="font-size: 12px; line-height: 24px; font-family: Noto Sans, Arial, sans-serif; color:#aea9c3; padding-bottom: 35px;"> <span class="appleFooter" style="color:#aea9c3;">You received this email because you are registering yourself with '.$settings['site_name'].'</span></td></tr></table></td></tr></table></td></tr></table></body></html>';
	    $mail->WordWrap = 70;
    	$mail->IsHTML(true);
	    if($mail->Send()){
    		$alert='<div class="alert alert-success">A One Time Password (OTP) has been sent to '.$_SESSION['email'].'</div>';
    	} else {
    		$_SESSION['alert']='<div class="alert alert-danger">Something went wrong! login to try again >> '.$mail->ErrorInfo.'.</div>';
    		header('location:login.php');
	    }
	}
	
	$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
?>
<!DOCTYPE html>
<html>
<head>
  <title>Confirm Email | <?php echo $settings['site_name'];?></title>
  <?php include 'includes/head.php';?>
</head>

<body class="bg-default">
  <div class="main-content">
  
    <!-- Navbar -->
    <?php include 'includes/navigation.php';?>
	
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">Welcome!</h1>
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
			  Confirm Your Account
			  </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form method="post" role="form" autocomplete="off" action>
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input class="form-control" name="otp" placeholder="One Time Password" type="text" required autofocus>
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
                  <button type="submit" name="confirm" class="btn btn-primary mt-4">Confirm Email</button>
                </div>
              </form>
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