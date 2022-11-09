<?php
	session_start();
	include 'includes/config.php';
	$alert=NULL;
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	if(isset($_POST['generate'])){
		$view_link=generateRandomString();
		$check_link=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM links WHERE link_id='".$view_link."'"));
		if($check_link>=1){
			$view_link="X".generateRandomString()."";
		} else {
			$view_link=generateRandomString();
		}
		$remove_link=generateRandomString();
		$check_remove_link=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM links WHERE remove_id='".$remove_link."'"));
		if($check_remove_link>=1){
			$remove_link="X".generateRandomString();
		} else {
			$remove_link=generateRandomString();
		}
		$urls=mysqli_real_escape_string($conn,$_POST['urls']);
		$password=mysqli_real_escape_string($conn,$_POST['password']);
		$title=mysqli_real_escape_string($conn,$_POST['title']);
		$save=mysqli_query($conn,"INSERT INTO links (link_id,remove_id,urls,password,title,user_id,captcha,date,status) VALUES ('".$view_link."','".$remove_link."','".$urls."','".$password."','".$title."','".$_SESSION['user_id']."','".$_POST['captcha']."','".date('Y-m-d')."','active')");
		if(!$save){
			$alert='<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Something went wrong, please try again!</div>';
		} else {
			$success='<div class="card-header bg-transparent text-muted">
			  <i class="fas fa-link"></i> URL To View The Links
			</div>
			<button type="button" class="btn btn-success" data-clipboard-text="'.$site_url.'v/'.$view_link.'">'.$site_url.'v/'.$view_link.'</button>
		    <div class="card-header bg-transparent text-muted">
			  <i class="fas fa-link"></i> URL To Delete The Links
			</div>
			<button type="button" id="del" class="btn btn-danger" data-clipboard-text="'.$site_url.'rem/'.$remove_link.'">'.$site_url.'rem/'.$remove_link.'</button>';
		}
	} else {
		header('location:index.php');
	}
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
	<div class="row-lg-12 text-center pb-4">
	  <div class="card bg-secondary border-0">
	    <div class="card-body bg-transparent row">
		  <div class="col-xl-4 col-lg-4">
            <div class="card-header bg-transparent text-muted">
              <i class="fas fa-ad"></i> Advertisement
		    </div>
		    <?php echo $ads['ads1'];?>
		  </div>
		  <div class="col-xl-4 col-lg-4">
		    <?php echo $alert;?>
			<?php echo $success;?>
		  </div>
		  <div class="col-xl-4 col-lg-4">
            <div class="card-header bg-transparent text-muted">
              <i class="fas fa-ad"></i> Advertisement
		    </div>
		    <?php echo $ads['ads2'];?>
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
  
  <!-- Page Specific JS -->
  <script src="assets/vendor/clipboard.js"></script>
  <script>
    var btns = document.querySelectorAll('button');
    var clipboard = new ClipboardJS(btns);
    clipboard.on('success', function(e) {
        console.log(e);
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });
  </script>
</body>

</html>