<!--Include Header-->
<?php  
  $path = $_SERVER['DOCUMENT_ROOT'] ;
  $path .= "/includes/header.php";
  include ($path);
  include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-header.php");
?>

  <main>
    <!--Integrate DataTables-->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/main_dashboard.css">

    <section class="glass">
      <div class="dashboard">
        <div class="user">
          <img src="http://training.derrickbasoah.com/glass-design/images/avatar.png" alt="" />
          <h3>Derrick Basoah</h3>
          <p>Admin Member</p>
        </div>
        <div class="links">
          <div class="link">
            <img src="http://training.derrickbasoah.com/glass-design/images/twitch.png" alt="" />
            <h2>Streams</h2>
          </div>
          <div class="link">
            <img src="http://training.derrickbasoah.com/glass-design/images/steam.png" alt="" />
            <h2>Games</h2>
          </div>
          <div class="link">
            <img src="http://training.derrickbasoah.com/glass-design/images/upcoming.png" alt="" />
            <h2>New</h2>
          </div>
          <div class="link">
            <img src="http://training.derrickbasoah.com/glass-design/images/library.png" alt="" />
            <h2>Library</h2>
          </div>
        </div>
        <div class="pro">
          <h2>Join pro for free games.</h2>
          <img src="http://training.derrickbasoah.com/glass-design/images/controller.png" alt="" />
        </div>
      </div>

      <div class="games">
        <div class="status">
          <h1>Dashboard</h1>
          <input type="text" />
        </div>
        <div class="cards">
          <div class="card">
            <?php                      
              $dbconn = DB_Connect_Direct();
              $query = "SELECT id from student;";
              $result = DB_Query($dbconn, $query);
              if ($result != false) {
                $totalstudents=DB_NumRows($result);
              }
              DB_FreeResult($result);
            ?>
            <img src="http://training.derrickbasoah.com/glass-design/images/assassins.png" alt="" />
            <div class="card-info">
              <h2>Registered Students</h2>
              <p>PS5 Version</p>
              <div class="progress"></div>
            </div>
            <h2 class="percentage"><?php echo htmlentities(number_format($totalstudents));?></h2>
          </div>

          <div class="card">
            <?php 
              $dbconn = DB_Connect_Direct();
              $query = "SELECT * from  subjects;";
              $result = DB_Query($dbconn, $query);
              if ($result != false) {
                $totalsubjects=DB_NumRows($result);
              }
              DB_FreeResult($result);
            ?>
            <img src="http://training.derrickbasoah.com/glass-design/images/sackboy.png" alt="" />
            <div class="card-info">
              <h2>Subject/Course List</h2>
              <p>PS5 Version</p>
              <div class="progress"></div>
            </div>
            <h2 class="percentage"><?php echo htmlentities($totalsubjects);?></h2>
          </div>

          <div class="card">
            <?php 
              $dbconn = DB_Connect_Direct();
              $query = "SELECT * from  grade;";
              $result = DB_Query($dbconn, $query);
              if ($result != false) {
                $totalclasses=DB_NumRows($result);
              }
              DB_FreeResult($result);
            ?>
            <img src="http://training.derrickbasoah.com/glass-design/images/spiderman.png" alt="" />
            <div class="card-info">
              <h2>Total Classes listed</h2>
              <p>PS5 Version</p>
              <div class="progress"></div>
            </div>
            <h2 class="percentage"><?php echo htmlentities($totalclasses);?></h2>
          </div>

          <div class="card">
            <?php 
              /*$dbconn = DB_Connect_Direct();
              $query = "SELECT  distinct StudentId from  tblresult;";
              $result = DB_Query($dbconn, $query);
              if ($result != false) {
                $totalresults=DB_NumRows($result);
              }
              DB_FreeResult($result);*/
            ?>
            <img src="http://training.derrickbasoah.com/glass-design/images/spiderman.png" alt="" />
            <div class="card-info">
              <h2>Results Declared</h2>
              <p>PS5 Version</p>
              <div class="progress"></div>
            </div>
            <h2 class="percentage">60%</h2>
          </div>
        </div>
      </div>
    </section>
  </main>




    <div class="main-page" style="min-height: 660px;">
        <div class="row">
            <div class="small-12 medium-6 large-6 columns">
                <div id="chart-container" style="padding: 15px 0;">
                    <canvas id="RegStudentGraph" style="position: relative; height:40vh; width:40vw" ></canvas>
                </div>              
            </div>
            <div class="small-12 medium-6 large-6 columns">
                <div id="chart-container" style="padding: 15px 0;">
                    <canvas id="StudentSubjectsGraph" style="position: relative; height:40vh; width:40vw" ></canvas>
                </div>              
            </div>
            <div class="small-12 medium-6 large-6 columns">
                <div id="chart-container" style="padding: 15px 0;">
                    <canvas id="StudentClassGraph" style="position: relative; height:40vh; width:40vw" ></canvas>
                </div>              
            </div>
        </div>
    </div>
     <!--/.main-page -->





<!--Include Footer-->
  <?php 

    $path = $_SERVER['DOCUMENT_ROOT'] ;
    $path .= "/includes/footer.php";
    include ($path);
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/app-dashboard-footer.php");
  ?>

  <script type="text/javascript">
  
  //Chart Script
  $(document).ready(function () {
      showRegStudentGraph();
      showStudentSubjectsGraph();
      StudentClassGraph();
  });


  function showRegStudentGraph()
  {
      {
          $.post("/includes/reg_student_data.php",
          function (data)
          {
              console.log(data);
               var name = [];
              var marks = [];

              for (var i in data) {
                  name.push(data[i].desc);
                  marks.push(data[i].CNT);
              }

              var chartdata = {
                  labels: name,
                  datasets: [
                      {
                          label: 'Registered Students',
                          backgroundColor: '#5da423',
                          borderColor: '#46d5f1',
                          hoverBackgroundColor: '#CCCCCC',
                          hoverBorderColor: '#666666',
                          data: marks,

                          /*barPercentage: 0.5,
                          barThickness: 30,
                          maxBarThickness: 30,
                          minBarLength: 2*/
                      }
                  ]
              };

              var graphTarget = $("#RegStudentGraph");

              var barGraph = new Chart(graphTarget, {
                  type: 'bar',
                  data: chartdata
              });
          });
      }
  }


  function showStudentSubjectsGraph()
  {
      {
          $.post("/includes/student_subjects_data.php",
          function (data)
          {
              console.log(data);
               var name = [];
              var marks = [];
              var desc = [];

              for (var i in data) {
                  name.push(data[i].subjectcode);
                  marks.push(data[i].CNT);
                  desc.push(data[i].description);
              }

              var chartdata = {
                  labels: name,
                  datasets: [
                      {
                          label: 'Students/Registered Subjects',
                          backgroundColor: '#1779ba',
                          borderColor: '#46d5f1',
                          hoverBackgroundColor: '#CCCCCC',
                          hoverBorderColor: '#666666',
                          data: marks

                          /*barPercentage: 0.5,
                          barThickness: 30,
                          maxBarThickness: 30,
                          minBarLength: 2*/
                      }
                  ]
              };

              var graphTarget = $("#StudentSubjectsGraph");

              var barGraph = new Chart(graphTarget, {
                  type: 'bar',
                  data: chartdata
              });
          });
      }
  }

  function StudentClassGraph()
  {
      {
          $.post("/includes/student_class_data.php",
          function (data)
          {
              console.log(data);
               var name = [];
              var marks = [];
              var desc = [];

              for (var i in data) {
                  name.push(data[i].Name);
                  marks.push(data[i].CNT);
                  desc.push(data[i].grade);
              }

              var chartdata = {
                  labels: name,
                  datasets: [
                      {
                          label: 'Students/Registered Classes',
                          backgroundColor: 'blueviolet',
                          borderColor: '#46d5f1',
                          hoverBackgroundColor: '#CCCCCC',
                          hoverBorderColor: '#666666',
                          data: marks

                          /*barPercentage: 0.5,
                          barThickness: 30,
                          maxBarThickness: 30,
                          minBarLength: 2*/
                      }
                  ]
              };

              var graphTarget = $("#StudentClassGraph");

              var barGraph = new Chart(graphTarget, {
                  type: 'bar',
                  data: chartdata
              });
          });
      }
  }
   //End Chart Script

</script>