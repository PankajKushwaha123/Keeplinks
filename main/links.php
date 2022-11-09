<?php
	session_start();
	include 'includes/config.php';
	$alert=NULL;
	
	if(!$_SESSION['user_id']){
	header('location:login.php');	
	}	
	
	$logged_user=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'"));
	$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
	if(isset($_POST['Block'])){
		mysqli_query($conn,"UPDATE links SET status='blocked' WHERE id='".$_POST['id']."'");
		$alert='<br><div class="alert alert-warning"><i class="fa fa-lock"></i>&nbsp;&nbsp;Link Blocked</div>';
	}
	
	if(isset($_POST['Unblock'])){
		mysqli_query($conn,"UPDATE links SET status='active' WHERE id='".$_POST['id']."'");
		$alert='<br><div class="alert alert-success"><i class="fa fa-unlock"></i>&nbsp;&nbsp;Link Activated</div>';
	}
	
	$active_links=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM links WHERE user_id='".$logged_user['user_id']."' and status='active'"));
	$other_links=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM links WHERE user_id='".$logged_user['user_id']."' and NOT status='active'"));
	$total_links=$active_links+$other_links;
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard | <?php echo $settings['site_name'];?></title>
  <link rel="stylesheet" href="assets/vendor/datatables/datatables.min.css">
  <?php include 'includes/head.php';?>
</head>

<body>

  <!-- Sidenav -->
  <?php include 'includes/sidebar.php';?>
  
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
		
          <!-- Sorting Options -->
          <div class="row">
            <div class="col-xl-4 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Links</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $total_links;?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                        <i class="fas fa-link"></i>
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
                      <h5 class="card-title text-uppercase text-muted mb-0">Active Links</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $active_links;?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                        <i class="fas fa-link"></i>
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
                      <h5 class="card-title text-uppercase text-muted mb-0">Blocked/Removed Links</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $other_links;?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-link"></i>
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
	
      <!-- Table -->
          <?php echo $alert;?>
		  <div class="card">
            <div class="card-header border-0">
              <h3 class="mb-0">Manage Links</h3>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush" ID="linkstab">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
					<th scope="col">Link ID</th>
                    <th scope="col">Created</th>
                    <th scope="col">Views</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
				  <?php
					while($row=mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM links WHERE user_id='".$logged_user['user_id']."' and NOT status='removed' ORDER BY id DESC"))) {
						if ($row['status'] == 'active') {
							$link_status = 'success';
							$action = 'Block';
							$icon = 'ban';
						} else {
							$link_status = 'warning';
							$action = 'Unblock';
							$icon = 'unlock';
						}
						$views=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM views WHERE link_id='".$row['link_id']."'"));
							echo '<tr>
						 <td>'.++$counter.'</td>
						 <th scope="row">'.$row['link_id'].'</th>
						 <td>'.date("d M Y",strtotime($row['date'])).'</td>
						 <td>'.$views.'</td>
						 <td><span class="badge badge-'.$link_status.'">'.strtoupper($row['status']).'</span></td>
						 <td>
							<form action="" method="post">
								<a data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-success" href="edit_link.php?id='.$row['link_id'].'"><i class="fa fa-pen"></i></a>
								<a data-toggle="tooltip" data-placement="top" title="View" class="btn btn-info" target="_blank" href="v/'.$row['link_id'].'"><i class="fa fa-eye"></i></a>
								<input type="hidden" name="id" value="'.$row['id'].'"/>
								<button data-toggle="tooltip" data-placement="top" title="'.$action.'" name="'.$action.'" class="btn btn-default"><i class="fa fa-'.$icon.'"></i></button>
							</form>
						 </td>
					  </tr>';
					}
				  ?>
                </tbody>
              </table>
            </div>
          </div>
		  
      <!-- Footer -->
      <?php include "includes/panel_footer.php" ?>
    </div>
  </div>
  
  <!-- Argon Scripts -->
  
  <!-- Core -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/datatables/datatables.min.js"></script>
  <script>
      $("#linkstab").dataTable({
      "columnDefs": [
      	{ "sortable": false, "targets": [5] }
      ]
      });
    </script>
	
  <!-- Argon JS -->
  <script src="assets/js/theme.min.js?v=1.0.0"></script>
</body>

</html>