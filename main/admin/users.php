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

if (isset($_POST['Disable'])) {
    mysqli_query($conn, "UPDATE users SET status = 'Disabled' WHERE user_id ='".$_POST['id']."'");
    $alert='<div class="alert alert-danger">Account Deactivated Successfully.</div>';
}
if (isset($_POST['Enable'])) {
    mysqli_query($conn, "UPDATE users SET status = 'Active' WHERE user_id ='".$_POST['id']."'");
    $alert='<div class="alert alert-success">Account Activated Successfully.</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'head.php';?>
	<title>Mange Users | <?php echo $settings['site_name'];?></title>
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
            <h1>Manage Users</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Manage Users</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">List Of All Registered Users</h2>
            <p class="section-lead">Any actions performed here can be undone or overwriiten simply by the given option.</p>

                <div class="card">
				<?php echo $alert;?>
                  <div class="card-header">
                    <h4>List of All Registered Users</h4>
                  </div>
				  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="userdata">
                        <thead>
						<tr>
                          <th>#</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Date</th>
                          <th>Wallet</th>
						  <th>Status</th>
						  <th>Action</th>
						</tr>
                        </thead>
						<tbody id="myuserTable">
                        <?php
while ($row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users ORDER BY user_id DESC"))) {
    if ($row['status'] == 'Disabled') {
        $style_badge= "danger";
		$style		= "success";
        $status     = "Disabled";
		$action		= "Enable";
    } else {
        $style_badge= "success";
		$style		= "danger";
        $status     = "Active";
		$action		= "Disable";
    }
    echo '
      <tr>
        <td>'.++$counter.'</td>
        <td>'.$row['username'].'</td>
        <td>'.$row['email'].'</td>
        <td>'.$row['date'].'</td>
        <td>'.$currency.''.$row['wallet'].'</td>
        <td><span class="badge badge-'.$style_badge.'">'.$status.'</span></td>
        <td><form action="" method="post">
        <input type="hidden" name="id" value="'.$row['user_id'].'">
    <button type="submit" name="'.$action.'" class="btn btn-'.$style.'">'.$action.'</button></form></td>
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
  <script src="dist/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="dist/js/stisla.js"></script>
  
  <!-- JS Libraies -->
  <script src="dist/modules/jquery-ui/jquery-ui.min.js"></script>
  <script src="dist/modules/datatables/datatables.min.js"></script>
  
  <!-- Page Specific JS File -->
  <script>
	$("#userdata").dataTable({
	"columnDefs": [
		{ "sortable": false, "targets": [2,3] }
	]
	});
  </script>
  
  <!-- Template JS File -->
  <script src="dist/js/scripts.js"></script>
</body>
</html>