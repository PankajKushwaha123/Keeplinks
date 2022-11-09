<?php
session_start();
$alert=NULL;
if (isset($_SESSION['admin'])) {
    include '../includes/config.php';
    $id = $_SESSION['admin'];
} else {
    header('location:index.php');;
}

if(isset($_POST['dlt'])){
    $number=mysqli_num_rows(mysqli_query($conn,'SELECT * FROM pay_methods'));
    if($number>1) {
	    $delete=mysqli_query($conn,"DELETE FROM pay_methods WHERE id='".$_POST['id']."'");
	    if(!$delete){
			$alert='<div class="alert alert-danger">Failed to Delete.</div>';
		}
    } else {
        $alert='<div class="alert alert-danger">You must have atleast one payment method active.</div>';
    }
}
	
if(isset($_POST['add'])){
	$name=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM pay_methods WHERE name='".$_POST['name']."'"));
	$id=mysqli_fetch_assoc(mysqli_query($conn,"SELECT MAX(id)+1 AS PayId FROM pay_methods"));
	if($name<1) {
	    $method=mysqli_real_escape_string($conn,$_POST['name']);
		$add_name=mysqli_query($conn,"INSERT INTO pay_methods (id,name) VALUES ('".$id['PayId']."','".$method."')");
		if(!$add_name){
			$alert='<div class="alert alert-danger">Failed To Add New Payment Method.</div>';
		} else {
			$alert='<div class="alert alert-success">Successfully added new payment method.</div>';
		}
	} else {
		$alert='<div class="alert alert-danger">Payment Method already exists.</div>';
	}
}

$settings=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM settings WHERE id='1'"));
?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'head.php';?>
	<title>Payment Settings | <?php echo $settings['site_name'];?></title>
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
            <h1>Payment Methods</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Payment Methods</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Add or Remove the methods of payment offered.</h2>
            <p class="section-lead">Changing payment methods will not modify the existing selections of the users.</p>
            <div class="card">
			<?php echo $alert;?>
              <div class="row">
				<div class="col card-header">
                  <h4>List of All Payment Methods</h4>
                </div>
				<div style="text-align:right;" class="col">
				  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_method">Add New Payment Method</button>
				</div>
			  </div>
			  <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table">
                      <thead>
						<tr>
                          <th>#</th>
                          <th>Payment Method</th>
                          <th>Action</th>
						</tr>
                      </thead>
					  <tbody>
				      <?php
						while ($row = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM pay_methods ORDER BY id DESC"))) {
							echo '<tr>
						  <td>'.++$counter.'</td>
						  <td>'.$row['name'].'</td>
						  <td><form action="" method="post">
								<input type="hidden" name="id" value="'.$row['id'].'"> 
								<button class="btn btn-danger" type="submit" name="dlt">Delete</button>
							</form>
						  </td>
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
	  <div class="modal fade" tabindex="-1" role="dialog" id="add_method">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Add New Payment Method</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
			<form action="" method="post">
              <div class="modal-body">
                <div class="form-group">
                  <input class="form-control" name="name" placeholder="Name of The Payment Method" type="text" required>
                </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="add" class="btn btn-primary">Save changes</button>
              </div>
			</form>
            </div>
          </div>
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
      $("#table").dataTable({
      "columnDefs": [
      	{ "sortable": false, "targets": [2] }
      ]
      });
    </script>
  
  <!-- Template JS File -->
  <script src="dist/js/scripts.js"></script>
  <script src="dist/js/custom.js"></script>
</body>
</html>