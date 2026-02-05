<?php
include 'connection.php';
session_start();
$email=$_SESSION['email'];

$result=mysqli_query($con,"select * from tutor where email='$email'");
$user=mysqli_fetch_array($result);
$_SESSION['TID'] = $user['TID'];
$TID=$_SESSION['TID'];
$sql = "CALL GetTutorSimpleTotals(?)";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $TID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tutor Dashboard</title>

  <!-- Bootstrap & FontAwesome -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <style>
    /* Reset & base */
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f7fa;
      color: #333;
      display: flex;
    
    }

    /* Sidebar styling */
    .sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      width: 260px;
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      color: white;
      box-shadow: 2px 0 8px rgba(0,0,0,0.2);
      display: flex;
      flex-direction: column;
      padding-top: 60px;
      transition: width 0.3s ease;
      z-index: 10;
    }

    .sidebar .profile {
      text-align: center;
      margin-bottom: 40px;
    }

    .sidebar .profile h3 {
      font-weight: 700;
      letter-spacing: 2px;
      margin-bottom: 4px;
      font-size: 1.8rem;
      color: #ffffffcc;
    }

    .sidebar .profile p {
      font-size: 1rem;
      color: #cbd5e0;
      margin-bottom: 0;
    }

    .sidebar .nav {
      flex-grow: 1;
      padding-left: 0;
    }

    .sidebar .nav-link {
      color: #cbd5e0;
      font-weight: 600;
      font-size: 1.1rem;
      padding: 14px 30px;
      display: flex;
      align-items: center;
      border-left: 4px solid transparent;
      transition: all 0.3s ease;
      cursor: pointer;
      user-select: none;
    }

    .sidebar .nav-link i {
      margin-right: 14px;
      font-size: 1.3rem;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background: rgba(255,255,255,0.15);
      color: #fff;
      border-left: 4px solid #00d8ff;
      text-decoration: none;
    }

    /* Submenu */
    .submenu {
      list-style: none;
      padding-left: 50px;
      margin-top: 6px;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }

    .submenu.show {
      max-height: 200px;
    }

    .submenu a {
      color: #a0aec0;
      font-size: 0.95rem;
      padding: 8px 0;
      display: block;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .submenu a:hover {
      color: #00d8ff;
     
    }

    /* Main content */
    .main-content {
      margin-left: 260px;
      padding: 40px 50px;
      width: calc(100% - 260px);
      min-height: 100vh;
      background: #f4f7fa;
    }

    .main-content h2 {
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 40px;
      letter-spacing: 1.2px;
      font-size: 2.2rem;
    }

    /* Cards */
    .card {
      border-radius: 18px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      border: none;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background: linear-gradient(145deg, #ffffff, #e6e9f0);
      color: #2d3748;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .card .card-body {
      display: flex;
      align-items: center;
      padding: 30px 25px;
    }

    .card .card-body i {
      font-size: 3.5rem;
      color: #00d8ff;
      margin-right: 20px;
      transition: color 0.3s ease;
    }

    .card:hover .card-body i {
      color: #0077b6;
    }

    .card .card-title {
      font-size: 1.2rem;
      font-weight: 700;
      margin-bottom: 8px;
      color: #1a202c;
    }

    .card .card-text {
      font-size: 1.6rem;
      font-weight: 900;
      color: #2b6cb0;
      letter-spacing: 0.04em;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
        padding-top: 20px;
      }

      .sidebar .profile {
        display: none;
      }

      .sidebar .nav-link {
        padding: 12px 10px;
        font-size: 0;
      }

      .sidebar .nav-link i {
        margin: 0;
        font-size: 1.5rem;
      }

      .submenu {
        padding-left: 40px;
      }

      .main-content {
        margin-left: 70px;
        padding: 30px 20px;
        width: calc(100% - 70px);
      }

      .main-content h2 {
        font-size: 1.6rem;
      }

      .card .card-text {
        font-size: 1.3rem;
      }
    }
    
  </style>
</head>
<body>

  <nav class="sidebar">
    <div class="profile">
      <h3><i class="fas fa-chalkboard-teacher"></i> TutorGrid</h3>
      <p>Welcome Tutor!</p>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="tutor_dashboard.php">
          <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link submenu-toggle" href="#">
          <i class="fas fa-chalkboard-teacher"></i> Tutor Info
          <i class="fas fa-chevron-down ml-auto"></i>
        </a>
        <ul class="submenu">
          <li><a href="TutorProfile.php">Personal Info</a></li>
          <li><a href="Course_Info.php">Course Info</a></li>
          <li><a href="Enrolled.php">Joined Learner</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">
          <i class="fas fa-sign-out-alt"></i> Log out
        </a>
      </li>
    </ul>
  </nav>

  <main class="main-content">
    <h2><?php echo $user["name"]."'"; ?> Dashboard</h2>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body">
            <i class="fas fa-users"></i>
            <div>
              <h5 class="card-title">Total Learners</h5>
              <p class="card-text">
                 <?php echo $data['total_enrolled_learners']; ?>
              </p>
            </div>
          </div>
        </div>
      </div>
     
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body">
            <i class="fas fa-book-open"></i>
            <div>
              <h5 class="card-title">Total Courses</h5>
              <p class="card-text">
               <?php echo $data['total_courses']; ?>
              </p>
            </div>
          </div>
        </div>
      </div>
       <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body">
            <i class="fas fa-user-tie"></i>
            <div>
              <h5 class="card-title">Total Lessons</h5>
              <p class="card-text">
               <?php echo $data['total_lessons']; ?>
              </p>
            </div>
          </div>
        </div>
      </div>
            <!-- Existing 3 cards here ... -->

      <!-- New Cards -->
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body">
            <i class="fas fa-star"></i>
            <div>
              <h5 class="card-title">Total Ratings</h5>
              <p class="card-text">
              <?php echo $data['total_ratings']; ?>
              </p>
            </div>
          </div>
        </div>
      </div>

      

     

    </div>
  </main>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const submenuToggles = document.querySelectorAll(".submenu-toggle");
      submenuToggles.forEach(toggle => {
        toggle.addEventListener("click", function (e) {
          e.preventDefault();
          const submenu = this.nextElementSibling;
          if (submenu) {
            submenu.classList.toggle("show");
            // Toggle chevron rotation
            this.querySelector('.fa-chevron-down').classList.toggle('rotated');
          }
        });
      });
    });
  </script>
  <style>
    /* Chevron rotate */
    .fa-chevron-down.rotated {
      transform: rotate(180deg);
      transition: transform 0.3s ease;
    }
  </style>
</body>
</html>
