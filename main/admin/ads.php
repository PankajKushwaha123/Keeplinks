<?php
session_start();
$alert=NULL;
if (isset($_SESSION['admin'])) {
    include '../includes/config.php';
    $id = $_SESSION['admin'];
} else {
    header('location:index.php');;
}

if(isset($_POST['update_ad'])){
	$ads1=mysqli_real_escape_string($conn,$_POST['ads1']);
	$ads2=mysqli_real_escape_string($conn,$_POST['ads2']);
	$ads3=mysqli_real_escape_string($conn,$_POST['ads3']);
	$check=mysqli_query($conn,"UPDATE ads SET ads1='".$ads1."', ads2='".$ads2."', ads3='".$ads3."' WHERE id='1'");
	if(!$check){
		$alert='<div class="alert alert-danger">Something went wrong';
	}
}

$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'head.php';?>
	<title>Advertisements | <?php echo $settings['site_name'];?></title>
  </head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
	<?php include 'header.php';?>
    <?php include 'sidebar.php';?>
	
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Advertisement</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Advertisement</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Modify the ad codes for your site to earn revenue.</h2>
            <p class="section-lead">You can use any type of adverts, like scipts images or videos, as per your choice.</p>
		  </div>
			  <?php echo $alert;?>
        <div class="card">
              <div class="card-header">
                <h4>Ad Settings</h4>
              </div>
              <div class="card-body">
			  <form action="" method="post">
                <div class="form-group">
                  <label>Ad Code - 1 <small>(Left Side Advertisement)</small></label>
				  <textarea style="height:100px;" name="ads1" class="form-control" placeholder="Enter Your Advertisement Code"><?php echo $ads['ads1'];?></textarea>
                </div>
                <div class="form-group">
                  <label>Ad Code - 2 <small>(Right Side Advertisement)</small></label>
                  <textarea style="height:100px;" name="ads2" class="form-control" placeholder="Enter Your Advertisement Code"><?php echo $ads['ads2'];?></textarea>
                </div>
				<div class="form-group">
                  <label>Ad Code - 3 <small>(Bottom Long Advertisement)</small></label>
                  <textarea style="height:100px;" name="ads3" class="form-control" placeholder="Enter Your Advertisement Code"><?php echo $ads['ads3'];?></textarea>
                </div>
                <div class="card-footer">
                <input type="submit" class="btn btn-primary" name="update_ad" value="Update">
                </div>
			  </form>
			  </div>
		</div>
		</section>
      </div>
      <?php include 'footer.php';?>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="dist/modules/jquery.min.js"></script>
  <script src="dist/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="dist/js/stisla.js"></script>

  <!-- Page Specific JS File -->
  <script src="dist/js/bootstrap-modal.js"></script>
  
  <!-- Template JS File -->
  <script src="dist/js/scripts.js"></script>
</body>
</html>