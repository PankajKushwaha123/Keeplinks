<?php
session_start();
	include 'includes/config.php';
	$alert=NULL;
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
	$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
?>
<!DOCTYPE html>
<html>
<head>
	<title>Privacy Policy | <?php echo $settings['site_name'];?></title>
	<?php include 'includes/head.php';?>
</head>

<body class="bg-default">
  <div class="main-content">
    <!-- Navbar -->
    <?php include 'includes/navigation.php';?>
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8">
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <!-- Table -->
      <div class="row justify-content-center pb-4">
        <div class="col-lg-12 col-md-8">
          <div class="card bg-secondary border-0">
            <div class="card-header py-lg-5 bg-transparent">
			<div class="text-muted text-center"><strong>Our Privacy Policy</strong></div>
			</div>
			<div class="card-body px-lg-5 bg-transparent">
			  <div class="text-muted pb-5">
				<p><?php echo $settings['site_name'];?>'s policy is to respect and protect the privacy of our users. We, at <?php echo $settings['site_name'];?>, respect your privacy. All information collected at <?php echo $settings['site_name'];?> is kept confidential and will not be sold, resued, or rented in any way. We do not share your infromation with any 3rd parties.</p>
				<strong>IP Addresses:</strong>
				<p>IP addresses are logged by <?php echo $settings['site_name'];?> to ensure account safety features availability, measuring usage and statistics.</p>
				<strong>Email Addresses:</strong>
				<p>We collect email addresses of users at the time of registration as means of contact and verification. <?php echo $settings['site_name'];?> does not rent, sell, or share your email addresses with anyone.</p>
				<strong>Your account username and password:</strong>
				<p>Please note that your Username will be visible on your links page but it is your responsibility to keep your password confidential, so do not share it with anyone. If you use a public PC, make sure you log out prior to leaving <?php echo $settings['site_name'];?>'s site. You are solely responsible for keeping your password inviolable.</p>
				<strong>Certain Exceptional Disclosures:</strong>
				<p>We may disclose your information if necessary to protect our legal rights or if the information relates to actual or threatened harmful conduct or potential threats to the physical safety of any person. The disclosure of personal information may be required by court or law enforcement officials.</p>
				<strong>Use of Cookies:</strong>
				<p><?php echo $settings['site_name'];?> uses cookies in order to track and analyze preferences of our users and, as a result, improve our site. A cookie is an encrypted number, generated when you visit any site that supports sessions. This cookie is saved permanently on your computer. This data does not contain any secure information (just an encrypted string). Additionally, we set a cookie when you log in to make further logging into our system a little easier. No other website can access any information about you from the cookies we may store on your local computer. We do not share cookies or any other type of information with any other companies. You can always choose not to receive a cookie file by enabling your web browser to refuse cookies or to prompt you before accepting a cookie.</p>
				<strong>Third party cookies:</strong>
				<p>In case of serving advertisements to this site, our third-party advertiser may place or recognize a unique cookie on your browser.</p>
				<strong>External links:</strong>
				<p>If any part of the <?php echo $settings['site_name'];?> website links you to other websites, those websites do not operate under this Privacy Policy. We recommend you examine the privacy statements posted on those other websites to understand their procedures for collecting, using and disclosing personal information.</p>
				<strong>Changes to Privacy Policy:</strong>
				<p>We reserve the right, at any time and without notice, to add to, change, update, or modify this Privacy Policy. Any change, update, or modification will be effective immediately upon posting on the site. Please check this page periodically for changes.</p>
			  </div>
			  <div class="text-center">
                <a href="register.php" class="btn btn-primary">Register</a>
				<a href="login.php" class="btn btn-primary">Login</a>
              </div>
			</div>
          </div>
        </div>
      </div>
	  <div class="card text-muted text-center">
        <div class="card-header bg-transparent">
		  <i class="fas fa-ad"></i> Advertisement
        </div>
        <div class="card-body">
          <?php echo $ads['ads3'];?>
        </div>
      </div>
    </div>
  </div>
  <?php include 'includes/footer.php';?>
</body>
</html>