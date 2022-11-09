<?php
session_start();
$alert=NULL;
if (isset($_SESSION['admin'])) {
    include '../includes/config.php';
} else {
	header('location:index.php');;
}

    $settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
	$currency=$settings['symbol'];
	
	$curdate=date("Y-m-d",strtotime("+1 day"));
	$beforedate=date("Y-m-d",strtotime("-30 day"));
	
	$result = mysqli_query($conn, "SELECT * FROM users");
    $ttl_users = mysqli_num_rows($result);
	
	$result = mysqli_query($conn, "SELECT * FROM users where date='".date("Y-m-d")."'");
    $td_ttl_refer = mysqli_num_rows($result);
    
	$result = mysqli_query($conn, "SELECT * FROM links");
    $ttl_click = mysqli_num_rows($result);
	
	$result = mysqli_query($conn, "SELECT * FROM transactions where status='paid'");
    $ttl_paid = mysqli_num_rows($result);

	$result = mysqli_query($conn, "SELECT * FROM links where date='" . date('Y-m-d', strtotime("-6 days")) . "'");
    $day7 = mysqli_num_rows($result);
    
    $result = mysqli_query($conn, "SELECT * FROM links where date='" . date('Y-m-d', strtotime("-5 days")) . "'");
    $day6 = mysqli_num_rows($result);
    
    $result = mysqli_query($conn, "SELECT * FROM links where date='" . date('Y-m-d', strtotime("-4 days")) . "'");
    $day5 = mysqli_num_rows($result);
    
    $result = mysqli_query($conn, "SELECT * FROM links where date='" . date('Y-m-d', strtotime("-3 days")) . "'");
    $day4 = mysqli_num_rows($result);
    
    $result = mysqli_query($conn, "SELECT * FROM links where date='" . date('Y-m-d', strtotime("-2 days")) . "'");
    $day3 = mysqli_num_rows($result);
    
    $result  = mysqli_query($conn, "SELECT * FROM links where date='" . date('Y-m-d', strtotime("-1 days")) . "'");
    $day2 = mysqli_num_rows($result);
    
    $result = mysqli_query($conn, "SELECT * FROM links where date='" . date("Y/m/d") . "'");
    $day1 = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php';?>
	<title>Admin Dashboard | <?php echo $settings['site_name'];?></title>
	<script src="dist/modules/chart.min.js"></script>
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
            <h1>Dashboard</h1>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Today's Users</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $td_ttl_refer;?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Users</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $ttl_users;?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Clicks</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $ttl_click;?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-list-ol"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>No. of Payments</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $ttl_paid;?>
                  </div>
                </div>
              </div>
            </div>                  
          </div>
		  <div class="row">
		    <div style="width: 100%;">
                <div class="card">
                  <div class="card-header">
                    <h4>Statistics (Links Created - Date)</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="myChart"></canvas>
                  </div>
                </div>
            </div>
          </div>
          <div class="row">
              <div style="width: 100%;" class="card">
                <div class="card-header">
                  <h4>Latest Signup(s)</h4>
                  <div class="card-header-action">
                    <a href="users.php" class="btn btn-primary">View All</a>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped mb-0">
                      <thead>
                        <tr>
                          <th>Username</th>
                          <th>Registered On</th>
                          <th>Status</th>
						  <th>Wallet Balance</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php
							$query   = "select * from users ORDER BY user_id DESC LIMIT 10";
							$results = mysqli_query($conn, $query);
							while ($row = mysqli_fetch_array($results)) {
								echo '
							 <tr>
								 <td>'.$row['username'].'</td>
								 <td>'.date("d M Y",strtotime($row['date'])).'</td>
								 <td><span class="badge badge-info">'.$row['status'].'</span></td>
								 <td>'.$currency.''.$row['wallet'].'</td>
							  </tr>';
							}
						?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
        </section>
      </div>
      <?php include 'footer.php'?>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="dist/modules/jquery.min.js"></script>
  <script src="dist/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="dist/js/stisla.js"></script>
  
	<!-- Page Specific JS File -->
  <script>
  var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["<?php echo date('d-m-Y', strtotime("-6 days"));?>", "<?php echo date('d-m-Y', strtotime("-5 days"));?>", "<?php echo date('d-m-Y', strtotime("-4 days"));?>", "<?php echo date('d-m-Y', strtotime("-3 days"));?>", "<?php echo date('d-m-Y', strtotime("-2 days"));?>", "<?php echo date('d-m-Y', strtotime("-1 days"));?>", "Today"],
    datasets: [{
      label: 'Links Created',
      data: [<?php echo $day7;?>, <?php echo $day6;?>, <?php echo $day5;?>, <?php echo $day4;?>, <?php echo $day3;?>, <?php echo $day2;?>, <?php echo $day1;?>],
      borderWidth: 2,
      backgroundColor: '#6777ef',
      borderColor: '#6777ef',
      borderWidth: 2.5,
      pointBackgroundColor: '#ffffff',
      pointRadius: 4
    }]
  },
  options: {
    legend: {
      display: false
    },
    scales: {
      yAxes: [{
        gridLines: {
          drawBorder: true,
          color: '#f2f2f2',
        },
        ticks: {
          beginAtZero: true,
          stepSize: 10
        }
      }],
      xAxes: [{
        ticks: {
          display: true
        },
        gridLines: {
          display: false
        }
      }]
    },
  }
});
</script>  

  <!-- Template JS File -->
  <script src="dist/js/scripts.js"></script>
</body>
</html>