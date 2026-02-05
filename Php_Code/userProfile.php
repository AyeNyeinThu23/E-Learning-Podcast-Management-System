<?php
include 'connection.php';
session_start();
$LID=$_SESSION['LID'];
$result=mysqli_query($con,"SELECT * from learner where LID='$LID'");
$user=mysqli_fetch_array($result);

$resultForEnrolled=mysqli_query($con,"SELECT c.* FROM courses c JOIN enrollment e ON c.CID = e.CID WHERE e.LID= $LID;");

?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>TutorGrid</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Lingua project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../styles/bootstrap4/bootstrap.min.css">
<link href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="../styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="../styles/responsive.css">
</head>
<body>

<div class="super_container">

		<!-- Header Content -->
		<div class="header_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="header_content d-flex flex-row align-items-center justify-content-start">
							<div class="logo_container mr-auto">
								<a href="#">
									<div class="logo_text">TutorGrid</div>
								</a>
							</div>
							<nav class="main_nav_contaner">
								<ul class="main_nav">
									<li class="active"><a href="index.php">Home</a></li>
									<li><a href="courses.php">Courses</a></li>
									<li><a href="instructors.php">Tutors</a></li>								
									
								</ul>
							</nav>
							<div class="header_content_right ml-auto text-right">
								
								</div>

								<!-- Hamburger -->

								<div class="user"><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></div>
								<div class="hamburger menu_mm">
									<i class="fa fa-bars menu_mm" aria-hidden="true"></i>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

	</header>

	<!-- Menu -->

	<div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
		<div class="menu_close_container"><div class="menu_close"><div></div><div></div></div></div>
		<div class="search">
			<form action="#" class="header_search_form menu_mm">
				<input type="search" class="search_input menu_mm" placeholder="Search" required="required">
				<button class="header_search_button d-flex flex-column align-items-center justify-content-center menu_mm">
					<i class="fa fa-search menu_mm" aria-hidden="true"></i>
				</button>
			</form>
		</div>
		<nav class="menu_nav">
			<ul class="menu_mm">
				<li class="menu_mm"><a href="index.php">Home</a></li>
				<li class="menu_mm"><a href="courses.php">Courses</a></li>
				<li class="menu_mm"><a href="instructors.php">Instructors</a></li>
				<li class="menu_mm"><a href="#">Events</a></li>
				<li class="menu_mm"><a href="blog.php">Blog</a></li>
				<li class="menu_mm"><a href="contact.php">Contact</a></li>
			</ul>
		</nav>
		<div class="menu_extra">
			<div class="menu_phone"><span class="menu_title">phone:</span>+44 300 303 0266</div>
			<div class="menu_social">
				<span class="menu_title">follow us</span>
				<ul>
					<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
	
	

	<!-- Register -->

	<div class="register">
		<div class="container">
			<div class="row">
				
				<!-- Register Form -->

				<div class="col-lg-6">
					<div class="register_form_container">
						<div class="register_form_title">Personal Information</div>
						<form action="#" id="register_form" class="register_form">
							<div class="row register_row">
								<div class="col-lg-6 register_col">
									<input type="text" class="form_input" value=<?php echo $user["name"]; ?> readonly>
								</div>
								<div class="col-lg-6 register_col">
									<input type="email" class="form_input" value=<?php echo $user["email"]; ?> readonly>
								</div>
								<div class="col-lg-6 register_col" style="position: relative;">
                                <input type="password" id="passwordField" class="form_input" 
                                value="<?php echo htmlspecialchars($_SESSION['real_password']); ?>" readonly>

                                <!-- Eye icon -->
                                <span id="togglePassword" 
                                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                        👁️
                                  </span>
                                </div>
								<div class="col-lg-6 register_col">
									<input type="url" class="form_input" value=<?php echo $user["language"]; ?> readonly>
								</div>
								<div class="col">
									<button type="submit" class="form_button trans_200"><a href='updateLearner.php'>Edit</a></button>
								</div>
								<div class="col">
									<button type="submit" class="form_button trans_200"><a href='logout.php'>Log out</a></button>
								</div>

							
							</div>
						</form>
					</div>
				</div>

				<!-- Register Timer -->

				<div class="col-lg-6">
					<div class="register_form_container">
						<div class="register_form_title">Joined Courses</div>
						<form action="#" id="register_form" class="register_form">
							<div class="row register_row">
								<?php
while ($rE= mysqli_fetch_assoc($resultForEnrolled)) {
	$CID=$rE["CID"];
?>
								<div class="col-lg-12 register_col">
								<a href="course.php?cid=<?php echo $CID; ?>"><input type="text" class="form_input" value="<?php echo $rE["Title"]; ?>" readonly></a>
								</div>
						<?php } ?>		
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	



	<!-- Footer -->

	<footer class="footer">
		<div class="footer_body">
			<div class="container">
				<div class="row">

					<!-- Newsletter -->
					<div class="col-lg-3 footer_col">
						<div class="newsletter_container d-flex flex-column align-items-start justify-content-end">
							<div class="footer_logo mb-auto"><a href="#">TutorGrid</a></div>
							<div class="footer_title">Subscribe</div>
							<form action="#" id="newsletter_form" class="newsletter_form">
								<input type="email" class="newsletter_input" placeholder="Email" required="required">
								<button class="newsletter_button"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
							</form>
						</div>
					</div>

					<!-- About -->
					<div class="col-lg-2 offset-lg-3 footer_col">
						<div>
							<div class="footer_title">About Us</div>
							<ul class="footer_list">
								<li><a href="#">Courses</a></li>
								<li><a href="#">Team</a></li>
								<li><a href="#">Brand Guidelines</a></li>
								<li><a href="#">Jobs</a></li>
								<li><a href="#">Advertise with us</a></li>
								<li><a href="#">Press</a></li>
								<li><a href="#">Contact us</a></li>
							</ul>
						</div>
					</div>

					<!-- Help & Support -->
					<div class="col-lg-2 footer_col">
						<div class="footer_title">Help & Support</div>
						<ul class="footer_list">
							<li><a href="#">Discussions</a></li>
							<li><a href="#">Troubleshooting</a></li>
							<li><a href="#">Duolingo FAQs</a></li>
							<li><a href="#">Schools FAQs</a></li>
							<li><a href="#">Duolingo English Test FAQs</a></li>
							<li><a href="#">Status</a></li>
						</ul>
					</div>

					<!-- Privacy -->
					<div class="col-lg-2 footer_col clearfix">
						<div>
							<div class="footer_title">Privacy & Terms</div>
							<ul class="footer_list">
								<li><a href="#">Community Guidelines</a></li>
								<li><a href="#">Terms</a></li>
								<li><a href="#">Brand Guidelines</a></li>
								<li><a href="#">Privacy</a></li>
							</ul>
						</div>
					</div>

				</div>
			</div>
		</div>
		
	</footer>
</div>
<script>
const passwordField = document.getElementById("passwordField");
const togglePassword = document.getElementById("togglePassword");

togglePassword.addEventListener("click", () => {
  if (passwordField.type === "password") {
    passwordField.type = "text";
    togglePassword.textContent = "🙈"; // eye closed
  } else {
    passwordField.type = "password";
    togglePassword.textContent = "👁️"; // eye open
  }
});
</script>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="js/custom.js"></script>
</body>
</html>