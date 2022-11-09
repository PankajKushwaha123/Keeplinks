<?php
	session_start();
	include 'includes/config.php';
	$alert=NULL;
	$remove_id=$_GET['id'];
	$links_validation=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM links WHERE remove_id='".$remove_id."'"));
	if(!$links_validation<1){
		$link_st=mysqli_fetch_array(mysqli_query($conn,"SELECT status FROM links WHERE remove_id='".$remove_id."'"));
		$link_status=$link_st[0];
		if($link_status!="removed") {
			$remove=mysqli_query($conn,"UPDATE links SET status='removed' WHERE remove_id='".$remove_id."'");
			if($remove) {
				$alert='<i class="fa fa-check"></i> Link has been removed successfully!';
			}
		} else {
			$alert='<i class="fa fa-ban"></i> Link has already been removed.';
		}
	} else {
		$alert='<i class="fa fa-exclamation-triangle"></i> Link Does Not Exists.';
	}
	$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Delete Links | <?php echo $settings['site_name'];?></title>
	<?php include 'includes/head.php';?>
</head>

<body class="bg-default">
  <div class="main-content">
  
    <!-- Navbar -->
    <?php include 'includes/navigation.php';?>
	
    <!-- Header -->
    <div class="header bg-gradient-primary py-lg-8">
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
    <div class="container mt--8 pb-2">
	  <div class="row-lg-12 text-center pb-4">
	    <div class="card bg-secondary">
		  <div class="card-body bg-transparent row">
		    <div class="col">
              <div class="card-header bg-transparent text-muted">
                <i class="fas fa-ad"></i> Advertisement
		      </div>
			  <?php echo $ads['ads1'];?>
		    </div>
		    <div class="col">
		      <div class="card-header bg-transparent text-muted">Removing Links</div>
			  <?php echo $alert;?>
		    </div>
		    <div class="col">
              <div class="card-header bg-transparent text-muted"><i class="fas fa-ad"></i> Advertisement</div>
			  <?php echo $ads['ads2'];?>
		    </div>
		  </div>
	    </div>
	  </div>
	  <div class="card bg-secondary border-0 text-center">
		<div class="card-header bg-transparent">
          <div class="text-muted mt-2 mb-4"><i class="fas fa-ad"></i> Advertisement</div>
          <div class="card-body px-lg-2 bg-transparent">
			<?php echo $ads['ads3'];?>
		  </div>
		</div>
	  </div>
    </div>
  </div>
  
  <!-- Footer -->
  <?php include 'includes/footer.php';?>
</body>

</html>