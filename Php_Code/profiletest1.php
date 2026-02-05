<?php
include 'connection.php';
session_start();
$email=$_SESSION['email'];

$result=mysqli_query($con,"select * from tutor where email='$email'");
$user=mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard - Tutors</title>

  <!-- Bootstrap & FontAwesome -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f7fa;
      margin: 0;
      display: flex;
      min-height: 100vh;
      font-size:0.9rem;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      width: 260px;
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
      color: white;
      box-shadow: 2px 0 8px rgba(0,0,0,0.15);
      padding-top: 60px;
      z-index: 100;
      display: flex;
      flex-direction: column;
    }

    .sidebar .profile {
      text-align: center;
      margin-bottom: 40px;
    }

    .sidebar .profile h3 {
      font-weight: 700;
      letter-spacing: 2px;
      font-size: 1.8rem;
      margin-bottom: 6px;
      color: #ffffffcc;
    }

    .sidebar .profile p {
      font-size: 1rem;
      color: #cbd5e0;
      margin: 0;
    }

    .sidebar-sticky {
      overflow-y: auto;
      flex-grow: 1;
      padding-left: 0;
    }

    .sidebar ul.nav {
      list-style: none;
      padding-left: 0;
      margin: 0;
    }

    .sidebar .nav-item {
      margin-bottom: 0;
    }

    .sidebar .nav-link {
      display: flex;
      align-items: center;
      color: #cbd5e0;
      font-weight: 600;
      font-size: 1.1rem;
      padding: 14px 30px;
      border-left: 4px solid transparent;
      transition: all 0.3s ease;
      cursor: pointer;
      user-select: none;
      text-decoration: none;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background: rgba(255,255,255,0.15);
      color: #fff;
      border-left: 4px solid #00d8ff;
      text-decoration: none;
    }

    .sidebar .nav-link i {
      margin-right: 14px;
      font-size: 1.3rem;
    }

    /* Submenu */
    .submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
      padding-left: 50px;
      list-style: none;
      margin: 0;
    }

    .submenu.show {
      max-height: 300px; /* enough height for submenu */
    }

    .submenu a {
      display: block;
      padding: 8px 0;
      font-size: 0.95rem;
      color: #a0aec0;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .submenu a:hover {
      color: #00d8ff;
      
    }

    /* Main content */
    main {
      margin-left: 240px;
      padding: 40px 50px;
      width: calc(100% - 260px);
      background: #f4f7fa;
      min-height: 100vh;
    }

   main h2 {
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 30px;
      letter-spacing: 1.2px;
      font-size: 2.2rem;
    }

  
  .table-container {
    margin-top: 60px; /* Adjust according to your sidebar height */
  }

  /* Updated button styles */
  .table-container .btn {
    margin-right: 5px;
    background-color: white; /* Set button background color */
    color: black; /* Set button text color */
    border: 1px solid black; /* Add border for better visibility */
  }

  /* Change button color on hover */
  .table-container .btn:hover {
    background-color:#DEDEDE; /* Change background color on hover */
    color: blue; /* Change text color on hover */
  }
  .table-container .btn .fas {
    color: blue; /* Change color to blue */
  }
  .table-container .btn-success a {
    color: blue; /* Change text color to blue */
    text-decoration: none; /* Remove underline */
  }

  /* Change "Add" button color on hover */
  .table-container .btn-success:hover {
    background-color: #DEDEDE;
  }
   /* Buttons */
    .btn {
      margin-right: 8px;
      font-size: 0.9rem;
      border-radius: 8px;
      padding: 6px 12px;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-primary {
      background-color: #0077b6;
      border-color: #0077b6;
      color: white;
    }

    .btn-primary:hover {
      background-color: #005f8a;
      border-color: #005f8a;
      color: white;
      text-decoration: none;
    }

    .btn-danger {
      background-color: #d90429;
      border-color: #d90429;
      color: white;
    }

    .btn-danger:hover {
      background-color:rgb(12, 1, 1);
      border-color:rgb(0, 0, 0);
      color: white;
      text-decoration: none;
    }

    .btn-success {
      background-color: #00b4d8;
      border-color: #00b4d8;
    
      margin-top: 20px;
      font-weight: 600;
      padding: 10px 18px;
      border-radius: 12px;
    }

    .btn-success:hover {
      background-color: #0096c7;
      border-color: #0096c7;
      text-decoration: none;
     color: black;
    }

    .btn a {
      color: inherit;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn a:hover {
      color: inherit;
      text-decoration: none;
    }
    /* Responsive */
    @media (max-width: 768px) {
      main {
        margin-left: 0;
        padding: 20px;
        width: 100%;
      }

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
    }
    .profile-card {
    max-width: 100%;
   
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
.profile-icon {
    font-size: 80px;
    color: #2a5298;
    margin-bottom: 15px;
}
.profile-card h3 {
    font-weight: bold;
    color: #333;
}
.profile-card p {
    color: #555;
    margin-bottom: 8px;
}
.btn-edit {
    background-color: #0077b6;
    color: white;
    border-radius: 8px;
    padding: 8px 20px;
    margin: 5px;
}
.btn-delete {
    background-color: #d90429;
    color: white;
    border-radius: 8px;
    padding: 8px 20px;
    margin: 5px;
}

  </style>
</head>
<body>

  <nav class="sidebar">
    <div class="profile">
      <h3><i class="fas fa-chalkboard-teacher"></i> TutorGrid</h3>
      <p>Welcome Admin!</p>
    </div>
    <div class="sidebar-sticky">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="admin_dashboard.php">
            <i class="fas fa-tachometer-alt"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link submenu-toggle" href="#">
            <i class="fas fa-user-graduate"></i> Learner Info
            <i class="fas fa-chevron-down ml-auto"></i>
          </a>
          <ul class="submenu">
            <li><a href="UserInfo.php">Personal Info</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link submenu-toggle" href="#">
            <i class="fas fa-chalkboard-teacher"></i> Tutor Info
            <i class="fas fa-chevron-down ml-auto"></i>
          </a>
          <ul class="submenu">
            <li><a href="TutorInfo.php">Personal Info</a></li>
            <li><a href="Course_Info.php">Course Info</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">
            <i class="fas fa-sign-out-alt"></i> Log out
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <main role="main">
    <div class="table-container">
      <h2>Tutor Personal Info</h2>
      <!-- Profile Card instead of table -->
    <div class="profile-card">
        <div class="profile-icon">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Password:</strong> <?php echo htmlspecialchars($user['password']); ?></p>
        <div>
            <a href="update.php?upId=<?php echo $user['TID']; ?>" class="btn btn-edit">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="delete.php?deId=<?php echo $user['TID']; ?>" class="btn btn-delete">
                <i class="fas fa-trash-alt"></i> Delete
            </a>
        </div>
    </div>
  </div>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", function(){
      const submenuToggles = document.querySelectorAll('.submenu-toggle');
      submenuToggles.forEach(function(item) {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          const submenu = item.nextElementSibling;
          submenu.classList.toggle('show');
          // Rotate chevron
          const chevron = this.querySelector('.fa-chevron-down');
          if (chevron) {
            chevron.classList.toggle('rotated');
          }
        });
      });
    });
  </script>

  <style>
    .fa-chevron-down.rotated {
      transform: rotate(180deg);
      transition: transform 0.3s ease;
    }
  </style>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
