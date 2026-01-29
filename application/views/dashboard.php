<html lang="en">
  
  <?php include("AdminMeta.php");?>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader">    
        <div class="loader-p"></div>
      </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start       -->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
     <?php include("AdminHeader.php");?>
      <!-- Page Header Ends                              -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
        <?php include("AdminSidebar.php");?>
        
         <?php 	 $abc= $this->session->flashdata('responce_message');
              if(is_array($abc) && count($abc)>0){
                    echo show_notish($abc['status'],$abc['msg']);
              }
              ?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <!-- Container-fluid starts-->
           
<div class="row mb-3">
  <div class="col-sm-12 text-center">
    <h3>Paper Setting Dashboard</h3>
  </div>
</div>
<div class="row mb-4">

  <!-- Donut Chart -->
  <div class="col-xl-6 col-md-6">
    <div class="card h-100">
      <div class="card-header">
        <h6>Paper Status Overview</h6>
      </div>
      <div class="card-body text-center">
        <canvas id="paperStatusChart" height="260"></canvas>
      </div>
    </div>
  </div>

  <!-- Line Chart -->
  <div class="col-xl-6 col-md-6">
    <div class="card h-100">
      <div class="card-header">
        <h6>Overall Master Data</h6>
      </div>
      <div class="card-body">
        <canvas id="overallLineChart" height="200"></canvas>
      </div>
    </div>
  </div>

</div>



          <div class="row">

  <!-- Subject -->
 <div class="col-xl-4 col-md-6">
  <div class="card">
    <div class="card-header">
      <h5>Subjects</h5>
    </div>
    <div class="card-body">
      
      <ul class="list-group">

        <!-- Heading row -->
        <li class="list-group-item d-flex fw-bold">
          <div class="col-8 p-0">Subject Name</div>
          <div class="col-4 text-end p-0">Subject Code</div>
        </li>

        <!-- Data rows -->
        <?php foreach($last_subjects as $sub){ ?>
          <li class="list-group-item d-flex">
            <div class="col-8 p-0"><?= $sub['SubjectName']; ?></div>
            <div class="col-4 text-end p-0"><?= $sub['SubjectCode']; ?></div>
          </li>
        <?php } ?>

      </ul>

      <div class="text-end mt-2">
        <a href="<?= base_url('Admin_user/Subject'); ?>" class="btn btn-primary btn-sm">
          View More
        </a>
      </div>

    </div>
  </div>
</div>




  <!-- Department -->
  <div class="col-xl-4 col-md-6">
  <div class="card">
    <div class="card-header">
      <h5>Departments</h5>
    </div>
    <div class="card-body">

      <ul class="list-group">

        <!-- Heading row -->
        <li class="list-group-item d-flex fw-bold">
          <div class="col-8 p-0">Department Name</div>
          <div class="col-4 text-end p-0">Dep. Code</div>
        </li>

        <!-- Data rows -->
        <?php foreach($last_departments as $dept){ ?>
          <li class="list-group-item d-flex">
            <div class="col-8 p-0"><?= $dept['Name']; ?></div>
            <div class="col-4 text-end p-0"><?= $dept['DepartmentCode']; ?></div>
          </li>
        <?php } ?>

      </ul>

      <div class="text-end mt-2">
        <a href="<?= base_url('Admin_user/Department'); ?>" class="btn btn-primary btn-sm">
          View More
        </a>
      </div>

    </div>
  </div>
</div>


  <!-- Programme -->
  <div class="col-xl-4 col-md-6">
  <div class="card">
    <div class="card-header">
      <h5>Programmes</h5>
    </div>
    <div class="card-body">

      <ul class="list-group">

        <!-- Heading row -->
        <li class="list-group-item d-flex fw-bold">
          <div class="col-8 p-0">Programme Name</div>
          <div class="col-4 text-end p-0">Prog. Code</div>
        </li>

        <!-- Data rows -->
        <?php foreach($last_programmes as $prog){ ?>
          <li class="list-group-item d-flex">
            <div class="col-8 p-0"><?= $prog['ProgrammeName']; ?></div>
            <div class="col-4 text-end p-0"><?= $prog['ProgrammeCode']; ?></div>
          </li>
        <?php } ?>

      </ul>

      <div class="text-end mt-2">
        <a href="<?= base_url('Admin_user/Programme'); ?>" class="btn btn-primary btn-sm">
          View More
        </a>
      </div>

    </div>
  </div>
</div>


  <!-- Paper Format -->
 <div class="col-xl-6 col-md-6">
  <div class="card">
    <div class="card-header">
      <h5>Paper Formats</h5>
    </div>
    <div class="card-body">

      <ul class="list-group">

        <!-- Heading row -->
        <li class="list-group-item d-flex fw-bold">
          <div class="col-6 p-0">Format Number</div>
          <div class="col-6 text-end p-0">Total Questions</div>
        </li>

        <!-- Data rows -->
        <?php foreach($last_formats as $fmt){ ?>
          <li class="list-group-item d-flex">
            <div class="col-6 p-0"><?= $fmt['FormatNumber']; ?></div>
            <div class="col-6 text-end p-0"><?= $fmt['TotalQuestions']; ?></div>
          </li>
        <?php } ?>

      </ul>

      <div class="text-end mt-2">
        <a href="<?= base_url('/Admin_user/PaperFormat'); ?>" class="btn btn-primary btn-sm">
          View More
        </a>
      </div>

    </div>
  </div>
</div>


  <!-- Faculty -->
  <div class="col-xl-6 col-md-6">
  <div class="card">
    <div class="card-header">
      <h5>Faculty</h5>
    </div>
    <div class="card-body">

      <ul class="list-group">

        <!-- Heading row -->
        <li class="list-group-item d-flex fw-bold">
          <div class="col-6 p-0">Name</div>
          <div class="col-6 text-end p-0">Email</div>
        </li>

        <!-- Data rows -->
        <?php foreach($last_faculty as $fac){ ?>
          <li class="list-group-item d-flex">
            <div class="col-6 p-0"><?= $fac['Name']; ?></div>
            <div class="col-6 text-end p-0"><?= $fac['Email']; ?></div>
          </li>
        <?php } ?>

      </ul>

      <div class="text-end mt-2">
        <a href="<?= base_url('Admin_user/Faculty'); ?>" class="btn btn-primary btn-sm">
          View More
        </a>
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
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
       <?php include("AdminFooter.php");?>
      </div>
    </div>
    <!-- latest jquery-->
    <!-- login js-->
    <!-- Plugin used-->
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('paperStatusChart').getContext('2d');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Assigned', 'Approved', 'Rejected'],
        datasets: [{
            data: [
                <?= $assign ?>,
                <?= $approve ?>,
                <?= $reject ?>
            ],
            backgroundColor: [
                '#7366ff', // Assigned
                '#54ba4a', // Approved
                '#fc4438'  // Rejected
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

const lineCtx = document.getElementById('overallLineChart').getContext('2d');

new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: [
            'Faculty',
            'Subjects',
            'Programmes',
            'Departments',
            'Paper Formats'
        ],
        datasets: [{
            label: 'Total Count',
            data: [
                <?= $count_faculty ?>,
                <?= $count_subjects ?>,
                <?= $count_programmes ?>,
                <?= $count_departments ?>,
                <?= $count_formats ?>
            ],
            borderWidth: 2,
            tension: 0.4,
            pointRadius: 5,
            fill: false
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>

  </body>
</html>