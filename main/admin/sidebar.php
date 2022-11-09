<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="../index.php"><?php echo $settings['site_name']?></a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="../index.php"><i class="fas fa-link"></i></a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Admin Panel</li>
			<li<?php if(basename($_SERVER['PHP_SELF'])=='dashboard.php'){echo' class=active';}?>><a class="nav-link" href="dashboard.php"><i class="fas fa-tv"></i> <span>Dashboard</span></a></li>
			<li<?php if(basename($_SERVER['PHP_SELF'])=='users.php'){echo' class=active';}?>><a class="nav-link" href="users.php"><i class="fas fa-user"></i> <span>All Users</span></a></li>
			<li<?php if(basename($_SERVER['PHP_SELF'])=='links.php'){echo' class=active';}?>><a class="nav-link" href="links.php"><i class="fas fa-link"></i> <span>Manage Links</span></a></li>
			<li<?php if(basename($_SERVER['PHP_SELF'])=='transactions.php'){echo' class=active';}?>><a class="nav-link" href="transactions.php"><i class="fas fa-comments-dollar"></i>  <span>Withdraw Requests</span></a></li>
			<li<?php if(basename($_SERVER['PHP_SELF'])=='setting.php'){echo' class=active';}?>><a class="nav-link" href="setting.php"><i class="fas fa-cog"></i> <span>Site Settings</span></a></li>
			<li<?php if(basename($_SERVER['PHP_SELF'])=='paymethods.php'){echo' class=active';}?>><a class="nav-link" href="paymethods.php"><i class="fas fa-hand-holding-usd"></i> <span>Payment Methods</span></a></li>
			<li<?php if(basename($_SERVER['PHP_SELF'])=='ads.php'){echo' class=active';}?>><a class="nav-link" href="ads.php"><i class="fas fa-money-check-alt"></i> <span>Advertisements</span></a></li>
			<li<?php if(basename($_SERVER['PHP_SELF'])=='adminsetting.php'){echo' class=active';}?>><a class="nav-link" href="adminsetting.php"><i class="fas fa-star"></i> <span>Admin Settings</span></a></li>
		  </ul>
          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="logout.php" class="btn btn-primary btn-lg btn-block btn-icon-split">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </div>
		</aside>
      </div>