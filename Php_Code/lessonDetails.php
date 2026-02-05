<?php
include 'connection.php';
session_start();
$email=$_SESSION['email'];
$LessonID=$_GET["lessonid"];
$sql="SELECT 
    l.title AS lesson_title,
	l.description AS lesson_description,
	l.file_path AS lesson_audio,
    t.name AS teacher_name,
    c.language AS course_language,
    l.uploaded_at AS lesson_created_date
FROM Lessons l
JOIN Courses c ON l.CID = c.CID
JOIN TCA tc ON c.CID = tc.CID
JOIN Tutor t ON tc.TID = t.TID
WHERE l.LessonID = $LessonID";

$sqlResult=mysqli_query($con,$sql);
$Result= mysqli_fetch_assoc($sqlResult);

$audioFile = "../" .$Result["lesson_audio"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Podcasts</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Lingua project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../styles/bootstrap4/bootstrap.min.css">
<link href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/animate.css">
<link href="../plugins/video-js/video-js.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../styles/blog_single.css">
<link rel="stylesheet" type="text/css" href="../styles/blog_single_responsive.css">
</head>
<style>  audio {
            width: 100%;
            margin-top: 10px;
        }</style>
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
									<li><a href="instructors.php">Instructors</a></li>
								</ul>
							</nav>
							<div class="header_content_right ml-auto text-right">
								<div class="header_search">
									<div class="search_form_container">
										<form action="#" id="search_form" class="search_form trans_400">
											<input type="search" class="header_search_input trans_400" placeholder="Type for Search" required="required">
											<div class="search_button">
												<i class="fa fa-search" aria-hidden="true"></i>
											</div>
										</form>
									</div>
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
			<ul class="main_nav">
				<li class="active"><a href="index.php">Home</a></li>
				<li><a href="courses.php">Courses</a></li>
				<li><a href="instructors.php">Instructors</a></li>
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
	
	

	<!-- Blog Image -->

	<div class="blog_top_image">
		<div class="blog_top">
			<div class="blog_background parallax-window" data-parallax="scroll" data-image-src="../images/podcast1.svg" data-speed="0.8"></div>
		</div>
	</div>

	<!-- Blog Content -->

	<div class="blog_container">
		<div class="container">
			<div class="row blog_content_row">
				<div class="col">
					<div class="blog_content">
						<div class="blog_post_title_container">
							<div class="blog_category"><?php echo $Result["course_language"];?></div>
							<div class="blog_title"><?php echo $Result["lesson_title"];?></div>
						</div>
						<div class="blog_text">
							<audio controls>
               				 <source src="<?php echo (htmlspecialchars($audioFile));?>" type="audio/mpeg">
                			Your browser does not support the audio element.
            				</audio>
							<br><br>
							<p><?php echo nl2br(htmlspecialchars($Result["lesson_description"]));?></p>
						</div>
						
						<div class="blog_post_footer d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start">
							<div class="blog_post_author d-flex flex-row align-items-center justify-content-start">
								<div><i class="fa fa-user-circle" style="font-size:25px; color:blue;" aria-hidden="true"></i></div>
								<div class="author_info">
									<ul>
										<li>Tutor: <?php echo $Result['teacher_name']; ?></li>
										<li>Uploaded on: <?php echo $Result['lesson_created_date']; ?></li>
									</ul>
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

	<!-- Footer -->

	<footer class="footer">
		<div class="footer_body">
			<div class="container">
				<div class="row">

					<!-- Newsletter -->
					<div class="col-lg-3 footer_col">
						<div class="newsletter_container d-flex flex-column align-items-start justify-content-end">
							<div class="footer_logo mb-auto"><a href="#">Lingua</a></div>
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

<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../styles/bootstrap4/popper.js"></script>
<script src="../styles/bootstrap4/bootstrap.min.js"></script>
<script src="../plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="../plugins/easing/easing.js"></script>
<script src="../plugins/parallax-js-master/parallax.min.js"></script>
<script src="../js/blog_single.js"></script>
</body>
</html>