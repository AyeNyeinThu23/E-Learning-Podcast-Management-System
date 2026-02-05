<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$result = mysqli_query($con, "SELECT * FROM tutor WHERE email='$email'");
$user = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tutor Profile</title>

<!-- Bootstrap & FontAwesome -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f7fa;
        margin: 0;
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 220px;
        background: linear-gradient(180deg, #2a5298, #1e3c72);
        color: white;
        padding-top: 20px;
    }
    .sidebar h3 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 1.3rem;
    }
    .sidebar a {
        display: block;
        padding: 12px 20px;
        color: white;
        text-decoration: none;
        font-size: 1rem;
        transition: background 0.3s;
    }
    .sidebar a:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
    }

    /* Main content */
    .main {
        margin-left: 240px;
        padding: 30px;
    }

    /* Profile card */
    .profile-card {
        max-width: 500px;
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        text-align: center;
    }
    .profile-icon {
        font-size: 80px;
        color: #2a5298;
        margin-bottom: 15px;
    }
    .profile-name {
        font-size: 1.8rem;
        font-weight: bold;
        color: #2d3748;
    }
    .profile-info {
        margin-top: 15px;
        text-align: left;
    }
    .profile-info p {
        font-size: 1rem;
        margin: 8px 0;
    }
    .btn-edit {
        margin-top: 20px;
        background-color: #2a5298;
        color: white;
        border-radius: 8px;
        padding: 10px 20px;
    }
    .btn-edit:hover {
        background-color: #1e3c72;
        color: white;
    }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h3><i class="fas fa-chalkboard-teacher"></i> Tutor Panel</h3>
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
    <a href="courses.php"><i class="fas fa-book"></i> My Courses</a>
    <a href="progress.php"><i class="fas fa-chart-line"></i> Learner Progress</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- Main content -->
<div class="main">
    <div class="profile-card mx-auto">
        <i class="fas fa-chalkboard-teacher profile-icon"></i>
        <div class="profile-name"><?php echo htmlspecialchars($user['name']); ?></div>
        <div class="profile-info">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Password:</strong> <?php echo htmlspecialchars($user['password']); ?></p>
        </div>
        <a href="update.php?upId=<?php echo $user['TID']; ?>" class="btn btn-edit">
            <i class="fas fa-edit"></i> Edit Profile
        </a>
    </div>
</div>

</body>
</html>
