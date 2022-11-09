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
	<title>DMCA | <?php echo $settings['site_name'];?></title>
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
			<div class="text-muted text-center"><strong>Digital Millennium Copyright Act (DMCA)</strong></div>
			</div>
			<div class="card-body px-lg-5 bg-transparent">
			  <div class="text-muted pb-5">
				<p><strong><?php echo $settings['site_name'];?></strong> intends to fully comply with the Digital Millennium Copyright Act ("DMCA"), including the notice and "take down" provisions, and to benefit from the safe harbors immunizing <strong><?php echo $settings['site_name'];?></strong> from liability to the fullest extent of the law. <strong><?php echo $settings['site_name'];?></strong> reserves the right to terminate the account of any Member who infringes upon the copyright rights of others upon receipt of proper notification by the copyright owner or the copyright owner's legal agent. Included below are the processes and procedures that <strong><?php echo $settings['site_name'];?></strong> will follow to resolve any claims of intellectual property violations.</p>
				<p><strong><?php echo $settings['site_name'];?></strong> is not sharing any unauthorized files. No files are hosted on our website and server(s). For any copyright issues, you should contact the host(s) of the corresponding file.</p>
				<p>It’s against our policies/terms to post copyrighted material you don’t have authorization to use. If anybody finds any link(s) on our site which violate our terms in any case then he/she can report us as soon as possible.</p>
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
  
  <!-- Footer -->
  <?php include 'includes/footer.php';?>
</body>

</html>