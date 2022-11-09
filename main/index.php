<?php
session_start();
	include 'includes/config.php';
	$alert=NULL;
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
	$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Protect Links | <?php echo $settings['site_name'];?></title>
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
              <h1 class="text-white">Earn <i class="fas fa-money-bill"></i> by Protecting Links</h1>
              <p class="text-lead text-light">Use this awesome service to protect your links with great convenience.</p>
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
      <div class="row justify-content-center pb-4">
        <div class="col-lg-12 col-md-8">
          <div class="card bg-secondary border-0">
            <div class="card-body px-lg-5 py-lg-5 bg-transparent pb-5">
			<form action="protected.php" method="post">
			  <div class="form-group">
				<div class="text-muted text-center mt-2 mb-4"><i class="fas fa-link"></i> Protect Your Links</div>
				<div class="input-group input-group-alternative mb-3">
				  <textarea class="form-control" name="urls" onkeyup="text()" rows="10" placeholder="Paste All Your URLs Here" autofocus required></textarea>
				</div>
              </div>
			  <hr class="my-4">
			  
			  <!-- Advanced Options Accordian -->
			  <div class="accordion" id="faqaccordian">
			  <div class="card">
				<div class="btn btn-secondary btn-lg btn-block" id="q1" data-toggle="collapse" data-target="#a1" aria-controls="a1">
				  <h5 class="mb-0"><i class="fas fa-cog fa-spin"></i> Advanced Settings (Optional)</h5>
				</div>
			    <div id="a1" class="collapse" aria-labelledby="q1" data-parent="#faqaccordian">
				  <div class="card-body">
                    <div class="form-group">
				  	  <div class="text-center text-muted mb-4">
					    <div class="container">
						  <div class="row">
						    <div class="col">
							  <div class="custom-control custom-radio mb-3">
							    <input value="on" name="captcha" class="custom-control-input" id="radio1" type="radio">
							    <label class="custom-control-label" for="radio1">Enable Captcha <small>(Recommended)</small></label>
							  </div>
						    </div>
						    <div class="col">
							  <div class="custom-control custom-radio mb-3">
							    <input value="off" name="captcha" class="custom-control-input" id="radio2" type="radio" checked>
							    <label class="custom-control-label" for="radio2">Disable Captcha</label>
						  	  </div>
						    </div>
					      </div>
					    </div>
					  </div>
				    </div>
				    <div class="form-group">
					  <div class="input-group input-group-alternative">
					    <div class="input-group-prepend">
					      <span class="input-group-text"><i class="fas fa-lock"></i></span>
					    </div>
					    <input class="form-control" name="password" placeholder="Password" type="password">
					  </div>
				    </div>
				    <div class="form-group">
					  <div class="input-group input-group-alternative">
					    <div class="input-group-prepend">
					      <span class="input-group-text"><i class="fas fa-code"></i></span>
					    </div>
					    <input class="form-control" name="title" placeholder="Link Page Title" type="text">
					  </div>
				    </div>
			      </div>
			    </div>
			  </div>
			  </div>
              <div class="d-flex justify-content-center mt-2">
				<span class="text-muted">By proceeding, you agree with our <a href="privacy.php">Privacy Policy</a></span>
			  </div>
              <div class="text-center">
                <button id="pro_btn" name="generate" type="submit" class="btn btn-primary mt-4"><i class="fa fa-shield"></i> Protect</button>
              </div>
			</form>
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