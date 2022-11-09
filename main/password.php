<?php
	session_start();
	include 'includes/config.php';
	$alert=NULL;
	
	if(!$_SESSION['user_id']){
	header('location:login.php');	
	}	
	$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
	$logged_user=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'"));
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));

if(isset($_POST['pass'])){
	$current_pass=md5($_POST['cr_password']);
	if($current_pass==$logged_user['password']) {
		if($_POST['new_password']==$_POST['c_new_password']) {
			$new_pass=mysqli_real_escape_string($conn,md5($_POST['new_password']));
			$check=mysqli_query($conn,"UPDATE users SET password='".$new_pass."' WHERE user_id='".$_SESSION['user_id']."'");
			if($check){
				$alert='<div class="alert alert-success">Password Changed!</div>';
			} else {
				$alert='<div class="alert alert-danger">Password Change Failed, Try Again Later!</div>';
			}
		} else {
			$alert='<div class="alert alert-danger">Password Not Match!</div>';
		}
	} else {
		$alert='<div class="alert alert-danger">Wrong Current Password!</div>';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard | <?php echo $settings['site_name'];?></title>
  <?php include 'includes/head.php';?>
</head>

<body>

  <!-- Sidenav -->
  <?php include 'includes/sidebar.php';?>
  
    <!-- Header -->
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 300px;background-image: url(assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
	
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
    </div>
	
    <!-- Page content -->
    <div class="container-fluid mt--9">
	  <form action="" method="post">
        <div class="col-12 order-xl-1">
		  <?php echo $alert;?>
          <div class="card bg-secondary">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h2>Change Password</h2>
                </div>
                <div class="col-4 text-right">
                  <button class="btn btn-primary" name="pass" type="submit">Update Password</button>
                </div>
              </div>
            </div>
            <div class="card-body">
                <h6 class="heading-small text-muted mb-4">User Password Update</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Current Password <small>(Required)</small></label>
                        <input type="password" name="cr_password" class="form-control form-control-alternative" placeholder="Enter Current Password">
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">New Password <small>(Must contain atleat 8 characters.)</small></label>
                        <input type="password" pattern=".{8,}" name="new_password" class="form-control form-control-alternative" placeholder="Enter New Password">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Confirm New Password <small>(Required)</small></label>
                        <input type="password" name="c_new_password" class="form-control form-control-alternative" placeholder="Confirm Password">
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
	  </form>
	  
      <!-- Footer -->
      <?php include "includes/panel_footer.php" ?>
    </div>
  </div>
  
  <!-- Argon Scripts -->
  
  <!-- Core -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Argon JS -->
  <script src="assets/js/theme.min.js"></script>
</body>

</html>