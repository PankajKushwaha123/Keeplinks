<?php

session_start();
	include 'includes/config.php';
	$alert=NULL;
	$link_id=$_GET['id'];
	$links=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM links WHERE link_id='".$link_id."'"));
	$user_details=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_id='".$links['user_id']."'"));		
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
	$ads=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ads WHERE id='1'"));
	$views=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM views WHERE link_id='".$link_id."'"));
	$links_status=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM links WHERE link_id='".$link_id."'"));

	$get_btn='on';
	$view_btn='off';
	$earn_limit=$settings['earn_limit'];
	$earn=$earn_limit/1000;
	$new_view=0;
	
	if($links['title']==''){
		$title="Protected Links";
	} else {
		$title=$links['title'];
	}
	
	if($links['user_id']==''){
		$user='A Guest';
	} else {
		$user=$user_details['username'];
	}
	
	if(isset($_POST['unlock'])){
		if($_POST['pass']==$links['password']){
			$links['password']='';
			$links['captcha']='';
			$view_btn='on';
			$get_btn='off';
		} else {
			$links['password']=$links['password'];
			$alert='<div class="alert alert-danger text-center"><i class="fa fa-exclamation-triangle"></i> Incorrect Password!</div>';
			$view_btn='on';
		}
	}
	
	if(isset($_POST['get'])){
		$get_btn='off';
		$view_btn='on';
	}

    if(isset($_POST['captcha_verify'])){ 
        if(isset($_POST['h-captcha-response']) && !empty($_POST['h-captcha-response'])){
            $secret = $settings["secret_key"];
            $verifyResponse = file_get_contents('https://hcaptcha.com/siteverify?secret='.$secret.'&response='.$_POST['h-captcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR']);
            $responseData = json_decode($verifyResponse);
            if($responseData->success){
                $get_btn='off';
                $links['captcha']='';
		    	$view_btn='on';
            }else{
                $alert = '<div class="alert alert-warning text-center"><i class="fa fa-ban"></i> Captcha Verification Failed.</div>';
            }
        } else {
            $alert = '<div class="alert alert-warning text-center"><i class="fa fa-ban"></i> Please check the captcha box.</div>';
        }
    }
	
	if($links_status!=1 or $links['status']=='blocked'){
		$content='<i class="fa fa-ban"></i> Unfortunately, the link does not exists or has been deleted permanently!';
		$user='N/A';
		$links['date']='N/A';
		$views='0';
		$get_btn='off';
		$view_btn='off';
		$links['captcha']='off';
	} else if($view_btn=='on' && $links['password']==''){
		$content='';
		$ip_add=$_SERVER['REMOTE_ADDR'];
		$check_ip=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM views WHERE link_id='".$link_id."' and ip_add='".$ip_add."'"));
		if(!$check_ip>=1){
			$insert=mysqli_query($conn,"INSERT INTO views (link_id,ip_add) VALUES ('".$link_id."','".$ip_add."')");
			if($insert) {
			    mysqli_query($conn,"UPDATE users SET wallet = wallet + $earn WHERE user_id='".$links['user_id']."'");
			    $new_view=1;
			}
		}
	} else {
		$content='';
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $title;?> | <?php echo $settings['site_name'];?></title>
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
    <div class="container mt--8 pb-2">
    
      <!-- Table -->
	  <div class="row pb-4">
          <div class="col-xl-4 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Created By</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $user;?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-user"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-xl-4 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Created On <small>(yyyy-mm-dd)</small></h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $links['date'];?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-calendar"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-xl-4 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Views</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $views+$new_view;?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="fas fa-chart-bar"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
	  <?php echo $alert;?>
	  <div class="row-lg-12 text-center pb-4">
	    <div class="card bg-secondary">
		  <div class="card-body bg-transparent row">
		    <div class="col-lg-4 col-xl-4">
              <div class="card-header bg-transparent text-muted"><i class="fas fa-ad"></i> Advertisement</div>
			  <?php echo $ads['ads1'];?>
		    </div>
		    <div class="col-lg-4 col-xl-4">
		      <div class="card-header bg-transparent text-muted">Link Box</div>
			  <div id="text-url">
			  <?php echo $content;
				if($links['captcha']=='on'){
				  include 'includes/captcha.php';
				} else if($get_btn=='on') {
			      include 'includes/get.php';
				} else if($view_btn=='on') {
				  include 'includes/view.php';
				} else {
				  $alert='<div class="alert alert-warning text-center"><i class="fa fa-exclamation-triangle"></i> Oops! Something went wrong. Please Try Again.</div>';
				}
			  ?>
			  </div>
		    </div>
		    <div class="col-lg-4 col-xl-4">
              <div class="card-header bg-transparent text-muted"><i class="fas fa-ad"></i> Advertisement</div>
			  <?php echo $ads['ads2'];?>
		    </div>
		  </div>
	    </div>
	  </div>
	  <div class="card text-muted text-center">
        <div class="card-header bg-transparent"><i class="fas fa-ad"></i> Advertisement</div>
        <div class="card-body">
          <?php echo $ads['ads3'];?>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <?php include 'includes/footer.php';?>
 
</body>

</html>