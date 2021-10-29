<?php 
include('../../includes/functions.php');

if(!isLoggedIn()) {
  header('Location: ../../login.php');
}

$userInfo = $_SESSION['user'];
$user_id = $userInfo['id']; // Get id
$fullname = $userInfo['fullname']; // Get fullname
$userInfo['photo']; // Get photo

try {
  // Create sql statement
  $query = "SELECT * FROM users WHERE id='$user_id'";
  $result = mysqli_query($db, $query);
} catch (Exception $e) {
  echo "Error " . $e->getMessage();
  exit();
}

try {
  $query2 = "SELECT * FROM attendance";
  $result2 = mysqli_query($db, $query2);
} catch (Exception $e) {
  echo "Error " . $e->getMessage();
  exit();
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AMS | Attendance DataTable</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../home.php" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown user-menu">
      <?php while ($user = mysqli_fetch_array($result)) : ?>
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="data:image/jpeg;base64, <?= base64_encode($user['photo']);?>" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"><?= $user['fullname'];?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="data:image/jpeg;base64, <?= base64_encode($user['photo']);?>" class="img-circle elevation-2" alt="User Image">

            <p>
              <?= $user['fullname'];?>
              <small>Member since [<?= $user['created_on'];?>]</small>
            </p>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
            <a href="../../logout.php" class="btn btn-default btn-flat float-right">Sign out</a>
          </li>
        </ul>
      <?php endwhile ?>  
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../home.php" class="brand-link">
      <img src="../../dist/img/download.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="data:image/jpeg;base64, <?= base64_encode($userInfo['photo']);?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $userInfo['fullname']; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../../home.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">MANAGE</li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Attendance
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DataTable</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTable</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Attendance of Employees</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Date</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $query3 = "SELECT * FROM attendance, employees, schedule WHERE attendance.emp_id = employees.employee_id AND employees.schedule_id = schedule.schedule_id";
                  $result3 = mysqli_query($db, $query3);
                  while ($row = mysqli_fetch_array($result3)) {
                    if ($row['time_in'] <= $row['schedule_in']) {
                  ?>
                  <tr>
                    <td><?php echo $row['attendance_date']; ?></td>
                    <td><?php echo $row['emp_id']; ?></td>
                    <td><?php echo $row['employee_name']; ?></td>
                    <td><?php $timein = $row['time_in']; 
                              echo date('h:i A', strtotime($timein));?><span class="float-right badge bg-danger">On Time</span></td>
                    <td><?php $timeout = $row['time_out']; 
                              echo date('h:i A', strtotime($timeout));?></td>
                  </tr>
                  <?php
                    } else {
                  ?>
                  <tr>
                    <td><?php echo $row['attendance_date']; ?></td>
                    <td><?php echo $row['emp_id']; ?></td>
                    <td><?php echo $row['employee_name']; ?></td>
                    <td><?php $timein = $row['time_in']; 
                              echo date('h:i A', strtotime($timein));?><span class="float-right badge bg-danger">Late</span></td>
                    <td><?php $timeout = $row['time_out']; 
                              echo date('h:i A', strtotime($timeout));  ?></td>
                  </tr>
                  <?php
                    }
                  }
                  ?>
                  
          
                  <tfoot>
                    <tr>
                      <th>Date</th>
                      <th>Employee ID</th>
                      <th>Name</th>
                      <th>Time In</th>
                      <th>Time Out</th>
                    </tr>
                    </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      
    </div>
    <strong>Copyright &copy; 2021 <a href="#">CodeCoffee</a>.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
