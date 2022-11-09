<?php
session_start();
	include 'includes/config.php';
	$alert=NULL;
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
	$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
	$currency=$settings['symbol'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Earn Money | <?php echo $settings['site_name'];?></title>
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
			<div class="text-muted text-center">Our <i class="fas fa-money-bill"></i> <strong>Pay Per View</strong> Program is here.</div>
			</div>
			<div class="card-body px-lg-5 bg-transparent">
			  <p>We, at <strong><?php echo $settings['site_name'];?></strong>, offer the registered users an opportunity to earn money for sharing the links protected by them on <strong><?php echo $settings['site_name'];?></strong>. There are no restrictions on any country or person so this service can be used by anyone.</p>
              <p>The <strong>Pay Per View</strong> Program is open to anyone having a registered account with us.</p>
			  <p>When other visitors view the links protected by you, then your <?php echo $settings['site_name'];?> wallet balance will be credited automatically.</p>
              <hr class="my-3">
			  <div class="text-muted">
			  <div class="text-center">Terms & Conditions</div>
			  <ul>
				<li> Minimum Payout Amount is <?php echo $currency;?> <?php echo $settings['payout_limit'];?></li>
				<li> Only 2 visits per IP Address per day (24 hrs) will be counted.</li>
				<li> Payouts requested may take upto 2 Business Days to be processed.</li>
				<li> Any kind of abuse reported may result in temporary or permanent suspension of your account or the links or both.</li>
				<li> Attempts to gain revenue with misleading or other unethical methods will result in immediate suspension.</li>
				<li> We (<?php echo $settings['site_name'];?>) reserves the right to modify or withdraw the rewards program(s) without any prior notice.</li>
				<li> We pay equally for the traffic from any country.</li>
			  </ul>
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