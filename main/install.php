<?php
$alert=NULL;
session_start();
if ($_SESSION['step']==NULL) {
	$_SESSION['step']='start';
}

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    $protocol  = "https";
} else {
    $protocol  = "http";
}
$base_url = $protocol.'://'.$_SERVER['HTTP_HOST'].pathinfo($_SERVER['PHP_SELF'])['dirname'];

include 'includes/config.php';

if (isset($_POST['initial'])) {
	session_unset();
	header('location:install.php');
} elseif(isset($_POST['install'])) {
	$_SESSION['step']='installdb';
} elseif (isset($_POST['upgrade'])) {
	$_SESSION['step']='upgradedb';
} elseif (isset($_POST['dbsubmit'])) {
	$db_host = filter_var($_POST['dbhost'], FILTER_SANITIZE_SPECIAL_CHARS);
	$db_name = filter_var($_POST['dbname'], FILTER_SANITIZE_SPECIAL_CHARS);
	$db_user = filter_var($_POST['dbuser'], FILTER_SANITIZE_SPECIAL_CHARS);
	$db_password = filter_var($_POST['dbpass'], FILTER_SANITIZE_SPECIAL_CHARS);
	$config_text = '<?php
error_reporting(0);

// Database Connection
$conn=mysqli_connect("'.$db_host.'","'.$db_user.'","'.$db_password.'","'.$db_name.'");

// Site URL
$site_url="'.$base_url.'";
?>';

	if(file_put_contents('includes/config.php', $config_text)) {
		$connect = mysqli_connect($db_host, $db_user, $db_password);
		if(!$connect) {
			die('Connection failed: ' . mysqli_connect_error());
		}
		$sql_create_db = 'CREATE DATABASE IF NOT EXISTS '.$db_name.';';
		if(mysqli_query($connect, $sql_create_db) == true) {
			mysqli_select_db($connect, $db_name);
			$sql_tables[] = "CREATE TABLE `admin` (
  `id` int(16) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `2fa` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				";
			$sql_tables[] = "CREATE TABLE `ads` (
  `id` int(16) NOT NULL,
  `ads1` varchar(1024) NOT NULL,
  `ads2` varchar(1024) NOT NULL,
  `ads3` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				";
			$sql_tables[] = "CREATE TABLE `links` (
  `id` int(16) NOT NULL,
  `link_id` varchar(256) NOT NULL,
  `remove_id` varchar(256) NOT NULL,
  `urls` longtext NOT NULL,
  `password` varchar(32) NOT NULL,
  `title` varchar(64) NOT NULL,
  `captcha` varchar(16) NOT NULL,
  `user_id` varchar(128) NOT NULL,
  `status` varchar(32) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				";
			$sql_tables[] = "CREATE TABLE `pay_methods` (
  `id` int(16) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				";
			$sql_tables[] = "CREATE TABLE `settings` (
  `id` int(16) NOT NULL,
  `site_name` varchar(256) NOT NULL,
  `symbol` varchar(256) NOT NULL,
  `payout_limit` varchar(32) NOT NULL,
  `earn_limit` varchar(32) NOT NULL,
  `site_key` varchar(256) NOT NULL,
  `secret_key` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				";
			$sql_tables[] = "CREATE TABLE `transactions` (
  `id` int(16) NOT NULL,
  `user_id` varchar(256) NOT NULL,
  `amount` varchar(256) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				";
			$sql_tables[] = "CREATE TABLE `users` (
  `user_id` int(16) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `email2` varchar(256) NOT NULL,
  `wallet` varchar(32) NOT NULL,
  `name` varchar(256) NOT NULL,
  `status` varchar(32) NOT NULL,
  `pay_method` varchar(256) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				";
			$sql_tables[] = "CREATE TABLE `views` (
  `id` int(16) NOT NULL,
  `link_id` varchar(32) NOT NULL,
  `ip_add` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				";
			$sql_table_alters[] = "ALTER TABLE `admin` ADD PRIMARY KEY (`id`);";
			$sql_table_alters[] = "ALTER TABLE `ads` ADD PRIMARY KEY (`id`);";
			$sql_table_alters[] = "ALTER TABLE `links` ADD PRIMARY KEY (`id`);";
			$sql_table_alters[] = "ALTER TABLE `pay_methods` ADD PRIMARY KEY (`id`);";
			$sql_table_alters[] = "ALTER TABLE `settings` ADD PRIMARY KEY (`id`);";
			$sql_table_alters[] = "ALTER TABLE `transactions` ADD PRIMARY KEY (`id`);";
			$sql_table_alters[] = "ALTER TABLE `users` ADD PRIMARY KEY (`user_id`);";
			$sql_table_alters[] = "ALTER TABLE `views` ADD PRIMARY KEY (`id`);";
			$sql_table_alters[] = "ALTER TABLE `admin` MODIFY `id` int(16) NOT NULL AUTO_INCREMENT=2;";
			$sql_table_alters[] = "ALTER TABLE `ads` MODIFY `id` int(16) NOT NULL AUTO_INCREMENT=2;";
			$sql_table_alters[] = "ALTER TABLE `links` MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;";
			$sql_table_alters[] = "ALTER TABLE `pay_methods` MODIFY `id` int(16) NOT NULL AUTO_INCREMENT=2;";
			$sql_table_alters[] = "ALTER TABLE `settings` MODIFY `id` int(16) NOT NULL AUTO_INCREMENT=2;";
			$sql_table_alters[] = "ALTER TABLE `transactions` MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;";
			$sql_table_alters[] = "ALTER TABLE `users` MODIFY `user_id` int(16) NOT NULL AUTO_INCREMENT;";
			$sql_table_alters[] = "ALTER TABLE `views` MODIFY `id` int(16) NOT NULL AUTO_INCREMENT";
			$sql_table_alters[] = "INSERT INTO settings (id, site_name, symbol, payout_limit, earn_limit, site_key, secret_key) VALUES ('1', 'KeepLinks', '$', '25', '1', 'hCaptcha_Site_Key', 'hCaptcha_Secret_Key')";
			$sql_table_alters[] = "INSERT into pay_methods (id, name) VALUES ('1', 'Paypal')";
			$sql_table_alters[] = "INSERT INTO ads (id, ads1, ads2, ads3) VALUES ('1', '<--Ad Code-->', '<--Ad Code-->', '<--Ad Code-->')";
	       	foreach($sql_tables as $sql_table) {
	       		if(mysqli_query($connect, $sql_table) === false) {
		   			$alert = '<div class="alert alert-danger">The database table could not be created.</div>';
	       		}
	       	}
		   	foreach($sql_table_alters as $sql_table_alter) {
				mysqli_query($connect, $sql_table_alter);
	       	}
   			mysqli_close($connect);
			$_SESSION['step']='installad';
		} else {
			$alert = '<div class="alert alert-danger">The database could not be created.</div>';
		}
	} else {
		$alert = '<div class="alert alert-danger">Unable to write config file.</div>';
	}
} elseif (isset($_POST['adsubmit'])) {
	$ad_username=mysqli_real_escape_string($conn,$_POST['adname']);
	$ad_password=mysqli_real_escape_string($conn,$_POST['adpass']);
	$done=mysqli_query($conn,"INSERT INTO admin (id, username, password, email, 2fa) VALUES ('1', '".$ad_username."', '".$ad_password."', '".$_POST['ademail']."', 'off')");
	if($done) {
		unlink('install.php');
		session_unset();
		header('location:./');
	} else {
		$alert = '<div class="alert alert-danger">'.mysqli_error($con).'</div>';
	}
} elseif (isset($_POST['dbupgrade'])) {
	$db_host = filter_var($_POST['dbhost'], FILTER_SANITIZE_SPECIAL_CHARS);
	$db_name = filter_var($_POST['dbname'], FILTER_SANITIZE_SPECIAL_CHARS);
	$db_user = filter_var($_POST['dbuser'], FILTER_SANITIZE_SPECIAL_CHARS);
	$db_password = filter_var($_POST['dbpass'], FILTER_SANITIZE_SPECIAL_CHARS);
	$config_text = '<?php
error_reporting(0);

// Database Connection
$conn=mysqli_connect("'.$db_host.'","'.$db_user.'","'.$db_password.'","'.$db_name.'");

// Site URL
$site_url="'.$base_url.'";
?>';
	if(file_put_contents('includes/config.php', $config_text)) {
		$connect = mysqli_connect($db_host, $db_user, $db_password);
		if(!$connect) {
			die('Connection failed: ' . mysqli_connect_error());
		}
		$sql_create_db = 'CREATE DATABASE IF NOT EXISTS '.$db_name.';';
		if(mysqli_query($connect, $sql_create_db) == true) {
			mysqli_select_db($connect, $db_name);
			$sql_table_alters[] = "ALTER TABLE `admin` ADD email varchar(256);";
			$sql_table_alters[] = "ALTER TABLE `admin` ADD 2fa varchar(16);";
			$sql_table_alters[] = "ALTER TABLE `users` ADD email2 varchar(256);";
			
		   	foreach($sql_table_alters as $sql_table_alter) {
	   			mysqli_query($connect, $sql_table_alter);
	       	}
   			mysqli_close($connect);
			$_SESSION['step']='upgradead';
		} else {
			$alert = '<div class="alert alert-danger">The database could not be created.</div>';
		}
	} else {
		$alert = '<div class="alert alert-danger">Unable to write config file.</div>';
	}
} elseif (isset($_POST['adupgrade'])) {
	$done=mysqli_query($conn,"UPDATE admin SET email='".$_POST['ademail']."', 2fa='off' WHERE id='1'");
	if(!$done) {
		$alert = '<div class="alert alert-danger">'.mysqli_error($con).'</div>';
	} else {
		unlink('install.php');
		session_unset();
		header('location:./');
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>KeepLinks Installer</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="admin/dist/css/style.css">
  <link rel="stylesheet" href="admin/dist/css/components.css">
  <link rel="icon" href="assets/img/favicon.png">
</head>
<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="assets/img/logo.png" alt="logo">
            </div>
			<?php echo $alert;?>
            <div class="card card-primary"<?php if($_SESSION['step']!='start') echo ' style="display:none;"';?>>
              <div class="card-body">
				<div class="text-center">
				  <p><strong>KeepLinks - Link Protecting Script</strong> helps to prevent your links from being eventually listed on the search engines and especially the spammers by securing it with multiple security layers. Its also aims at the protection of links with some of the latest security efforts like the hCaptcha, Password Protection, etc.</p>
				  <p>The installation / upgradation process is very simple and should take less that a couple of minutes provided you follow the given instruction properly.</p>
				</div>
				<form method="post" action>
				<div class="row form-group">
				  <div class="col-6">
					<button name="install" type="submit" class="btn btn-primary btn-lg btn-block">
					  Install
                    </button>
				  </div>
				  <div class="col-6">
					<button type="submit" name="upgrade" class="btn btn-primary btn-lg btn-block">
					  Upgrade
                    </button>
				  </div>
                </div>
				</form>
              </div>
            </div>
            <div class="card card-primary"<?php if($_SESSION['step']!='installdb') echo ' style="display:none;"';?>>
              <div class="card-header">
			    <h4>Database Details</h4>
			  </div>
              <div class="card-body">
				<form method="POST" action>
                  <div class="form-group">
                    <label>Database Host</label>
                    <input type="text" class="form-control" name="dbhost" autofocus>
                  </div>
                  <div class="form-group">
                    <label>Database Name</label>
                    <input type="text" class="form-control" name="dbname">
                  </div>
				  <div class="form-group">
                    <label>Database Username</label>
                    <input type="text" class="form-control" name="dbuser">
                  </div>
                  <div class="form-group">
                    <label>Database Password</label>
                    <input type="password" class="form-control" name="dbpass">
                  </div>
				  <div class="row form-group">
                    <div class="col-6">
					  <button type="submit" name="dbsubmit" class="btn btn-primary btn-lg btn-block">
						Proceed
                      </button>
					</div>
					<div class="col-6">
					  <button type="submit" name="initial" class="btn btn-info btn-lg btn-block">
						Back
                      </button>
					</div>
                  </div>
                </form>
              </div>
            </div>
			<div class="card card-primary"<?php if($_SESSION['step']!='upgradedb') echo ' style="display:none;"';?>>
              <div class="card-header"><h4>Database Details</h4></div>
              <div class="card-body">
				<form method="POST" action>
                  <div class="form-group alert-primary text-center">
					You should use the same database that you have used during installation.
				  </div>
				  <div class="form-group">
                    <label>Database Host</label>
                    <input type="text" class="form-control" name="dbhost" autofocus>
                  </div>
                  <div class="form-group">
                    <label>Database Name</label>
                    <input type="text" class="form-control" name="dbname">
                  </div>
				  <div class="form-group">
                    <label>Database Username</label>
                    <input type="text" class="form-control" name="dbuser">
                  </div>
                  <div class="form-group">
                    <label>Database Password</label>
                    <input type="password" class="form-control" name="dbpass">
                  </div>
				  <div class="row form-group">
                    <div class="col-6">
					  <button type="submit" name="dbupgrade" class="btn btn-primary btn-lg btn-block">
						Proceed
                      </button>
					</div>
					<div class="col-6">
					  <button type="submit" name="initial" class="btn btn-info btn-lg btn-block">
						Back
                      </button>
					</div>
                  </div>
                </form>
              </div>
            </div>
			<div class="card card-primary"<?php if($_SESSION['step']!='installad') echo ' style="display:none;"';?>>
              <div class="card-header">
			    <h4>Admin Credentials</h4>
			  </div>
              <div class="card-body">
				<form method="POST" action>
                  <div class="form-group">
                    <label>Admin Username</label>
                    <input type="text" class="form-control" name="adname" autofocus>
                  </div>
                  <div class="form-group">
                    <label>Admin Password</label>
                    <input type="password" class="form-control" name="adpass">
                  </div>
				  <div class="form-group">
                    <label>Admin Email</label>
                    <input type="email" class="form-control" name="ademail">
                  </div>
                  <div class="row form-group">
                    <div class="col-6">
					  <button type="submit" name="adsubmit" class="btn btn-primary btn-lg btn-block">
						Save
                      </button>
					</div>
					<div class="col-6">
					  <button type="submit" name="install" class="btn btn-info btn-lg btn-block">
						Back
                      </button>
					</div>
                  </div>
                </form>
              </div>
            </div>
			<div class="card card-primary"<?php if($_SESSION['step']!='upgradead') echo ' style="display:none;"';?>>
              <div class="card-header"><h4>Admin Credentials</h4></div>
              <div class="card-body">
				<form method="POST" action>
                  <div class="form-group">
                    <label>Admin Username</label>
                    <input type="text" class="form-control" value="<?php include 'includes/config.php';
					$admin_data=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admin WHERE id='1'"));
					echo $admin_data['username'];?>" disabled>
                  </div>
				  <div class="form-group">
                    <label>Admin Email</label>
                    <input type="email" class="form-control" name="ademail">
                  </div>
				  <div class="row form-group">
                    <div class="col-6">
					  <button type="submit" name="adupgrade" class="btn btn-primary btn-lg btn-block">
						Save
                      </button>
					</div>
					<div class="col-6">
					  <button name="upgrade" class="btn btn-info btn-lg btn-block">
						Back
                      </button>
					</div>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; PrimeKoder 2019-20
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="admin/dist/js/stisla.js"></script>
</body>
</html>
