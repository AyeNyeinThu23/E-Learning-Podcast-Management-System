<?php
include 'connection.php';
session_start();
$email=$_SESSION['email'];
$CID=$_GET['cid'];


// Total lessons
$lessonsResult = mysqli_query($con, "SELECT COUNT(*) AS total FROM Lessons WHERE CID='$CID'");
$totalLessons = mysqli_fetch_assoc($lessonsResult)['total'];

// Total learners
$learnersResult = mysqli_query($con, "SELECT COUNT(*) AS total FROM Enrollment WHERE CID='$CID'");
$totalLearners = mysqli_fetch_assoc($learnersResult)['total'];

// Total reviews
$reviewsResult = mysqli_query($con, "SELECT COUNT(*) AS total FROM Ratings WHERE CID='$CID'");
$totalReviews = mysqli_fetch_assoc($reviewsResult)['total'];






?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Course</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Lingua project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../styles/bootstrap4/bootstrap.min.css">
<link href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="../styles/course.css">
<link rel="stylesheet" type="text/css" href="../styles/course_responsive.css">
<style>
.review-form {
  max-width: 800px;
  margin: 20px auto;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 10px;
  background: #fff;
}

.review-form h3 {
  margin-bottom: 15px;
}

.review-form .form-group {
  margin-bottom: 15px;
}

.review-form input, 
.review-form textarea {
  width: 100%;
  padding: 8px;
  border-radius: 6px;
  border: 1px solid #ccc;
}

/* Hide the radio circles */
.review-form .rating input {
  display: none;
}

.review-form .rating {
  display: flex;
  flex-direction: row-reverse;
  justify-content: flex-end;
}

.review-form .rating label {
  color: #ccc;
  font-size: 26px;
  cursor: pointer;
  margin: 0 2px;
  transition: color 0.2s;
}

/* When checked */
.review-form .rating input:checked ~ label {
  color: gold;
}

/* Hover effect */
.review-form .rating label:hover,
.review-form .rating label:hover ~ label {
  color: gold;
}

.review-form .btn {
  width: 100%;
  padding: 10px;
  background: #007bff;
  border: none;
  color: #fff;
  border-radius: 6px;
  cursor: pointer;
}

.review-form .btn:hover {
  background: #0056b3;
}
</style>
</head>
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
									<li class="active"><a href="index.php">Home</a></li>
									<li><a href="courses.php">Courses</a></li>
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
	
	
	<!-- Intro -->


		<br><br><br><br>
	

	<!-- Course -->

	<div class="course">
		<div class="course_top"></div>
		<div class="container">
			<div class="row row-lg-eq-height">

				<!-- Panels -->
				<div class="col-lg-9">
					<div class="tab_panels">

						<!-- Tabs -->
						<div class="course_tabs_container">
							<div class="container">
								<div class="row">
									<div class="col-lg-9">
										<div class="tabs d-flex flex-row align-items-center justify-content-start">
											<div class="tab active">description</div>
											<div class="tab">reviews</div>
											
										</div>
									</div>
								</div>
							</div>		
						</div>

						<!-- Description -->
						<div class="tab_panel description active">
							<div class="panel_title">Learning with Podcasts</div>
							<div class="panel_text">
								<p>Learn any language naturally by listening to podcasts that improve your listening, speaking, and comprehension skills.</p>
							</div>
							
							

							<!-- FAQs -->
							<div class="faqs">
								<div class="panel_title">Podcasts</div>
								<div class="accordions">
												
									<div class="elements_accordions">
<?php
$lessonQuery = mysqli_query($con, "SELECT * FROM Lessons WHERE CID='$CID'");
while($lesson = mysqli_fetch_assoc($lessonQuery)){
?>
										<div class="accordion_container">
										<div class="accordion d-flex flex-row align-items-center">
											<div>
												 <a href="lessonDetails.php?lessonid=<?php echo $lesson['LessonID']; ?>">
                   								 <?php echo htmlspecialchars($lesson['title']); ?>
	               								 </a>
											</div></div>
											<div class="accordion_panel">
											</div>
										</div>
<?php
}
?>

									
									</div>

								</div>
							</div>
						</div>

						

						<!-- Reviews -->
						<div class="tab_panel reviews">

<form action="submit_review.php" method="POST" class="review-form">
  <h3>Leave a Review</h3>

  <!-- Rating (Stars Only) -->
  <div class="form-group">
    <label>Rating</label>
    <div class="rating">
	<input type="hidden" name="CID" value="<?php echo $CID; ?>">
      <input type="radio" id="star5" name="rating" value="5">
      <label for="star5"><i class="fa fa-star"></i></label>

      <input type="radio" id="star4" name="rating" value="4">
      <label for="star4"><i class="fa fa-star"></i></label>

      <input type="radio" id="star3" name="rating" value="3">
      <label for="star3"><i class="fa fa-star"></i></label>

      <input type="radio" id="star2" name="rating" value="2">
      <label for="star2"><i class="fa fa-star"></i></label>

      <input type="radio" id="star1" name="rating" value="1">
      <label for="star1"><i class="fa fa-star"></i></label>
    </div>
  </div>

  <!-- Comment -->
  <div class="form-group">
    <textarea id="comment" name="comment" rows="4" placeholder="Your Review..." required></textarea>
  </div>

  <!-- Submit -->
  <button type="submit" class="btn" name="ReviewSubmit">Submit Review</button>
</form>
<?php
if ($CID > 0) {
    $sql = "SELECT r.review, r.rating, r.rate_date, l.name
            FROM Ratings r
            JOIN Learner l ON r.LID = l.LID
            WHERE r.CID = ?
            ORDER BY r.rate_date DESC";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $CID);
    $stmt->execute();

    // Use bind_result so it works without mysqlnd
    $stmt->bind_result($review, $rating, $rate_date, $name);

    $hasRows = false;
    echo '<div class="cur_reviews">';
    while ($stmt->fetch()) {
        $hasRows = true;

        $name    = htmlspecialchars($name);
        $comment = htmlspecialchars($review);
        // With DATE you only have Y-m-d; if you want time, change column to DATETIME.
        $date    = date("M d, Y", strtotime($rate_date));

        $rating = (int)$rating;
        $ratingClass = "rating_r_" . max(1, min(5, $rating));

        echo '<div class="review">';
        echo '  <div class="review_title_container d-flex flex-row align-items-start justify-content-start">';
        echo '      <div class="review_title d-flex flex-row align-items-center justify-content-center">';
        echo '       <div><i class="fa fa-user-circle" style="font-size:27px; color:blue;" aria-hidden="true"></i></div>';
        echo '          <div class="review_author">';
        echo '              <div class="review_author_name"><a href="#">' . $name . '</a></div>';
        echo '              <div class="review_date">' . $date . '</div>';
        echo '          </div>';
        echo '      </div>';
        echo '      <div class="review_stars ml-auto">';
        echo '          <div class="rating_r ' . $ratingClass . ' review_rating"><i></i><i></i><i></i><i></i><i></i></div>';
        echo '      </div>';
        echo '  </div>';
        echo '  <div class="review_text"><p>' . $comment . '</p></div>';
        echo '</div>';
    }
    if (!$hasRows) {
        echo '<p>No reviews yet. Be the first to review this course!</p>';
    }
    echo '</div>';

    $stmt->close();
} else {
    // Optional: help yourself debug missing cid
    // echo '<p>Invalid course id.</p>';
}
?>
				
						</div>
					</div>
				</div>






				<!-- Sidebar -->
				<div class="col-lg-3">
					<div class="sidebar">
						<div class="sidebar_background"></div>
						<div class="sidebar_top"><a href="#">Learn More</a></div>
						<div class="sidebar_content">

							<!-- Features -->
							<div class="sidebar_section features">
								<div class="sidebar_title">Course Features</div>
								<div class="features_content">
									<ul class="features_list">

										

										<!-- Feature -->
										<li class="d-flex flex-row align-items-start justify-content-start">
											<div class="feature_title"><i class="fa fa-podcast" aria-hidden="true"></i><span>Podcasts</span></div>
											<div class="feature_text ml-auto"><?php echo $totalLessons; ?></div>
										</li>

										

										<!-- Feature -->
										<li class="d-flex flex-row align-items-start justify-content-start">
											<div class="feature_title"><i class="fa fa-users" aria-hidden="true"></i><span>Learners</span></div>
											<div class="feature_text ml-auto"><?php echo $totalLearners; ?></div>
										</li>

										<!-- Feature -->
										<li class="d-flex flex-row align-items-start justify-content-start">
											<div class="feature_title"><i class="fa fa-star" aria-hidden="true"></i><span>Reviews</span></div>
											<div class="feature_text ml-auto"><?php echo $totalReviews; ?></div>
										</li>
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

<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../styles/bootstrap4/popper.js"></script>
<script src="../styles/bootstrap4/bootstrap.min.js"></script>
<script src="../plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="../plugins/easing/easing.js"></script>
<script src="../plugins/parallax-js-master/parallax.min.js"></script>
<script src="../plugins/progressbar/progressbar.min.js"></script>
<script src="../js/course.js"></script>
</body>
</html>