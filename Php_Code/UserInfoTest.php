<?php
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
  .sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
  }

  .profile-image {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin-bottom: 10px;
  }

  .sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - 48px);
    padding-top: .5rem;
    overflow-x: hidden;
    overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
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
    color: white; /* Change text color on hover */
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
  .submenu {
  display: none;
}

.submenu.show {
  display: block;
}
.submenu a:hover {
  text-decoration:none;
}

</style>
</head>
<body>

<nav class="col-md-2 d-none d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <div class="profile text-center">
              
    <h3>TutorGrid</h3>
      <p>Welcome Admin!</p>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="admin_dashboard.php">
          Dashboard <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link submenu-toggle" href="#">
          Learner Info
        </a>
        <ul class="submenu">
          <li><a href="UserInfo.php">Personal Info</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link submenu-toggle" href="#">
          Tutor Info
        </a>
        <ul class="submenu">
          <li><a href="designer.php">Personal Info</a></li>
          <li><a href="showImage.php">Design Info</a></li>
         
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">
         Log out
        </a>
      </li>
    </ul>
  </div>
</nav>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="table-container">
    <h2>Learner Personal Info</h2>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Language</th>
            <th>Operations</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $result=mysqli_query($con,"select * from learner");
          $num= mysqli_num_rows($result);
          for($i=0;$i<$num;$i++){
              $user = mysqli_fetch_array($result);
              $id=$user["LID"];
              echo "<tr>";
              echo "<td>".$user["name"]."</td>";
              echo "<td>".$user["email"]."</td>";
              echo "<td>".$user["password"]."</td>";
              echo "<td>".$user["language"]."</td>";
              echo "<td>
                    <button class='btn btn-primary'><a href='update.php?upId=$id' class='text-light'><i class='fas fa-edit'></i></a></button>
                    <button class='btn btn-danger'><a href='delete.php?deId=$id'><i class='fas fa-trash-alt'></i></a></button>
                    </td>";
              echo "</tr>";
          }
        ?>
        </tbody>
      </table>
      <button class="btn btn-success"><a href="adminRegister.php" style="text-decoration:none;"><i class="fas fa-plus"></i> Add</a></button>

    </div>
  </div>
</main>
<script>
document.addEventListener("DOMContentLoaded", function(){
  var submenuToggle = document.querySelectorAll('.submenu-toggle');
  submenuToggle.forEach(function(item) {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      var submenu = item.nextElementSibling;
      submenu.classList.toggle('show');
    });
  });
});
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
