<script type="text/javascript">
  var session_hidden = document.getElementById('session_hidden');

  if (session_hidden.value != 1) {
    
    //window.location.href="/";
  }

</script>

<!--Include Nav-->
<?php 
  if (!isset($_SESSION['login_access'])) {
    header("Location: index.php"); 
    exit;
  }

  $path = $_SERVER['DOCUMENT_ROOT'];
  $nav = $path . "/includes/nav.php";
  include ($nav);
?>


<!--Dashboard Start-->
<div class="app-dashboard shrink-medium">
  <div class="row expanded" style="display: flex; align-items: center; justify-content: center; background: #bbccd8; height: 75px; width: 100%; flex: 0 0 55px;">
      <div class="columns small-12 medium-6" style="display: inline-flex;">
          <div><a href="#"><img src="images/school-logo.jpeg" alt="school logo" style="width: 70px; height: 75px; padding: 3px 3px 3px 3px; border-radius: 11px;  margin-right: 5px;"></a></div>
          <div>
            <h5 style="margin-top: 10px; margin-bottom: 0;">Tot To Teen School</h5>
            <p style="font-size: x-small; margin-bottom: 1px; line-height: 1.2;">P. O. Box M342, Madina, Accra<br>0302501550, 0302559922<br>tottoteen@esoftschool.com</p>
          </div>
      </div>

      <div class="columns small-12 medium-6">

      </div>
  </div>

  <div class="app-dashboard-body off-canvas-wrapper" style="color: #607D8B;">
    <div id="app-dashboard-sidebar" class="app-dashboard-sidebar position-left off-canvas off-canvas-absolute reveal-for-medium" data-off-canvas style="background: #363a41">
      <div class="app-dashboard-sidebar-title-area">
        <div class="app-dashboard-close-sidebar">
          <h6 class="app-dashboard-sidebar-block-title">v.6.1.3</h6>
          <!-- Close button -->
          <!--<button id="close-sidebar" data-app-dashboard-toggle-shrink class="app-dashboard-sidebar-close-button show-for-medium" aria-label="Close menu" type="button">
            <span aria-hidden="true"><a href="#"><i class="large fa fa-angle-double-left"></i></a></span>
          </button>-->
          <button id="close-sidebar" title="Back" onclick="window.history.back();" class="app-dashboard-sidebar-close-button show-for-medium" aria-label="Close menu" type="button">
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
        
        <ul class="multilevel-accordion-menu vertical menu" data-accordion-menu>
          <li style="padding-bottom: 8px; display: inline-flex;">
              <a class="user-img" href="#" title="User Details" style="text-align: center; margin: 0px; padding: 1px 13px;"><i class="large fa fa-address-card"></i></a>
              <ul class="menu vertical sublevel-1">
                <div class="user-info" style="text-align: center;">
                  <img src="http://placehold.it/90/c2c2c2?text=User" alt="John Doe" class="img-circle profile-img" style="border-radius: 5000px; width: 70px; text-indent: 0px; margin-right: 10px;">
                  <p class="user-name" style="text-indent: 0px; margin: 4px 0 0; line-height: 1rem;">John Doe</p>
                  <small class="info">Maths Teacher</small>
                </div>
              </ul>
              
          </li>
          <li><a href="<?php echo $SESSION->Generate_Link("dashboard", ""); ?>"><i class="dashboard small fa fa-tachometer"></i>Dashboard</a></li>
          <li>
            <a href="#"><i class="dashboard small fa fa-users"></i>Human Resources</a>
            <ul class="menu vertical sublevel-1">
              <li>
                <a href="#">Student Activities</a>
                <ul class="menu vertical sublevel-2">
                  <li><a class="subitem" href="#">Absenteeism</a></li>
                  <li><a class="subitem" href="#">Dicipline</a></li>
                  <li><a class="subitem" href="#">Illness</a></li>
                </ul>
              </li>
              <li>
                <a href="#">Students</a>
                <ul class="menu vertical sublevel-2">
                  <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("student_edit", "page_aktion=student_new"); ?>">Add Student</a></li>
                  <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("student_overview", "page_aktion=show"); ?>">Manage Student</a></li>
                </ul>
              </li>
              <li>
                <a href="#">Parents</a>
                <ul class="menu vertical sublevel-2">
                  <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("parent_edit", "page_aktion=parent_new"); ?>">Add Parent</a></li>
                  <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("parent_overview", "page_aktion=show"); ?>">Manage Parent</a></li>
                </ul>
              </li>
              <li>
                <a href="#">Staff</a>
                <ul class="menu vertical sublevel-2">
                  <li><a class="subitem" href="#">Add Staff</a></li>
                  <li><a class="subitem" href="#">Manage Staff</a></li>
                </ul>
              </li>
              <li><a class="subitem" href="#">Email Documents</a></li>
              <li>
                <a href="#">SMS</a>
                <ul class="menu vertical sublevel-2">
                  <li><a class="subitem" href="#">Send SMS</a></li>
                  <li><a class="subitem" href="#">SMS Status</a></li>
                </ul>
              </li>  
            </ul>
          </li>
          <li>
            <a href="#"><i class="dashboard small fa fa-graduation-cap"></i>Academics</a>
            <ul class="menu vertical sublevel-1">
              <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("assign_student_subjects", "page_aktion=show"); ?>">Multi-Term Test</a></li>
              <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("student_subjects_results", "page_aktion=show"); ?>">Test/Exam Score</a></li>
              <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("assign_student_subjects", "page_aktion=show"); ?>">PG. Assessment</a></li>
              <hr style="margin: 0; border-bottom: 1px solid #404040;">
              <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("assign_student_subjects", "page_aktion=show"); ?>">Assign Subjects</a></li>
              <hr style="margin: 0; border-bottom: 1px solid #404040;">
              <li>
                <a href="#">Subjects Management</a>
                <ul class="menu vertical sublevel-2">
                  <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("subjects_edit", "page_aktion=subject_new"); ?>">Add Subject</a></li>
                  <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("subjects_overview", "page_aktion=show"); ?>">Subjects Overview</a></li>
                  <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("subjectset_overview", "page_aktion=show"); ?>">Subject Sets</a></li>
                  <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("subjectgradeset_overview", "page_aktion=show"); ?>">Subject Grading</a></li>
                  <li><a class="subitem" href="#">Results Assessment</a></li>
                </ul>
              </li>
              <li>
                <a href="#">Play Group Topics</a>
                <ul class="menu vertical sublevel-2">
                  <li><a class="subitem" href="<?php echo $SESSION->Generate_Link("pg_topic_group_overview", "page_aktion=show"); ?>">Topics Set</a></li>
                </ul>
              </li>
              <li><a class="subitem" href="#">Promotion/Demotion</a></li>
            </ul>
          </li>
          <li>
            <a href="#"><i class="dashboard small fa fa-file-text"></i>Inventory</a>
            <ul class="menu vertical sublevel-1">
              <li><a class="subitem" href="#">Thing 1</a></li>
              <li><a class="subitem" href="#">Thing 2</a></li>
            </ul>
          </li>
          <li>
            <a href="#"><i class="dashboard small fa fa-money"></i>Financials</a>
            <ul class="menu vertical sublevel-1">
              <li>
                <a href="#">Sub-item 3</a>
                <ul class="menu vertical sublevel-2">
                  <li><a class="subitem" href="#">Thing 1</a></li>
                  <li><a class="subitem" href="#">Thing 2</a></li>
                </ul>
              </li>
              <li><a class="subitem" href="#">Thing 1</a></li>
              <li><a class="subitem" href="#">Thing 2</a></li>
            </ul>
          </li>
          <li>
            <a href="#"><i class="dashboard small fa fa-industry"></i>Donations</a>
            <ul class="menu vertical sublevel-1">
              <li><a class="subitem" href="#">Thing 1</a></li>
              <li><a class="subitem" href="#">Thing 2</a></li>
            </ul>
          </li>
          <li>
            <a href="#"><i class="dashboard small fa fa-file"></i>Reports</a>
            <ul class="menu vertical sublevel-1">
              <li><a class="subitem" href="#">Thing 1</a></li>
              <li><a class="subitem" href="#">Thing 2</a></li>
            </ul>
          </li>
          <li>
            <a href="#"><i class="dashboard small fa fa-cogs"></i>System</a>
            <ul class="menu vertical sublevel-1">
              <li><a class="subitem" href="#">Thing 1</a></li>
              <li><a class="subitem" href="#">Thing 2</a></li>
            </ul>
          </li>
          <li>
            <a href="#"><i class="dashboard small fa fa-cubes"></i>Getting Started</a>
            <ul class="menu vertical sublevel-1">
              <li><a class="subitem" href="#">Thing 1</a></li>
              <li><a class="subitem" href="#">Thing 2</a></li>
            </ul>
          </li>
        </ul>


      </div>
    </div>

    <div class="app-dashboard-body-content off-canvas-content" data-off-canvas-content>
      