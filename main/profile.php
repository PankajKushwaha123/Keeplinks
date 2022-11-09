<?php
	session_start();
	include 'includes/config.php';
	$alert=NULL;
	if(!$_SESSION['user_id']){
		header('location:login.php');	
	}
	
	$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));

	if(isset($_POST['update'])){
		$logged_user=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'"));
		$email=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE email='".$_POST['email']."' AND NOT email='".$logged_user['email']."'"));
		if($email==1){
			$alert='<div class="alert alert-danger">Email is already in use!</div>';
		} else {
			if ($_POST['email']==$logged_user['email']) {
				$update=mysqli_query($conn,"UPDATE users SET name='".$_POST['name']."', pay_method='".$_POST['pay_method']."', details='".$_POST['details']."' WHERE user_id='".$_SESSION['user_id']."'");
			} else {
				$update=mysqli_query($conn,"UPDATE users SET name='".$_POST['name']."', email2='".$_POST['email']."', pay_method='".$_POST['pay_method']."', details='".$_POST['details']."' WHERE user_id='".$_SESSION['user_id']."'");
			}
			if($update){
			  $alert='<div class="alert alert-success">Details updated successfully!</div>';
			} else {
			  $alert='<div class="alert alert-danger">Update failed! Please try again.</div>';
			}
		}
	} elseif (isset($_POST['verify'])) {
		$logged_user=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'"));
		session_unset();
		$_SESSION['otp']=substr(str_shuffle('0123456789'),0,8);
		$_SESSION['id']=$logged_user['user_id'];
		$_SESSION['email']=$logged_user['email2'];
		header('location:confirm.php');
	} elseif (isset($_POST['discard'])) {
		$update=mysqli_query($conn,"UPDATE users SET email2=NULL WHERE user_id='".$_SESSION['user_id']."'");
		$alert='<div class="alert alert-success">Discarded the email change successfully!</div>';
	}
	$logged_user=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'"));
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
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid align-items-center">
        <div class="row">
          <div class="col-lg-7 col-md-10">
            <h1 class="display-2 text-white">Hello <?php echo $logged_user['name'];?>!</h1>
            <p class="text-white mt-0 mb-5">This is your profile page. You can see and edit your profile very conveniently with this page.</p>
          </div>
        </div>
      </div>
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
                  <h2>My account</h2>
                </div>
                <div class="col-4 text-right">
                  <button class="btn btn-primary" name="update" type="submit">Update Details</button>
                </div>
              </div>
            </div>
            <div class="card-body">
                <h6 class="heading-small text-muted mb-4">User information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Full Name <small>(Required)</small></label>
                        <input type="text" name="name" id="input-first-name" class="form-control form-control-alternative" placeholder="Name" value="<?php echo $logged_user['name'];?>" required>
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Username <small>(Username cannot be changed)</small></label>
                        <input type="text" name="username" id="input-username" class="form-control form-control-alternative" placeholder="Username" value="<?php echo $logged_user['username'];?>" required disabled>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Email Address <small>(Required)</small></label>
                        <input type="email" name="email"  id="input-email" class="form-control form-control-alternative" placeholder="Email" value="<?php echo $logged_user['email'];?>" required>
                      </div>
                    </div>
                  </div>
				  <?php 
					  if ($logged_user['email2']!='') {
						echo '<div class="text-center"><small><strong>'.$logged_user['email2'].'</strong> is still unverified. Click here to: <button name="verify" type="submit" class="btn btn-primary btn-sm">VERIFY</button>OR <button name="discard" type="submit" class="btn btn-info btn-sm">DISCARD</button></small></div>';
					  }
					?>
                </div>
				<h6 class="heading-small text-muted mb-4">Payment Options</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="pay-method">Payment Method</label>
						<select name="pay_method" id="pay-method" class="form-control">
							<?php 
							$pay_methods = mysqli_query($conn, "select * from pay_methods");
							while($row=mysqli_fetch_assoc($pay_methods)) {
							?>
							<option value="<?php echo $row['name'];?>" <?php if($logged_user['pay_method']==$row['name']){echo 'selected';}?>><?php echo $row['name'];?></option>
							<?php
							}
							?>
						</select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="pay-user">User ID Registered With Selected Method</label>
                        <input type="text" name="details" class="form-control" value="<?php echo $logged_user['details'];?>" placeholder="Payment Details"/>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
	  </form>
      <!-- Footer -->
      <?php include 'includes/panel_footer.php'?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Argon JS -->
  <script src="assets/js/theme.min.js?v=1.0.0"></script>
</body>

</html>