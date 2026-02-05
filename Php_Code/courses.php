<?php
include 'connection.php';
session_start();
$email=$_SESSION['email'];
$learnerResult=mysqli_query($con, "SELECT * FROM learner WHERE email='$email'");
$learner = mysqli_fetch_assoc($learnerResult);
$LID = $learner['LID'];   // learner id from session
      // course id from URL or button click
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Courses</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Lingua project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../styles/bootstrap4/bootstrap.min.css">
<link href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="../styles/courses.css">
<link rel="stylesheet" type="text/css" href="../styles/courses_responsive.css">
</head>
   <style>
        .btn {
			    position:relative;
				right:1px; 
				left:60px;
				bottom:2px;   /* text inside button stays centered */
            padding: 10px 15px;
            font-size: 10px;
            border-radius: 10px;
            cursor: pointer;
        }
        .enroll-btn {
            background: blue;
            color: white;
            border: none;
        }
        .enrolled-btn {
            background: red;
            color: white;
            border: none;
           
        }
		
    </style>
<body>

<div class="super_container">

	<!-- Header -->

	<header class="header">
			
	

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
									<li><a href="index.php">Home</a></li>
									<li class="active"><a href="courses.php">Courses</a></li>
									<li><a href="instructors.php">Tutors</a></li>
									
								</ul>
							</nav>
							<div class="header_content_right ml-auto text-right">
								
								</div>

								<!-- Hamburger -->

								<div class="user"><a href="userProfile.php"><i class="fa fa-user" aria-hidden="true"></i></a></div>
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
				<li class="menu_mm"><a href="index.html">Home</a></li>
				<li class="menu_mm"><a href="courses.html">Courses</a></li>
				<li class="menu_mm"><a href="instructors.html">Instructors</a></li>
				<li class="menu_mm"><a href="#">Events</a></li>
				<li class="menu_mm"><a href="blog.html">Blog</a></li>
				<li class="menu_mm"><a href="contact.html">Contact</a></li>
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
	
	

	<!-- Language -->

	<div class="language">
		<div class="container">
			<div class="row">
				
			</div>
			<div class="row">
				<div class="col">
					<div class="language_slider_container">
						
						<!-- Language Slider -->

						<div class="owl-carousel owl-theme language_slider">

							<!-- Flag -->
							<div class="owl-item language_item">
								<a href="#">
									<div class="flag"><img src="../images/Ukrainian.svg" alt=""></div>
									<div class="lang_name">Ukrainian</div>
								</a>
							</div>

							<!-- Flag -->
							<div class="owl-item language_item">
								<a href="#">
									<div class="flag"><img src="../images/Japanese.svg" alt=""></div>
									<div class="lang_name">Japanese</div>
								</a>
							</div>

							<!-- Flag -->
							<div class="owl-item language_item">
								<a href="#">
									<div class="flag"><img src="../images/Lithuanian.svg" alt=""></div>
									<div class="lang_name">Lithuanian</div>
								</a>
							</div>

							<!-- Flag -->
							<div class="owl-item language_item">
								<a href="#">
									<div class="flag"><img src="../images/Swedish.svg" alt=""></div>
									<div class="lang_name">Swedish</div>
								</a>
							</div>

							<!-- Flag -->
							<div class="owl-item language_item">
								<a href="#">
									<div class="flag"><img src="../images/English.svg" alt=""></div>
									<div class="lang_name">English</div>
								</a>
							</div>

							<!-- Flag -->
							<div class="owl-item language_item">
								<a href="#">
									<div class="flag"><img src="../images/Italian.svg" alt=""></div>
									<div class="lang_name">Italian</div>
								</a>
							</div>

							<!-- Flag -->
							<div class="owl-item language_item">
								<a href="#">
									<div class="flag"><img src="../images/Chinese.svg" alt=""></div>
									<div class="lang_name">Chinese</div>
								</a>
							</div>

							<!-- Flag -->
							<div class="owl-item language_item">
								<a href="#">
									<div class="flag"><img src="../images/French.svg" alt=""></div>
									<div class="lang_name">French</div>
								</a>
							</div>

							<!-- Flag -->
							<div class="owl-item language_item">
								<a href="#">
									<div class="flag"><img src="../images/German.svg" alt=""></div>
									<div class="lang_name">German</div>
								</a>
							</div>

						</div>

						<div class="lang_nav lang_prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
						<div class="lang_nav lang_next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Courses -->

	<div class="courses">
		<div class="container">
			<div class="row courses_row">

		
<?php
$sql = "SELECT 
            t.name AS tutor_name,
            c.CID,
            c.Title AS course_title,
            c.language,
            COUNT(l.LessonID) AS total_lessons
        FROM Tutor t
        JOIN TCA tca ON t.TID = tca.TID
        JOIN Courses c ON tca.CID = c.CID
        LEFT JOIN Lessons l ON c.CID = l.CID
        GROUP BY t.TID, t.name, c.CID, c.Title, c.language";

$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {
?>


				<!-- Course -->
				<div class="col-lg-4 course_col">
					<div class="course">
						<div class="course_image"><img src="../images/course_8.jpg" alt=""></div>
						<div class="course_body">
							<div class="course_title"><a href="course.php"><?php echo htmlspecialchars($row['course_title']); ?></a></div>
							<div class="course_info">
								<ul>
									<li><a href="instructors.php"><?php echo htmlspecialchars($row['tutor_name']); ?></a></li>
									<li><a href="#"><?php echo htmlspecialchars($row['language']); ?></a></li>
								</ul>
							</div>
							<div class="course_text">
								<p>(<?php echo $row['total_lessons'] ?> Podcasts)</p>
							</div>
							<?php 
$CID = $row['CID'];
$check = mysqli_query($con, "SELECT * FROM Enrollment WHERE CID='$CID' AND LID='$LID'");
$alreadyEnrolled = mysqli_num_rows($check) > 0;


						$sqlTotalEnrolled=mysqli_query($con,"SELECT COUNT(*) AS total_learners FROM Enrollment WHERE CID = '$CID';");
							$TotalE = mysqli_fetch_assoc($sqlTotalEnrolled);?>
						</div>
						<div class="course_footer d-flex flex-row align-items-center justify-content-start">
							<div class="course_students"><i class="fa fa-user" aria-hidden="true"></i><span><?php echo $TotalE['total_learners'];?></span></div>
							<div style="text-align:center;">
							<?php if($alreadyEnrolled): ?>
    <!-- Show "Enrolled" with different color -->
    <a href="course.php?cid=<?php echo $CID; ?>" class="btn enrolled-btn">
    Joined
</a>
<?php else: ?>
    <!-- Show "Join Now" -->
    <form method="post" action="enroll.php" style="display:inline;">
    <input type="hidden" name="CID" value="<?php echo $CID; ?>">
    <button type="submit" name="enroll" class="btn enroll-btn">
        Join Now
    </button>
</form>
<?php endif; ?>
</div>
<div class="course_rating ml-auto"><i class="fa fa-star" aria-hidden="true"></i><span>4,5</span></div>

						</div>
					</div>
				</div>
   <?php
}
?>		

			</div>

			<div class="row">
				<div class="col">
					<div class="load_more_button"><a href="#">load more</a></div>
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

<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="js/courses.js"></script>
</body>
</html>