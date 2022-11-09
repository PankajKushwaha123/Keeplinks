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
	<title>FAQs | <?php echo $settings['site_name'];?></title>
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
			<div class="text-muted text-center"><strong>Frequently Asked Questions (FAQs)</strong></div>
			</div>
			<div class="card-body px-lg-5 bg-transparent">
			  <div class="text-muted pb-5">
				<div class="accordion" id="faqaccordian">
				  <div class="card">
					<div class="card-header" id="q1" data-toggle="collapse" data-target="#a1" aria-controls="a1">
					  <h5 class="mb-0">What is <?php echo $settings['site_name'];?>?</h5>
					</div>
					<div id="a1" class="collapse" aria-labelledby="q1" data-parent="#faqaccordian">
					  <div class="card-body">
						<p>It is a free service that helps you protect your links from inconvenient people or automated robots with security such as captcha and password. We will convert your links to direct links that will act as autoforwarders to your original links. In addition, we optionally provide you with the ability to limited access to those direct links with a CAPTCHA or/and password or with both. This protection will appear on a protected page.</p>
					  </div>
					</div>
				  </div>
				  <div class="card">
					<div class="card-header" id="q2" data-toggle="collapse" data-target="#a2" aria-controls="a2">
					  <h5 class="mb-0">How can I protect url?</h5>
					</div>
					<div id="a2" class="collapse" aria-labelledby="q1" data-parent="#faqaccordian">
					  <div class="card-body">
						<p>The easiest and most common way to protected links through our service is to go to our Home Page, input your links in the text area (box) and press the "Protect" button. This will generate a results page where several outputs will be listed as generated protected links and remove links. Go to 'Advanced Options' on Home Page to set your settings before submitting.</p>
					  </div>
					</div>
				  </div>
				  <div class="card">
					<div class="card-header" id="q3" data-toggle="collapse" data-target="#a3" aria-controls="a3">
					  <h5 class="mb-0">How can I delete/remove protected link?</h5>
					</div>
					<div id="a3" class="collapse" aria-labelledby="q3" data-parent="#faqaccordian">
					  <div class="card-body">
						<p>You can delete protected link with unique removal id, that you get after protect url on site (result page). Also you can delete protected links from your account "Manage Links" section.</p>
					  </div>
					</div>
				  </div>
				  <div class="card">
					<div class="card-header" id="q4" data-toggle="collapse" data-target="#a4" aria-controls="a4">
					  <h5 class="mb-0">What is the difference between a direct and a protected link?</h5>
					</div>
					<div id="a4" class="collapse" aria-labelledby="q4" data-parent="#faqaccordian">
					  <div class="card-body">
						<p>A direct link is a simple forwarder to the original link you have inputted (using a HTTP redirection). Those direct links do not have any protection system. They are fully compatible with any download managers. A protected link will point to a security page where a CAPTCHA or a password form will get displayed and required to be completed in order to access direct/live links (original links) listing.</p>
					  </div>
					</div>
				  </div>
				  <div class="card">
					<div class="card-header" id="q5" data-toggle="collapse" data-target="#a5" aria-controls="a5">
					  <h5 class="mb-0">What are the benefits of registering an account?</h5>
					</div>
					<div id="a5" class="collapse" aria-labelledby="q5" data-parent="#faqaccordian">
					  <div class="card-body">
						<p>A personal account will allow you to manage the protected links you create on our site. You will be able to edit, duplicate and delete them. See your complete protected links history. with a advance search feature. you can search your submitted links with protected url or original filename.</p>
					  </div>
					</div>
				  </div>
				  <div class="card">
					<div class="card-header" id="q6" data-toggle="collapse" data-target="#a6" aria-controls="a6">
					  <h5 class="mb-0">How can I register an account?</h5>
					</div>
					<div id="a6" class="collapse" aria-labelledby="q6" data-parent="#faqaccordian">
					  <div class="card-body">
						<p>Just click on the 'Forgot Password' link at the top right of the screen. You will be prompted by a small dialog and all you need to do is enter correct email address and submit... check our mail on inbox to recover your username or password.</p>
					  </div>
					</div>
				  </div>
				  <div class="card">
					<div class="card-header" id="q7" data-toggle="collapse" data-target="#a7" aria-controls="a7">
					  <h5 class="mb-0">How can I report improper links?</h5>
					</div>
					<div id="a7" class="collapse" aria-labelledby="q7" data-parent="#faqaccordian">
					  <div class="card-body">
						<p>If you are holder of an intellectual property right or you are an agent of such, and you feel that a <?php echo $settings['site_name'];?> violates this right, you may send us a DMCA report by using the 'Contact Us' button. We make sure to handle these reports in the quickest possible time. You also use contact us to report links pointing to dangerous materials (virus) - misleading videos or anything used to cause harm to our users.</p>
					  </div>
					</div>
				  </div>
				  <div class="card">
					<div class="card-header" id="q8" data-toggle="collapse" data-target="#a8" aria-controls="a8">
					  <h5 class="mb-0">I still have questions, what should I do?</h5>
					</div>
					<div id="a8" class="collapse" aria-labelledby="q8" data-parent="#faqaccordian">
					  <div class="card-body">
						<p>If you still have questions regarding our service please don't hesitate to contact us using our page</p>
					  </div>
					</div>
				  </div>
				</div>
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
  
  <!-- fOOTER -->
  <?php include 'includes/footer.php';?>
</body>

</html>