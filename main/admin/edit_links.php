<?php
error_reporting(0);
session_start();
$alert=NULL;
if (isset($_SESSION['admin'])) {
    include '../includes/config.php';
    $id = $_SESSION['admin'];
} else {
    header('location:index.php');
}

if(isset($_POST['update'])){
	$urls=mysqli_real_escape_string($conn,$_POST['urls']);
	$password=mysqli_real_escape_string($conn,$_POST['password']);
	$title=mysqli_real_escape_string($conn,$_POST['title']);
	$update=mysqli_query($conn,"UPDATE links SET urls='".$urls."', password='".$password."', title='".$title."', captcha='".$_POST['captcha']."', status='".$_POST['status']."' WHERE id='".$_GET['id']."'");
	if($update){
		header('location:links.php');
	} else {
		$alert='<div class="alert alert-danger">Failed, '.mysqli_error($conn).'</div>';
	}
}
$links=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM links WHERE id='".$_GET['id']."'"));
$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'head.php';?>
	<title>Edit Links | <?php echo $settings['site_name'];?></title>
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
            <h1>Edit Links</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
			  <div class="breadcrumb-item"><a href="dashboard.php">Manage Links</a></div>
              <div class="breadcrumb-item">Update Links</div>
            </div>
          </div>
          <div class="section-body">
            <h2 class="section-title">Update any link submitted by any user.</h2>
            <p class="section-lead">The user can revert the changes made to the links and status (except removal).</p>
		  </div>
			  <?php echo $alert;?>
        <div class="card">
          <div class="card-header">
            <h4>Edit Links</h4>
          </div>
          <div class="card-body">
			<form action="" method="post">
              <div class="form-group">
                <label>URL List</label>
				<textarea name="urls" style="height:200px;" class="form-control" placeholder="List of Urls"><?php echo $links['urls'];?></textarea>
              </div>
              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
				  <option value="active" <?php if($links['status']=='active'){echo 'selected';}else{echo'';}?>>Active</option>
				  <option value="blocked" <?php if($links['status']=='blocked'){echo 'selected';}else{echo'';}?>>Blocked</option>
				</select>
              </div>
			  <div class="form-group">
                <label>Captcha</label>
				<div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="captcha" value="on" <?php if($links['captcha']=='on'){echo 'checked';}else{echo'';}?>>
                  <label class="form-check-label">On</label>
                </div>
                  <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="captcha" value="off" <?php if($links['captcha']=='off'){echo 'checked';}else{echo'';}?>>
                  <label class="form-check-label">Off</label>
                </div>
              </div>
			  <div class="form-group">
                <label>Encryption Password</label>
                <input name="password" class="form-control" id="password" placeholder="Encryption Password" value="<?php echo $links['password'];?>">
              </div>
			  <div class="form-group">
                <label>Title</label>
                <input name="title" class="form-control" id="title" placeholder="Title" value="<?php echo $links['title'];?>">
              </div>
              <div class="card-footer">
                <input type="submit" class="btn btn-primary" name="update" value="Update">
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
  
  <!-- Template JS File -->
  <script src="dist/js/scripts.js"></script>
</body>
</html>