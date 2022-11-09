<?php
	session_start();
	include 'includes/config.php';
	$alert=NULL;
	
	if(!$_SESSION['user_id']){
		header('location:login.php');	
	}
	
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
	$currency=$settings['symbol'];
	$limit_amount=$settings['payout_limit'];
    if(isset($_POST['request'])){
        $logged_user=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'"));
		if($_POST['amount']>$logged_user['wallet']){
			$alert='<div class="alert alert-danger">You have insufficient wallet balance!</div>';
		} else {
			if($_POST['amount']<$limit_amount){
				$alert='<div class="alert alert-danger">Minimun '.$currency.$limit_amount.' is required</div>';
			} else {
				$amount=$_POST['amount'];
				$request_pay=mysqli_query($conn,"INSERT INTO transactions (user_id,amount,date,status) VALUES ('".$logged_user['user_id']."','".$_POST['amount']."','".date("Y-m-d")."','Pending')");
				if($request_pay){
					mysqli_query($conn,"UPDATE users SET wallet = wallet - ".$amount." WHERE user_id='".$logged_user['user_id']."'");
					$alert='<div class="alert alert-success"><i class="fa fa-check"></i> Amount '.$currency.$amount.' is requsted for payout.</div>';
				} else {
					$alert='<div class="alert alert-danger">Something is wrong</div>';
				}
			}
		}
	}
	
	$logged_user=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'"));
	
	$total_pay = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(amount) AS value_sum FROM transactions WHERE user_id='".$_SESSION['user_id']."' and status='paid'")); 
	$total_payout = $total_pay['value_sum'];
	
	$total_pen =  mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(amount) AS value_sum FROM transactions WHERE user_id='".$_SESSION['user_id']."' and status='pending'")); 
	$total_pending = $total_pen['value_sum'];

	if($total_pending==''){
		$total_pending=0;
	}
	
	if($total_payout==''){
		$total_payout=0;
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
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
		
          <!-- Status Cards -->
          <div class="row">
            <div class="col-xl-4 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Wallet Amount</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $currency;?> <?php echo round($logged_user['wallet'],4);?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-wallet"></i>
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
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Payouts</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $currency;?> <?php echo $total_payout;?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-money-check"></i>
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
                      <h5 class="card-title text-uppercase text-muted mb-0">Pending Payout</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $currency;?> <?php echo $total_pending;?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="fas fa-dollar-sign"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	
    <!-- Page content -->
    <div class="container-fluid mt--7">
        <div class="col-xl-12 mb-5 mb-xl-0 pb-4">
		  <?php echo $alert;?>
          <div class="card">
            <div class="card-header bg-transparent">
				<h3 class="mb-0">Request Payout (Minimum - <?php echo $currency;?> <?php echo $settings['payout_limit'];?>)</h3>
            </div>
            <div class="card-body">
              <form action="" method="post" role="form">
              <div class="row">
                <div class="col-lg-8">
                  <div class="form-group">
                    <input type="number" name="amount" class="form-control form-control-alternative" placeholder="Payout Amount" required>
                  </div>
                </div>
				<div class="col-lg-4">
                  <div class="form-group">
                    <button class="btn btn-primary" name="request" type="submit">Request Payout</button>
                  </div>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card">
            <div class="card-header border-0">
              <h3 class="mb-0">Payment History</h3>
            </div>
            <div class="table-responsive">
			
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
					<?php
						 $query   = "select * from transactions where user_id='" . $logged_user['user_id'] . "' ORDER BY ID desc";
							$results = mysqli_query($conn, $query);
							while($row=mysqli_fetch_assoc($results)) {
							if ($row['status'] == 'Paid') {
								$transtatus = 'success';
							} else if ($row['status'] == 'Pending') {
								$transtatus = 'warning';
							} else {
								$transtatus = 'danger';
							}
							echo '<tr>
							 <th scope="row">'.date("d M Y",strtotime($row['date'])).'</th>
							 <td>'.$currency.' '.$row['amount'].'</td>
							 <td><span class="badge badge-'.$transtatus.'">'.strtoupper($row['status']).'</span></td>
						  </tr>';
						}
					?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
		
      <!-- Footer -->
      <?php include "includes/panel_footer.php" ?>
    </div>
  </div>
  
  <!-- JS Libraries -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="assets/vendor/chart.js/dist/Chart.extension.js"></script>
  
  <!-- Theme JS -->
  <script src="assets/js/theme.min.js"></script>
  <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
  </script>
</body>

</html>