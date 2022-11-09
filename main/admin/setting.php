<?php
session_start();
if (isset($_SESSION['admin'])) {
    include '../includes/config.php';
    $id = $_SESSION['admin'];
} else {
    header('location:index.php');;
}
if(isset($_POST['update_logo'])) {
        $file_tmp=$_FILES['logo_upload']['tmp_name'];
		$target_file="../assets/img/logo.png";
		if(move_uploaded_file($file_tmp,$target_file)){
			$alert='<div class="alert alert-success">Logo Updated Successfully!</div>';
		} else {
			$alert='<div class="alert alert-danger">Something went  wrong, please check the file uploaded.</div>';
		}
}
if (isset($_POST['settings_update'])) {
    if ($_POST['settings_update'] =='') {
		$alert='<div class="alert alert-danger">Some fields are blank!</div>';
    } else {
        $update=mysqli_query($conn, "UPDATE settings SET site_name='".$_POST['site_name']."',symbol='".$_POST['symbol']."',payout_limit='".$_POST['payout_limit']."',earn_limit='".$_POST['earn_limit']."',site_key='".$_POST['site_key']."',secret_key='".$_POST['secret_key']."' WHERE id='1'");
		if($update) {
			$alert='<div class="alert alert-success">Settings Updated Successfully!</div>';
		}
    }
}
$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
?>
<!DOCTYPE html>
<html lang="en">
   <?php include 'head.php';?>
	<title>Site Settings | <?php echo $settings['site_name'];?></title>
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
            <h1>Site Settings</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Site Settings</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Modify general settings for your frontend website.</h2>
            <p class="section-lead">
              You have to update the Site Settings and the Site Logo separately.
            </p>
		  </div>
		  <?php echo $alert;?>
		  <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
			  <div class="card">
				<div class="card-header">
                  <h4>General Settings</h4>
				</div>
				<div class="card-body">
				  <form action="" method="post">
					<div class="form-group">
					  <label>Site Name</label>
					  <input type="text" class="form-control" name="site_name" value="<?php echo $settings['site_name'];?>">
					</div>
					<div class="form-group">
					  <label>Currency Symbol</label>
					  <input type="text" class="form-control" name="symbol" value="<?php echo $settings['symbol'];?>">
					</div>
					<div class="form-group">
					  <label>Minimum Withdrawal Amount</label>
					  <input type="number" class="form-control" name="payout_limit" value="<?php echo $settings['payout_limit'];?>">
					</div>
					<div class="form-group">
					  <label>Amount For 1000 View</label>
					  <input type="number" class="form-control" name="earn_limit" value="<?php echo $settings['earn_limit'];?>">
					</div>
					<div class="form-group">
					  <label for="SiteKey">Site Key</label>
					  <input type="text" class="form-control" id="SiteKey" name="site_key" value="<?php echo $settings['site_key'];?>">
					</div>
					<div class="form-group">
					  <label for="SecretKey">Secret Key</label>
					  <input type="text" class="form-control" id="SecretKey" name="secret_key" value="<?php echo $settings['secret_key'];?>">
					</div>
					<div class="card-footer">
					  <input type="submit" class="btn btn-primary" name="settings_update" value="Update">
					</div>
				  </form>
				</div>
			  </div>
			</div>
			<div class="col-12 col-md-6 col-lg-6">
			  <div class="card">
				<div class="card-header">
				  <h4>Logo Settings</h4>
				</div>
				<div class="card-body">
				  <form action="" method="post" enctype="multipart/form-data">
					<div class="form-group">
					  <?php echo "<img src='../assets/img/logo.png?hash=".filemtime('logo.png')."' alt='Site Logo'>";?>
					</div>
					<div class="form-group">
					  <label>Site Logo</label>
					  <input type="file" class="form-control" name="logo_upload" required>
					</div>
					<div class="card-footer">
					  <input type="submit" class="btn btn-primary" name="update_logo" value="Update">
					</div>
				  </form>
				</div>
			  </div>
			  <div class="card">
				<div class="card-header">
				  <h4>Captcha Preview</h4><br>
				</div>
				<div class="card-body">
				  <small class="form-text text-muted">If you have made any modification to the scret/site key, then save it first then see the preview.</small>
				  <div style="width:100px;" class="h-captcha" data-sitekey="<?php echo $settings['site_key'];?>"></div>
				</div>
			  </div>
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
  <script src='https://www.hCaptcha.com/1/api.js' async defer></script>

  <!-- Template JS File -->
  <script src="dist/js/scripts.js"></script>
  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
</script>
</body>
</html>