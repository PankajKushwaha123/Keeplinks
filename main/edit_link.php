<?php
	session_start();
	include 'includes/config.php';
	if(!$_SESSION['user_id']){
		header('location:login.php');	
	}	
	$link_id=$_GET['id'];
	$logged_user=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'"));
	$links=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM links WHERE link_id='".$link_id."'"));
	if(!$logged_user['user_id']==$links['user_id']){
		 header('location:links.php');
	}
	if(isset($_POST['update'])){
		$links=mysqli_real_escape_string($conn,$_POST['links']);
		mysqli_query($conn,"UPDATE links SET urls='".$links."' WHERE link_id='".$link_id."'");
		 header('location:links.php');
	}
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
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
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 300px; background-size: cover; background-position: center top;">
	
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
    </div>
	
    <!-- Page content -->
    <div class="container-fluid mt--9">
	  <form action="" method="post">
        <div class="col-12 order-xl-1">
          <div class="card bg-secondary">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h2>Edit Links</h2>
                </div>
                <div class="col-4 text-right">
                  <button class="btn btn-primary" name="update" type="submit">Update Links</button>
                </div>
              </div>
            </div>
            <div class="card-body">
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Links</label>
                        <textarea rows="10" type="text" name="links" class="form-control form-control-alternative" placeholder="Enter Your Links"><?php echo $links['urls'];?></textarea>
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

  <!-- Core -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Argon JS -->
  <script src="assets/js/theme.min.js?v=1.0.0"></script>
</body>

</html>