<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
	
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
	  
      <!-- Brand -->
      <a class="navbar-brand" href="./index.php">
        <img src="assets/img/logo.png" class="navbar-brand-img" alt="<?php echo $settings['site_name'];?> Logo">
      </a>
	  
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle"><i class="fas fa-user"></i></span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href="profile.php" class="dropdown-item">
              <i class="fas fa-user"></i><span>My profile</span>
            </a>
			<a href="index.php" class="dropdown-item">
              <i class="fas fa-home"></i><span>Home Page</span>
            </a>
			<a href="logout.php" class="dropdown-item">
              <i class="fas fa-sign-out-alt"></i><span>Logout</span>
            </a>
          </div>
        </li>
      </ul>
	  
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
	  
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="index.php">
                <img src="assets/img/logo.png"  alt="<?php echo $settings['site_name'];?> Logo">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
				<i class="fas fa-plus"></i>
			  </button>
            </div>
          </div>
        </div>
		
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='dashboard.php'){echo' active';}?>" href="dashboard.php">
              <i class="fas fa-tv"></i> Dashboard
            </a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fas fa-plus"></i> New Link
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='password.php'){echo' active';}?>" href="password.php">
              <i class="fas fa-lock"></i> Change Password
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='links.php'){echo' active';}?>" href="links.php">
              <i class="fas fa-link"></i> Manage Links
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='profile.php'){echo' active';}?>" href="profile.php">
              <i class="fas fa-user"></i> View Profile
            </a>
          </li>
        </ul>
		
        <!-- Divider -->
        <hr class="my-3">
		
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fas fa-home"></i> Home Page
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- Main content -->
  <div class="main-content">
  
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
	  
        <!-- Brand -->
        <h3 style="color:white;">User Dashboard</h3>
		
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <i class="fas fa-user"></i>
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold"><?php echo $logged_user['name'];?></span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome!</h6>
              </div>
              <a href="profile.php" class="dropdown-item">
                <i class="fas fa-user"></i><span>My profile</span>
              </a>
			  <a href="index.php" class="dropdown-item">
                <i class="fas fa-home"></i><span>Home Page</span>
              </a>
              <a href="logout.php" class="dropdown-item">
                <i class="fas fa-sign-out-alt"></i><span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>