<?php
error_reporting(0);
session_start();
$alert=NULL;
if (isset($_SESSION['admin'])) {
    include '../includes/config.php';
    $id = $_SESSION['admin'];
} else {
    header('location:index.php');;
}

	if(isset($_POST['lock'])){
		$f=mysqli_query($conn,"UPDATE links SET status='blocked' WHERE id='".$_POST['id']."'");
		if($f) {
		$alert='<div class="alert alert-danger alert-dismissible show fade"><div class="alert-body"><button class="close" data-dismiss="alert"><span>×</span></button>Link Blocked Successfully.</div></div>';
		} else {
			echo "error: ".mysqli_error($conn);
		}
	}
	if(isset($_POST['unlock'])){
		mysqli_query($conn,"UPDATE links SET status='active' WHERE id='".$_POST['id']."'");
		$alert='<div class="alert alert-success alert-dismissible show fade"><div class="alert-body"><button class="close" data-dismiss="alert"><span>×</span></button>Link Activated Successfully.</div></div>';
	}

$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'head.php';?>
	<title>Manage Links | <?php echo $settings['site_name'];?></title>
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
            <h1>Manage Links</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Manage Links</div>
            </div>
          </div>
          <div class="section-body">
            <h2 class="section-title">All Links</h2>
            <p class="section-lead">You can perform your desired action for a desired link from this panel.</p>
            <div class="card">
              <?php echo $alert;?>
              <div class="card-header">
                <h4>List of All links</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="linkdata">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Link ID</th>
                        <th>Created On</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        while ($row = mysqli_fetch_assoc(mysqli_query($conn, "select * from links ORDER BY id DESC"))) {
                            if ($row['status'] == 'blocked') {
                                $style_badge= "danger";
								$style		= "success";
                                $status     = "Blocked";
								$action		= "unlock";
                            } else {
                                $style_badge= "success";
								$style		= "danger";
                                $status     = "Active";
								$action		= "lock";
                            }
                            
                        	$users=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_id='".$row['user_id']."'"));
                            if($row['user_id']==''){
                        		$username='<i class="fa fa-shoe-prints"></i> A Visitor';
                        	} else {
                        		$username='<i class="fa fa-user"></i> '.$users['username'].'';
                        	}
                        	
                            echo '
                              <tr>
                                <td>'.++$counter.'</td>
                                <td>'.$row['link_id'].'</td>
                                <td>'.date("d M Y",strtotime($row['date'])).'</td>
                                <td>'.$username.'</td>
                                <td><span class="badge badge-'.$style_badge.'">'.$status.'</span></td>
                                <td>
                        		<form action="" method="post">
                        			<input type="hidden" name="id" value="'.$row['id'].'"/>
                        			<a href="edit_links.php?id='.$row['id'].'" class="btn btn-primary"><i class="fas fa-pen"></i></a>
                        			<a target="_blank" href="../v/'.$row['link_id'].'" class="btn btn-info"><i class="fas fa-eye"></i></a>
                        			<button name="'.$action.'" class="btn btn-'.$style.'"><i class="fas fa-'.$action.'"></i></button>
                        		</form></td>
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
	$("#linkdata").dataTable({
	"columnDefs": [
		{ "sortable": false, "targets": [5] }
	]
	});
  </script>
  
  <!-- Template JS File -->
  <script src="dist/js/scripts.js"></script>
</body>
</html>