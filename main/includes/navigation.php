	<nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
      <div class="container px-4">
        <a href="<?php echo $site_url;?>index.php">
          <img width="200" src="<?php echo $site_url;?>assets/img/logo.png" alt="Site Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-collapse-main">
		
          <!-- Collapse header -->
          <div class="navbar-collapse-header d-md-none">
            <div class="row">
              <div class="col-6 collapse-brand">
                <a href="<?php echo $site_url;?>index.php">
                  <img src="<?php echo $site_url;?>assets/img/logo.png" alt="Site Logo">
                </a>
              </div>
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>
		  
          <!-- Navbar items -->
          <ul class="navbar-nav ml-auto">
		    <?php if($_SESSION['user_id']) { ?>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="<?php echo $site_url;?>dashboard.php">
                <i class="fas fa-tv"></i>
                <span class="nav-link-inner--text">Dashboard</span>
              </a>
            </li>
			<li class="nav-item">
              <a class="nav-link nav-link-icon" href="<?php echo $site_url;?>profile.php">
                <i class="fas fa-user"></i>
                <span class="nav-link-inner--text">Profile</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="<?php echo $site_url;?>links.php">
                <i class="fas fa-link"></i>
                <span class="nav-link-inner--text">Manage Links</span>
              </a>
            </li>            
			<li class="nav-item">
              <a class="nav-link nav-link-icon" href="<?php echo $site_url;?>logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-link-inner--text">logout</span>
              </a>
            </li>
			<?php } else { ?>
			<li class="nav-item">
              <a class="nav-link nav-link-icon" href="<?php echo $site_url;?>earn.php">
                <i class="fas fa-money-check"></i>
                <span class="nav-link-inner--text">Earn Money</span>
              </a>
            </li>
			<li class="nav-item">
              <a class="nav-link nav-link-icon" href="<?php echo $site_url;?>login.php">
                <i class="fas fa-sign-in-alt"></i>
                <span class="nav-link-inner--text">Login</span>
              </a>
            </li>
			<li class="nav-item">
              <a class="nav-link nav-link-icon" href="<?php echo $site_url;?>register.php">
                <i class="fas fa-address-book"></i>
                <span class="nav-link-inner--text">Register</span>
              </a>
            </li>
			<?php } ?>
          </ul>
        </div>
      </div>
    </nav>