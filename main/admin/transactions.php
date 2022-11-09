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

$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
$currency=$settings['symbol'];

$transtype = "";
if (isset($_GET['trans'])) {
    if ($_GET['trans'] == 'paid') {
        $transtype = " WHERE status='paid' ";
    } elseif ($_GET['trans'] == 'rejected') {
        $transtype = " WHERE status='rejected' ";
    } else {
        $transtype = " WHERE status='pending' ";
    }
}

if (isset($_POST['paid'])) {
    $transid = $_POST['id'];
    $usersid = $_POST['userid'];
	$prev_status = $_POST['prev_stat'];
	if ($prev_status=='Rejected') {
		$alert='<div class="alert alert-danger">The request has been denied once. So it cannot be paid now!</div>';
	} else {
		mysqli_query($conn, "UPDATE transactions SET status = 'Paid' WHERE id ='".$transid."'");
	}
    header('location:transactions.php');
}

if (isset($_POST['rejected'])) {
    $transid = $_POST['id'];
    $usersid = $_POST['userid'];
    $useramount = $_POST['amount'];
    mysqli_query($conn, "UPDATE transactions SET status = 'Rejected' WHERE id ='".$transid."'");
    mysqli_query($conn, "UPDATE users SET wallet = wallet + $useramount WHERE user_id ='".$usersid."'");
    header('location:transactions.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'head.php';?>
	<title>Transactions | <?php echo $settings['site_name'];?></title>
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
              <h1>Withdrawal Requests</h1>
              <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
                <div class="breadcrumb-item">Transactions</div>
              </div>
            </div>
            <div class="section-body">
              <h2 class="section-title">Get the status wise list of requests.</h2>
              <p class="section-lead">Any actions performed here can be undone or overwriiten simply by the given option.</p>
              <div class="card">
                <?php echo $alert;?>
                <div class="card-header">
                  <h4>List of Withdrawal Requests</h4>
                </div>
                <div class="text-center">
                  <a href="transactions.php" class="btn btn-primary<?php if($transtype==''){echo' active';}?>">All Requests</a>&nbsp;
				  <a href="?trans=paid" class="btn btn-success<?php if($transtype=='paid'){echo' active';}?>"><i class="fas fa-check"></i> Paid Requests</a>&nbsp;
                  <a href="?trans=pending" class="btn btn-warning<?php if($transtype=='pending'){echo' active';}?>"><i class="fas fa-exclamation-triangle"></i> Pending Requests</a>&nbsp;
                  <a href="?trans=rejected" class="btn btn-danger<?php if($transtype=='rejected'){echo' active';}?>"><i class="fas fa-times"></i> Rejected Requests</a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="transdata">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Date</th>
                          <th>Username</th>
                          <th>Payment Amount</th>
                          <th>Payment Method</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $query   = "select * from transactions $transtype";
                          $results = mysqli_query($conn, $query);
                          
                          while ($row = mysqli_fetch_assoc($results)) {
                               if ($row['status'] == 'Pending') {
                                  $transtatus = 'warning';
                              } elseif ($row['status'] == 'Paid') {
                                  $transtatus = 'success';
                              } else {
                                  $transtatus = 'danger';
                              }
                              
                              $users=mysqli_fetch_array(mysqli_query($conn,"SELECT * from users where user_id='".$row['user_id']."'"));
                              echo '
                                <tr>
                                  <td>'.++$counter.'</td>
                                  <td>'.date('d M Y',strtotime($row['date'])).'</td>
                                  <td><i class="fas fa-user"></i> '.$users['username'].'</td>
                                  <td>'.$currency.' '.$row['amount'].'</td>
                                  <td>('.$users['pay_method'].') '.$users['details'].'</td>
                                  <td><span class="badge badge-'.$transtatus.'">'.$row['status'].'</span></td>
                                  <td><form action="" method="post"><input type="hidden" name="id" value="'.$row['id'].'"><input type="hidden" name="userid" value="'.$row['user_id'].'"><input type="hidden" name="amount" value="'.$row['amount'].'"><input type="hidden" name="prev_stat" value="'.$row['status'].'"><div class="btn-group">
                          	    <button type="submit" name="paid" value="Paid" class="btn btn-success">Paid</button>&nbsp;
                          		<button type="submit" name="rejected" value="Reject" class="btn btn-danger">Reject</button>
                            </div></form></td>
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
        <?php include 'footer.php';?>
      </div>
    </div>
    <!-- General JS Scripts -->
    <script src="dist/modules/jquery.min.js"></script>
    <script src="dist/modules/tooltip.js"></script>
    <script src="dist/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="dist/js/stisla.js"></script>
    <!-- JS Libraies -->
    <script src="dist/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="dist/modules/datatables/datatables.min.js"></script>
    <!-- Page Specific JS File -->
    <script>
      $("#transdata").dataTable({
      "columnDefs": [
      	{ "sortable": false, "targets": [6] }
      ]
      });
    </script>
    <!-- Template JS File -->
    <script src="dist/js/scripts.js"></script>
  </body>
</html>