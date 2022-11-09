<?php
session_start();
$alert=NULL;
if (isset($_SESSION['admin'])) {
    include '../includes/config.php';
    $id = $_SESSION['admin'];
} else {
    header('location:index.php');;
}

if(isset($_POST['update'])) {
	$username=mysqli_real_escape_string($conn,$_POST['username']);
	$password=mysqli_real_escape_string($conn,$_POST['password']);
    $update=mysqli_query($conn, "UPDATE admin SET username='".$username."',password='".$password."',email='".$_POST['email']."',2fa='".$_POST['2factor']."' WHERE id='1'");
    if($update){
		$alert='<div class="alert alert-success">Updated data successfully.</div>';
	} else {
		$alert='<div class="alert alert-danger">Failed to Update!</div>';
	}
}

$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
$admin_data=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admin WHERE id='1'"));
?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'head.php';?>
	<title>Admin Settings | <?php echo $settings['site_name'];?></title>
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
            <h1>Admin Credentials</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Admin Password</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Update Admin Credentials</h2>
            <p class="section-lead">The changes made here will be taken into action immediately.</p>
            
            <?php echo $alert;?>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <form action="" method="post">
                    <div class="card-header">
                      <h4>Administrator's Credentials</h4>
                    </div>
                    <div class="card-body">
					  <div class="row">
					    <div class="col-12 col-md-6 col-lg-6">
                          <div class="form-group">
							<label>Admin Username</label>
							<input type="text" name="username" value="<?php echo $admin_data['username']; ?>" class="form-control"/>
                          </div>
						  <div class="form-group">
							<label>Admin Email</label>
							<input type="email" name="email" value="<?php echo $admin_data['email']; ?>" class="form-control"/>
                          </div>
                        </div>
						<div class="col-12 col-md-6 col-lg-6">
						  <div class="form-group">
							<label>Admin Password</label>
							<input type="text" name="password" value="<?php echo $admin_data['password']; ?>" class="form-control"/>
                          </div>
						  <div class="form-group">
							<div class="form-group">
							  <label>2 Factor Authentication</label>
							  <select name="2factor" class="form-control">
								<option value="on"<?php if($admin_data['2fa']=='on') echo ' selected'?>>ON</option>
								<option value="off"<?php if($admin_data['2fa']=='off') echo ' selected'?>>OFF</option>
							  </select>
							</div>
						  </div>
						</div>
					  </div>
					  <div class="card-footer text-right">
					    <input type="submit" name="update" class="btn btn-primary" value="Update"/>
                      </div>
                  </form>
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
  
  <!-- Template JS File -->
  <script src="dist/js/scripts.js"></script>
</body>
</html>