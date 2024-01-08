
<!--Include Navigation | Menu--> 

<div class="app-dashboard shrink-medium" style="display: block;">
  <div class="row expanded app-dashboard-top-nav-bar">
    <div class="columns medium-2">
      <button data-toggle="app-dashboard-sidebar" class="menu-icon hide-for-medium"></button>
      <a class="app-dashboard-logo" href="<?php echo $SESSION->Generate_Link("index", ""); ?>">eComCentral</a>
    </div>
    <div class="columns show-for-medium">
      <div class="app-dashboard-search-bar-container">
        <input class="app-dashboard-search" type="search" placeholder="Search">
        <i class="app-dashboard-search-icon fa fa-search"></i>
      </div>
    </div>

    <div class="columns">
      <ul class="menu simple vertical medium-horizontal">
        <li><a style="color: aliceblue;" href="<?php echo $SESSION->Generate_Link("features", ""); ?>">Features</a></li>
        <li><a style="color: aliceblue;" href="/index.php#benefits">Benefits</a></li>
        <li><a style="color: aliceblue;" href="/index.php#services">Services</a></li>
        <li><a style="color: aliceblue;" href="#">Support</a></li>
        <li><a style="color: aliceblue;" href="<?php echo $SESSION->Generate_Link("about", ""); ?>">About Us</a></li>
      </ul>
    </div>

    <div class="columns shrink app-dashboard-top-bar-actions">
      <?php  
        echo  '<a class="button hollow topbar-responsive-button" name="btn_login" id="btn_login" data-open="LoginModal" style="margin: 0 5px;">Login</a>';  
        echo  '<a class="button warning hollow topbar-responsive-button" id="btn_logout" type="button" data-toggle="user_administration_dropdown" style="margin: 0 5px;">Derrick Basoah</a>';
        echo  '<a href="' . $SESSION->Generate_Link("#", "") . '"  title="Info...!!!" style="font-size: x-large;"><i class="fa fa-info-circle"></i></a>';
      ?>
      
      <div class="dropdown-pane" id="user_administration_dropdown" data-dropdown style="background-color: #2c3840; border: 1px solid rgb(255, 174, 0);">
        <div>
          <ul class="vertical menu" data-accordion-menu>
            <li><a href='#0'>Profile</a></li>
            <li><a href='#0'>Settings</a></li>
            <li>
              <a href='#0'>Administration <i class="far fa-caret-square-down"></i></a>
              <ul class="menu vertical" style="margin-left: 20px;">
                <li><a href='<?php echo $SESSION->Generate_Link("users_overview", ""); ?>'>Users</a></li>
                <li><a href='<?php echo $SESSION->Generate_Link("shop_systems_overview", ""); ?>'>Shop Systems</a></li>
                <li><a href='#0'>Customers</a></li>
                <li><a href='#0'>Contacts</a></li>
              </ul>
            </li>
            <li><a href='#0'>Help Center</a></li>
            <li><a style="color: #ffa600;" href='<?php echo $SESSION->Generate_Link("index", "aktion=logout"); ?>'>Logout</a></li>
          </ul>
        </div>
      </div>

    </div>

    <div class="tiny reveal" id="LoginModal" data-close-on-click="false" data-reveal style="padding: 0; border: 0; border-radius: 10px;">
      <form action="<?php echo $SESSION->Generate_Link("index", ""); ?>" id="form_login_access" name="form_login_access" method="POST">
        <div class="sign-in-form">
          <h4 class="text-center">Login</h4>
          <label for="sign-in-form-username">Username</label>
          <input type="text" class="sign-in-form-username" id="text_username" name="text_username">
          <label for="sign-in-form-password">Password</label>
          <input type="password" class="sign-in-form-password" id="text_password" name="text_password">
          <button type="submit" class="sign-in-form-button">Login</button>
          <p style="font-size: small; margin: 0; text-align: center;"><a href="<?php echo $SESSION->Generate_Link("#", ""); ?>">Forgot username/password? </a></p>
          <input name="aktion" type="hidden" id="aktion" value="login" />
        </div>
      </form>

      <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>

      <?php
        /*if (isset($_SESSION['error_type'])) {
          if ($_SESSION['error_type'] == 'login_success') {
            echo $UTIL->Print_Notification ('System Login successful!', 'success');
          } elseif ($_SESSION['error_type'] == 'login_error') {
            echo $UTIL->Print_Notification ('Login Failed. Check Username and Password', 'alert');
          } elseif ($_SESSION['error_type'] == 'logout_success') {
            echo $UTIL->Print_Notification ('Logout successful!', 'primary');
          } elseif ($_SESSION['error_type'] == 'school_code_success') {
            echo $UTIL->Print_Notification ('School access successful!', 'primary');
          } elseif ($_SESSION['error_type'] == 'school_code_error') {
            echo $UTIL->Print_Notification ('Invalid School Code. Please inform your supervisor!', 'alert');
          }
        } */
      ?>
    </div>

  </div>

  <div class="app-dashboard-body off-canvas-wrapper">
    <div id="app-dashboard-sidebar" class="app-dashboard-sidebar position-left off-canvas off-canvas-absolute reveal-for-medium" data-off-canvas>
      <div class="app-dashboard-sidebar-title-area">
        <div class="app-dashboard-close-sidebar">
          <h4 class="app-dashboard-sidebar-block-title">Menu</h4>
          <!-- Close button -->
          <button id="close-sidebar" data-app-dashboard-toggle-shrink class="app-dashboard-sidebar-close-button show-for-medium" aria-label="Close menu" type="button">
            <span aria-hidden="true"><a href="#"><i class="large fa fa-angle-double-left"></i></a></span>
          </button>
        </div>
        <div class="app-dashboard-open-sidebar">
          <button id="open-sidebar" data-app-dashboard-toggle-shrink class="app-dashboard-open-sidebar-button show-for-medium" aria-label="open menu" type="button">
            <span aria-hidden="true"><a href="#"><i class="large fa fa-angle-double-right"></i></a></span>
          </button>
        </div>
      </div>
      <div class="app-dashboard-sidebar-inner">
        <ul class="menu vertical">
          <li><a href="<?php echo $SESSION->Generate_Link("shopify_overview", ""); ?>" class="is-active">
            <i class="large fab fa-shopify"></i><span class="app-dashboard-sidebar-text">Shopify</span>
          </a></li>
          <li><a>
            <i class="large fas fa-store-alt"></i><span class="app-dashboard-sidebar-text">WooCommerce</span>
          </a></li>
          <li><a>
            <i class="large fab fa-amazon"></i><span class="app-dashboard-sidebar-text">Amazon</span>
          </a></li>
          <li><a href="#" class="is-active">
            <i class="large fab fa-ebay"></i><span class="app-dashboard-sidebar-text">eBay</span>
          </a></li>
          <li><a>
            <i class="large fa fa-hourglass"></i><span class="app-dashboard-sidebar-text">Time</span>
          </a></li>
          <li><a>
            <i class="large fa fa-industry"></i><span class="app-dashboard-sidebar-text">Industry</span>
          </a></li>
          <li><a href="#" class="is-active">
            <i class="large fa fa-institution"></i><span class="app-dashboard-sidebar-text">Buildings</span>
          </a></li>
          <li><a>
            <i class="large fa fa-hourglass"></i><span class="app-dashboard-sidebar-text">Time</span>
          </a></li>
          <li><a href="<?php echo $SESSION->Generate_Link("integration", ""); ?>">
            <i class="large fas fa-link"></i><span class="app-dashboard-sidebar-text">Integration</span>
          </a></li>
        </ul>
      </div>
    </div>

    <div class="app-dashboard-body-content off-canvas-content" style="min-height: 70vh;" data-off-canvas-content>

    <!-- Page body comes and followed by the nav_footer.php-->
  

