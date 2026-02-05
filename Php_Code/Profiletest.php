<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];

// Prepared statement to prevent SQL injection
$stmt = $con->prepare("SELECT * FROM tutor WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Dashboard - Tutor Profile</title>

<!-- Bootstrap & FontAwesome -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f4f7fa;
        margin: 0;
        display: flex;
        min-height: 100vh;
    }
    .sidebar {
        position: fixed;
        width: 260px;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;
        padding-top: 60px;
        box-shadow: 2px 0 8px rgba(0,0,0,0.15);
        height: 100%;
    }
    .sidebar .profile {
        text-align: center;
        margin-bottom: 40px;
    }
    .sidebar .profile h3 {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 6px;
        color: #ffffffcc;
    }
    .sidebar .nav-link {
        color: #cbd5e0;
        font-weight: 600;
        padding: 14px 30px;
        transition: 0.3s;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background: rgba(255,255,255,0.15);
        color: white;
        border-left: 4px solid #00d8ff;
    }
    main {
        margin-left: 260px;
        padding: 40px;
        width: calc(100% - 260px);
    }
    .profile-card {
        max-width: 800px;
        margin: auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 30px;
    }
    .profile-card h2 {
        font-weight: 700;
        color: #2d3748;
    }
    .profile-info p {
        margin: 6px 0;
        font-size: 1rem;
    }
    .btn-custom {
        border-radius: 8px;
        margin-right: 8px;
    }
</style>
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar">
    <div class="profile">
        <h3><i class="fas fa-chalkboard-teacher"></i> TutorGrid</h3>
        <p>Welcome, Admin!</p>
    </div>
    <ul class="nav flex-column">
        <li><a class="nav-link active" href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a class="nav-link" href="UserInfo.php"><i class="fas fa-user-graduate"></i> Learner Info</a></li>
        <li><a class="nav-link" href="TutorInfo.php"><i class="fas fa-chalkboard-teacher"></i> Tutor Info</a></li>
        <li><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
    </ul>
</nav>

<!-- Main Content -->
<main>
    <div class="profile-card">
        <h2 class="mb-4">Tutor Profile</h2>
        <div class="profile-info">
            <p><strong>Name:</strong> <?= htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
            <p><strong>Password:</strong> <?= htmlspecialchars($user['password']); ?></p>
        </div>
        <hr>
        <div>
            <a href="update.php?upId=<?= $user['TID']; ?>" class="btn btn-primary btn-custom"><i class="fas fa-edit"></i> Edit</a>
            <a href="delete.php?deId=<?= $user['TID']; ?>" class="btn btn-danger btn-custom" onclick="return confirm('Are you sure you want to delete this tutor?');"><i class="fas fa-trash-alt"></i> Delete</a>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
