-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 05, 2026 at 10:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tutorgrid`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `EnrollLearner` (IN `learner_id` INT, IN `course_id` INT)   BEGIN
    DECLARE already_enrolled INT;
    
    SELECT COUNT(*) INTO already_enrolled 
    FROM Enrollment 
    WHERE LID = learner_id AND CID = course_id;

    IF already_enrolled = 0 THEN
        INSERT INTO Enrollment (CID, LID) VALUES (course_id, learner_id);
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Learner is already enrolled in this course.';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAdminDashboardTotals` ()   BEGIN
    SELECT
        -- 1. Total Courses
        (SELECT COUNT(*) FROM Courses) AS total_courses,

        -- 2. Total Lessons
        (SELECT COUNT(*) FROM Lessons) AS total_lessons,

        -- 3. Total Learners
        (SELECT COUNT(*) FROM Learner) AS total_learners,

        -- 4. Total Tutors
        (SELECT COUNT(*) FROM Tutor) AS total_tutors,

        -- 5. Total Enrollments
        (SELECT COUNT(*) FROM Enrollment) AS total_enrollments,

        -- 6. Total Ratings
        (SELECT COUNT(*) FROM Ratings) AS total_ratings;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTutorSimpleTotals` (IN `tutor_id` INT)   BEGIN
    SELECT
        -- 1. Total Courses
        (SELECT COUNT(*) 
         FROM TCA 
         WHERE TID = tutor_id) AS total_courses,

        -- 2. Total Lessons
        (SELECT COUNT(*) 
         FROM Lessons l
         JOIN TCA tca ON l.CID = tca.CID
         WHERE tca.TID = tutor_id) AS total_lessons,

        -- 3. Total Enrolled Learners (unique learners)
        (SELECT COUNT(DISTINCT e.LID)
         FROM Enrollment e
         JOIN TCA tca ON e.CID = tca.CID
         WHERE tca.TID = tutor_id) AS total_enrolled_learners,

        -- 4. Total Ratings
        (SELECT COUNT(r.RID)
         FROM Ratings r
         JOIN TCA tca ON r.CID = tca.CID
         WHERE tca.TID = tutor_id) AS total_ratings;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `LogID` int(11) NOT NULL,
  `user_type` enum('Tutor','Learner') NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`LogID`, `user_type`, `user_name`, `action`, `details`, `log_time`) VALUES
(1, 'Tutor', 'Yu Yu', 'COURSE_CREATED', 'Created course: Japanese with Yu', '2026-02-05 07:57:13'),
(2, 'Tutor', 'Gue Gue', 'COURSE_CREATED', 'Created course: Daily Conversation', '2026-02-05 08:02:06'),
(3, 'Tutor', 'Honey', 'COURSE_CREATED', 'Created course: Korea Basic', '2026-02-05 08:04:48'),
(4, 'Learner', 'Aye', 'COURSE_JOINED', 'Joined in course \"Japanese with Yu\"', '2026-02-05 08:22:49'),
(5, 'Learner', 'Aye', 'COURSE_RATED', 'Rated course \"Japanese with Yu\" with 4', '2026-02-05 08:24:04'),
(6, 'Tutor', 'Thiha', 'COURSE_CREATED', 'Created course: Learn with Thiha', '2026-02-05 08:29:04'),
(7, 'Tutor', 'Nyein Thu', 'COURSE_CREATED', 'Created course: About Japan', '2026-02-05 08:33:43'),
(8, 'Learner', 'Kyaw Kyaw', 'COURSE_JOINED', 'Joined in course \"Daily Conversation\"', '2026-02-05 08:35:52'),
(9, 'Learner', 'Kyaw Kyaw', 'COURSE_RATED', 'Rated course \"Daily Conversation\" with 3', '2026-02-05 08:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `name`, `password`, `email`) VALUES
(1, 'admin2', 'syWwoiuLGYtj0D0QGF+2ig==', 'admin2@mail.com');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `CID` int(11) NOT NULL,
  `language` varchar(50) DEFAULT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CID`, `language`, `Title`, `created_at`) VALUES
(1, 'Japanese', 'Japanese with Yu', '2026-02-05 07:57:13'),
(2, 'English', 'Daily Conversation', '2026-02-05 08:02:06'),
(3, 'Korea', 'Korea Basic', '2026-02-05 08:04:48'),
(4, 'Engish', 'Learn with Thiha', '2026-02-05 08:29:04'),
(5, 'Japanese', 'About Japan', '2026-02-05 08:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `EnID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `LID` int(11) NOT NULL,
  `Edate` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`EnID`, `CID`, `LID`, `Edate`) VALUES
(1, 1, 1, '2026-02-05'),
(2, 2, 2, '2026-02-05');

--
-- Triggers `enrollment`
--
DELIMITER $$
CREATE TRIGGER `after_enrollment_insert` AFTER INSERT ON `enrollment` FOR EACH ROW BEGIN
    DECLARE learnerName VARCHAR(150);
    DECLARE courseTitle VARCHAR(255);

    -- Get learner name
    SELECT name 
    INTO learnerName 
    FROM Learner 
    WHERE LID = NEW.LID;

    -- Get course title
    SELECT Title 
    INTO courseTitle 
    FROM Courses 
    WHERE CID = NEW.CID;

    -- Insert into Activity_Log with detailed course title
    INSERT INTO Activity_Log (user_type, user_name, action, details)
    VALUES (
        'Learner',
        learnerName,
        'COURSE_JOINED',
        CONCAT('Joined in course "', courseTitle, '"')
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `learner`
--

CREATE TABLE `learner` (
  `LID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `language` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learner`
--

INSERT INTO `learner` (`LID`, `name`, `password`, `email`, `language`) VALUES
(1, 'Aye', 'Ma3Tfz2BdrOLWOEhKMOdDQ==', 'aye@mail.com', 'Japanese'),
(2, 'Kyaw Kyaw', 'SiCS8i40BYXUMQnz4Yaknw==', 'kyawkyaw@mail.com', 'English');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `LessonID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`LessonID`, `CID`, `title`, `file_path`, `description`, `uploaded_at`) VALUES
(1, 1, '自動販売機について', 'uploads/1770278410_自動販売機.oga', 'みなさん、こんにちは。あかねです。\r\n\r\n自動販売機について話してほしいというリクエストをいただいたので、今日は日本のいろいろな自動販売機について紹介したいと思います。\r\n\r\nmadorizukiさん、リクエストありがとうございます。\r\n\r\n自動販売機のことを省略して自販機といいます。\r\n\r\nみなさんの国にはどんな自販機がありますか？\r\n\r\n自販機といえば、1番最初に思いつくのは飲み物の自販機だと思います。\r\n\r\n日本では冬になると温かい飲み物が自販機で買えるんですが、お茶や水だけではなく、みそ汁やコーンスープなども売っています。\r\n\r\n写真をBLOGに貼っておくので是非見てください。\r\n\r\nあと私が好きなのはアイスクリームが売っている自販機です。\r\n\r\n日本に住んでいる人なら、見たことがあるかもしれません。\r\n\r\nセブンティーンアイスという名前です。\r\n\r\nけっこういろんな場所にあって、例えば電車の駅やショッピングモール、温泉施設などにあります。\r\n\r\n値段はアイスの種類によってちがいますが、140円～200円くらいです。\r\n\r\n私は子供のころスイミングスクール、水泳教室に通っていたのですが、その場所の近くにセブンティーンアイスの自販機があって、よく帰りに買ってもらったのを覚えています。\r\n\r\nあと珍しい自販機なら、「だし職人」という自販機もありますよ。\r\n\r\nホームページを貼っておきますね。http://www.dashisyokunin.jp/\r\n\r\n「出汁(だし)」は和食を作る時によく使います。\r\n\r\n私はみそ汁を作る時にいつも使います。\r\n\r\nこれは日本ならではの自販機ですね。調べたところ、東京・千葉・神奈川にしかないようです。\r\n\r\nあと最近見かけたのは、Blue Bottle Coffeeというコーヒーのお店がだしている自販機です。\r\n\r\n缶コーヒーだけではなくて、コーヒー豆も売っていました。\r\n\r\nitalkiの生徒さんが教えてくれたのですが、ある国では自販機があってもほとんどの人が利用しないと言っていました。\r\n\r\nその理由は、よく壊れるしお金を入れても商品がでてこないことがあるから、と言っていました。\r\n\r\nこれは私も海外旅行へ行ったとき、何回か経験したことがあります。\r\n\r\n１つの国じゃなくて、いくつかの国で経験しました。\r\n\r\nお金を入れても反応がなかったり、おつりがでてこなかったりしたことがあります。\r\n\r\nだから、あまり自販機を利用しないという理由がよくわかりました。\r\n\r\n日本では自販機を利用する人は多いと思いますし、私もよく利用します。\r\n\r\nみなさんの国にはどんな自販機がありますか？\r\n\r\nもし日本人と話す時や会話レッスンの話題で悩んでいる人がいたら、こういうテーマもおもしろいかもしれませんよ。\r\n\r\nいつも日本語の聴解のためのPodcastを聞いてくださってありがとうございます。\r\n\r\nPodcastを続けるためにbuy me a coffeeで応援していただけると嬉しいです。\r\n\r\nよろしくお願いいたします。\r\n\r\n☆漢字の読み方\r\n\r\n自動販売機：じどうはんばいき\r\n\r\n省略：しょうりゃく\r\n\r\n水泳：すいえい\r\n\r\n和食：わしょく\r\n\r\n反応：はんのう\r\n\r\n壊れる：こわれる　(自動詞：壊れる　　他動詞：壊す)\r\n\r\n話題：わだい\r\n\r\n悩む：なやむ\r\n\r\n今日はここまでです。\r\n\r\nバイバーイ！', '2026-02-05 08:00:10'),
(2, 2, 'A Day in My Life', 'uploads/1770278557_A Day in My Life.m4a', 'Every day I wake up at 7:00 in the morning. Not too early, not too late.\r\nJust Perfect for me. I turn off my alarm clock and stretch my arms.\r\nThen I say to myself, it\'s a new day. Sometimes I feel sleepy, but I try to start my day with a smile.\r\nCan you repeat after me? It\'s a new day. Great job. After that, I go to the bathroom to wash my face and brush my teeth.\r\nI love cold water in the morning. It helps me wake up. Then I take a quick shower. Just 10 minutes.\r\nDo you take a shower in the morning or at night? Nice. Everyone has their own routines.\r\nAfter my shower, it\'s breakfast time. I usually eat toast with butter and honey and I make a cup of coffee.\r\nUmm... The smell of coffee makes me feel awake and happy.\r\nUmm... It\'s delicious and warm. Sometimes I eat eggs or yogurt with fruit.\r\nWhat about you? What do you like for breakfast?\r\nVery good. Breakfast gives us energy for the day.\r\nAfter breakfast, I sit at my desk and check my schedule.\r\nI work from home, so I turn on my computer and check my emails first.\r\nThen I make a to-do list. I write things like check record podcast, answer message, prepare lesson.\r\nDo you write to-do lists too? That\'s awesome.\r\nTo-do lists help me stay organized.\r\n9:00 AM to 12:00 PM, I work on my podcast and Youtube videos.\r\nI write scripts, record my voice, and sometimes I edit videos. It takes time, but I love it. \r\n12:30PM, I make lunch. Today, I cooked Rice with Vegetables and some chicken.\r\nI also had a small salad on the side.\r\nAfter lunch, I usually take a short break. I sit on the balcony, drink some tea and breathe fresh air. \r\nDo you take breaks during the day? Taking breaks is important for our health.\r\nIn the afternoon, I continue working or sometimes read a book.\r\nI love reading books in English to learn new words. \r\nRight now, I\'m reading a book about traveling around the world. It\'s very exciting.\r\nDo you like reading? What kind of books do you like? Cool. Reading is great for learning.\r\nAt 5PM, I go for a short walk outside. There\'s a small park near my home. \r\nI walk, listen to music and enjoy the sunset. The sky becomes orange and pink. So beautiful.\r\nAt 7:00 PM, I prepare dinner. I try to eat healthy food like soup, vegetables or grilled fish.\r\nAfter dinner, I wash the dishes, clean the kitchen, and then relax at 8:30 PM, I sit on the couch and watch a series on Netflix. Right now, I\'m watching a comedy show.\r\nIt makes me laugh a lot. What do you like to watch int the evening?\r\nFinally, at around 10:00 PM.  I get ready for bed. I brush my teeth, wash my face, and read a few pages of my book. Then I turn off the light, close my eyes, and I say, thank you for today. And that\'s a day in my life. \r\nNow let\'s do a quick recap of some words we learned today.\r\nWake up, Take a shower, Eat breakfast, Work from home, Take a break, Go for a walk, Watch a show, Go to bed, can you try making you own day in the life?\r\nYou can write about it. Try speaking out loud. You can even record yourself. It\'s ok if you make mistakes.\r\nThe most important thing is practice. \r\nRemember, the more you listen, the more you understand. \r\nSo come back and listen to this episode again later.\r\nThank you for listening. I hope you enjoyed this episode and learned something new.', '2026-02-05 08:02:37'),
(3, 3, 'Why Korean Cafe are the Best', 'uploads/1770278735_Why Korean Cafes Are the Best.m4a', '저는 한국어 2급 수업을 듣고 있는 마이클이라고 합니다. 미국에서 왔습니다.\r\n\r\n직업은 회사원이고 한국에 온 지 1년이 되었습니다. 지금부터 우리 반 친구들에 대해서 소개하려고 합니다.\r\n\r\n우리 반 친구들은 중국, 일본, 러시아, 네덜란드, 베트남, 미국에서 왔습니다.\r\n\r\n중국에서 온 장소이 씨는 한국 노래를 잘하고 춤도 잘 춥니다. 우리 반 가수입니다.\r\n\r\n이치로 씨는 일본에서 왔습니다. NHK 기자입니다. 기타를 아주 잘 칩니다.\r\n\r\n나타샤 씨는 러시아에서 온 주부입니다. 남편은 러시아 사람이 아니라 한국 사람 입니다.\r\n\r\n얀 씨는 네덜란드 사람입니다. 네덜란드의 대학교에서 아시아 역사를 공부하고 있습니다. 얀 씨는 키가 크고 잘생겨서 우리 반 여학생들에게 인기가 많습니다.\r\n\r\n하이안 씨는 베트남에서 왔습니다. 학교 기숙사에서 삽니다. 그런데 멀리 사는 장소이 씨보다 지각을 많이 해서 지각 대장이라고 부릅니다.\r\n\r\n우리 반 친구들은 공부도 열심히 하고 서로 잘 도와줍니다. 또 수업 후에는 식 사도 같이 하고 숙제도 같이 합니다. 그래서 저는 우리 반 친구들이 좋습니다. 좋은 친구들이 있어서 학교생활도 즐겁습니다.\r\n\r\n저는 한국어 2급 수업을 듣고 있는 마이클이라고 합니다. 미국에서 왔습니다.\r\n\r\n직업은 회사원이고 한국에 온 지 1년이 되었습니다. 지금부터 우리 반 친구들에 대해서 소개하려고 합니다.\r\n\r\n우리 반 친구들은 중국, 일본, 러시아, 네덜란드, 베트남, 미국에서 왔습니다.\r\n\r\n중국에서 온 장소이 씨는 한국 노래를 잘하고 춤도 잘 춥니다. 우리 반 가수입니다.\r\n\r\n이치로 씨는 일본에서 왔습니다. NHK 기자입니다. 기타를 아주 잘 칩니다.\r\n\r\n나타샤 씨는 러시아에서 온 주부입니다. 남편은 러시아 사람이 아니라 한국 사람 입니다.\r\n\r\n얀 씨는 네덜란드 사람입니다. 네덜란드의 대학교에서 아시아 역사를 공부하고 있습니다. 얀 씨는 키가 크고 잘생겨서 우리 반 여학생들에게 인기가 많습니다.\r\n\r\n하이안 씨는 베트남에서 왔습니다. 학교 기숙사에서 삽니다. 그런데 멀리 사는 장소이 씨보다 지각을 많이 해서 지각 대장이라고 부릅니다.\r\n\r\n우리 반 친구들은 공부도 열심히 하고 서로 잘 도와줍니다. 또 수업 후에는 식 사도 같이 하고 숙제도 같이 합니다. 그래서 저는 우리 반 친구들이 좋습니다. 좋은 친구들이 있어서 학교생활도 즐겁습니다.\r\n\r\n수업-Class\r\n직업-Occupation/Job\r\n소개하다-Introduce\r\n노래하다-Sing\r\n춤을 추다-Dance\r\nNHK-Japan Broadcasting Corporation\r\n기자-Journalist\r\n기타 치다-Play guitar\r\n주부-Housewife\r\n남편-Husband\r\n아시아 역사-Asian history\r\n인기가 많다-Popular\r\n기숙사-Dormitory\r\n멀리-Far\r\n지각 대장-Habitually late person / latecomer\r\n부르다-To call\r\n식사하다-Have a meal/Eat\r\n숙제하다-Do homework\r\n학교생활-School life', '2026-02-05 08:05:35'),
(4, 1, 'おいしくてもいかない店', 'uploads/1770278992_おいしくてもいかない店.oga', 'みなさん、こんにちは。あかね的日本語教室のあかねです。\r\n\r\nみなさんは好きな店がありますか？\r\n\r\nよく行く店はありますか？\r\n\r\nそれはどんな店ですか？\r\n\r\n私にも大好きな店があります。1か月に1度は行くカフェやレストランがあります。\r\n\r\n料理もおいしいし、お店の人もやさしいし、雰囲気がとてもいいので好きです。\r\n\r\nでも、どんなに料理がおいしくても、2度と行きたくないと思うお店もあります。\r\n\r\n「2度と～ない」というのは、「絶対に～ない」「2回目はない」という意味です。\r\n\r\nつまり「その店に絶対行きたくない」「次回は絶対に行かない店」という意味です。\r\n\r\n私が2度と行きたくないと思う店は、どんなお店だと思いますか？\r\n\r\n料理がおいしいなら、ふつうはまた行きたいと思いますよね。\r\n\r\nそれなのに行きたくないと思う店です。\r\n\r\nそれは、お店のスタッフ、店員さんの態度がすごく悪い店です。\r\n\r\n例えば「いらっしゃいませ」や「ありがとうございます」を言わなかったり、お店の店員さん同士がけんかをしたり、お客さんの前で怒ったりする店です。\r\n\r\n日本にはこのような店は少ないと思います。でもあります。\r\n\r\n１つの例を紹介しますね。\r\n\r\n家族で経営しているお店に行ったときの話です。\r\n\r\nその家族のお父さんが料理を作って、そのお父さんの子供がお客さんに料理を運んでいました。\r\n\r\nでもその子供はお客さんが注文したものとはちがう料理を運んでしまいました。\r\n\r\nお客さんは全然怒っていませんでした。でもそのお父さんは、店の中にいる全員がきこえるくらい大きな声で子供を叱りました。\r\n\r\n私がごはんを食べ終わったあとも、ずっとそのお父さんは怒っている様子で、本当に怖かったです。\r\n\r\n店員さんが失敗しても、そのときは少しだけ注意して、お店の営業がおわったらちゃんと指導(しどう)すればいいと思います。\r\n\r\nその店の料理はおいしかったけど、雰囲気がすごくわるかったので、私はその店で食べたことを後悔しました。\r\n\r\nお店の店員さんはすごく大変だと思います。特に日本では接客マナーがきびしいので、少しでも店員さんの態度が悪いと怒るお客さんもいるし、態度が悪いお客さんもいます。\r\n\r\n私がお店でご飯を食べるのは、おいしいものを食べたいと思うのはもちろんですが、すてきなお店にいって気分をかえたいと思ったり、リラックスしたいと思うことも多いです。\r\n\r\nだから店員さんの態度がすごく悪かったら、もう行きたくないと思います。\r\n\r\nみなさんはどう思いますか？\r\n\r\nおいしい料理だったら、お店の人の態度がどんなに悪くても、またその店に行きたいと思いますか？\r\n\r\nPodcastのエピソードの募集はPatreonで行っています。\r\n\r\n興味がある人は参加してください。\r\n\r\n☆漢字の読み方\r\n\r\n態度：たいど\r\n\r\n叱る：しかる\r\n\r\n接客：せっきゃく\r\n\r\n後悔：こうかい\r\n\r\nおまけの話\r\n\r\n言動：げんどう\r\n\r\n違和感：いわかん', '2026-02-05 08:09:52'),
(5, 1, '私の好きな曲', 'uploads/1770279035_私の好きな曲.oga', 'みなさん、こんにちは。あかねです。\r\n\r\n今回は私の好きな曲を紹介したいと思います。\r\n\r\nリクエストしてくれたオンさんとハニーさん、ありがとうございます！\r\n\r\nYouTubeでも紹介したことがあるんですが、2019年から藤井風(ふじいかぜ)さんにハマっています。\r\n\r\nハマるというのは「とても好きで夢中になる」という意味です。\r\n\r\n藤井風さんはピアノを弾きながら歌うんですが、ピアノのメロディーも歌声もとても魅力的で、聞くと癒されます。\r\n\r\n特に好きなのは「何なんw」という曲です。\r\n\r\n藤井風さんは岡山県(おかやまけん)出身で、この曲の歌詞には岡山弁(おかやまべん)も使われています。\r\n\r\n blogにこの曲のオフィシャルビデオをはっておくので聞いてみてください。\r\n\r\nこれから紹介する曲もYouTubeのリンクを貼っておきますね。\r\n\r\n次に紹介するのはYOASOBIさんの「夜に駆(か)ける」です。\r\n\r\nこれを初めて聞いたときに衝撃を受けました。\r\n\r\n本当に人間が歌っているのか疑ってしまうほど、歌うのが難しい曲だと思います。\r\n\r\nメロディーの高低差(こうていさ)が激しい、つまり、高い音と低い音の差が激しいですし、息を吸う暇もないくらい速いところがあります。\r\n\r\nでもこれもメロディーがとてもきれいで、何度も繰り返し聞きたくなる曲です。\r\n\r\n是非聴いてみてください。\r\n\r\n最後に紹介するのはRIRIさんです。\r\n\r\n彼女は16歳から本格的に歌手活動をしています。\r\n\r\n彼女の歌声は迫力や強さがある一方(いっぽう)で、優しさも感じるきれいな歌声だと思います。\r\n\r\n私はRIRIさんが歌う高音のメロディーがとても好きです。\r\n\r\n特に好きなのは「That’s My Baby」 と「RUSH」という曲です。\r\n\r\n私にとってとても元気をもらえる曲です。\r\n\r\n今日紹介した中にみなさんが知っている曲もあったかもしれません。\r\n\r\n私は日本だけじゃなくて、他の国の曲もよくききます。\r\n\r\nまた機会があれば紹介しようかなぁと思います。\r\n\r\n全然関係ありませんが、実は昨日私のYouTubeチャンネル「あかね的日本語教室」の登録者数が10万人になりました！\r\n\r\nPodcastを聞いている方の中には、私のチャンネルを登録してくれている方もいると思うので、お礼を言わせてください。\r\n\r\nまさか3年間で10万人になるなんて思ってもいませんでした。\r\n\r\nこの3年間で何回もやめようと思いましたが、みなさんのおかげで続けることができました。\r\n\r\n心から感謝しています。ありがとうございます。\r\n\r\nそしてこれからもよろしくお願いします。\r\n\r\n(Podcastを更新することでお金をもらっていません。更新を続けるためにbuy me a coffeeで応援していただけると嬉しいです！)\r\n\r\n⭐︎漢字の読み方\r\n\r\n歌手：かしゅ\r\n\r\n歌詞：かし\r\n\r\n夢中：むちゅう\r\n\r\n魅力的：みりょくてき\r\n\r\n癒す：いやす\r\n\r\n衝撃：しょうげき\r\n\r\n疑う：うたがう\r\n\r\n息を吸う：いきをすう\r\n\r\n繰り返す：くりかえす\r\n\r\n本格的：ほんかくてき\r\n\r\n迫力：はくりょく\r\n\r\n今日はここまでです。\r\n\r\nありがとうございました。\r\n\r\nバイバーイ！', '2026-02-05 08:10:35'),
(6, 4, 'Travel', 'uploads/1770280182_Travel.oga', 'I love traveling. It is one of my favorite hobbies.\r\nI love to travel because I can learn a lot about other cultures.\r\nI can see new places and try different food.\r\nTraveling is great for relaxing.\r\nWhen people travel they forget about their work and their daily life.\r\nThey aren\'t stressed when they are traveling. So it is more relaxing than being at home.\r\n\r\nYou can spend time at the beach in the mountains or even walking around a city.\r\nDifferent experiences are relaxing for different people.\r\nI like going for a walk in the mountains to relax.\r\nI like seeing the green forests and the animals in nature.\r\nTraveling is the best way to learn about other countries.\r\n\r\nYou can go to museums to learn about the history and art of that country.\r\nIt is more interesting than reading a book about history or art.\r\nYou can experience the history of the place.\r\nPeople can visit museums and walk around the city center to look at the buildings and monuments.\r\nIt is very interesting to learn about the city or the country because then you can understand more about the culture.\r\n\r\nIt is also amazing to travel because you can create new memories.\r\nSome people like to travel alone but others prefer to travel with their friends their family or their partner.\r\nIt is great to take photographs during your holiday to remember those moments forever.\r\nMy best travel memories are discovering new places, eating at a nice restaurant and relaxing in nature.\r\nWhat is your favorite memory that you have from your travels?\r\n\r\nYou can meet a lot of new people when you are on holiday.\r\nI think that when people are on holiday they are very friendly.\r\nSo it is easy to meet other people that are traveling too.\r\nAlso you can meet local people who live in that country.\r\nIt is a good idea to learn how to say basic phrases in the language that they speak in that country.\r\nFor example, thank you, good morning, goodbye.\r\nIt is difficult to learn to speak the language just for a holiday but I think that it is a good way to be respectful and friendly.\r\n\r\nIt is also a good experience to try the local cuisine.\r\nThe cuisine is the style of cooking of a country.\r\nFor example, if you visit Spain, you can try some baida or a Spanish omelette.\r\nIt is totally different to the bias that they sell in England.\r\nI know that there are a lot more typical foods but these are just some typical examples.\r\nI like going to restaurants when I am on holiday because you can try food that you don\'t normally eat.\r\n\r\nWhen you are at home, it is a good idea to ask the waiter at the restaurant.\r\nWhat food he thinks is the best on the menu because sometimes when you go to a restaurant in a different country, you don\'t understand the menu what is the best food that you have tried on holiday.\r\nNow we are going to go with the questions.\r\nI want you to write the answers in the comment box and I will correct them.\r\n\r\nThe first question is what countries have you visited?\r\nI have visited a lot of countries in Europe.\r\nI would say that I have visited about 10 countries in Europe but I would like to go to America one day and discover some places in Asia.\r\nEspecially the places that have nice beaches.\r\n\r\nThe second question is what is your favorite memory that you have from your travels?\r\nI think that my favorite memory that I have from my travels is being at the beach when the sun is going down.\r\nSo at eight or nine o\'clock in the summer, the beach is beautiful.\r\nThe Sun is going down and it is very relaxing.\r\n\r\nThe third question is what is your favorite thing to do on your travels.\r\nMy favorite thing to do on my travels is to go for long walks in nature.\r\nI prefer the mountains to the beach.\r\nI think that it is more interesting and exciting to be active.\r\nWhen you are on the beach, you are sitting down a lot of the time and I think that it is more boring.\r\n\r\nAnd the final question is what is the best food that you have tried on holiday?\r\nI think that the best food that I have tried on holiday is a pizza that I had when I went to Rome.\r\nIt was delicious and it is the best pizza I have ever eaten.\r\nSo do the same as me.\r\n\r\nAnswer the questions and write them in the comment box so that I can correct them.\r\nThank you very much and I\'ll see you in the next video...', '2026-02-05 08:29:42'),
(7, 5, '父の日のプレゼント', 'uploads/1770280514_父の日のプレゼント.m4a', 'みなさん、こんにちは。あかねです。\r\n\r\n今日のテーマはお金についてです。\r\n\r\nこれは私が日本語の授業をしているときによく学生に聞く質問です。\r\n\r\n読解や聴解の問題にはときどきお金の使い方に関する内容があります。\r\n\r\nたとえば経済や節約に関する問題です。私はただ問題の答えを言うだけじゃなくて、学生にどのように考えるかを話してもらうことが多いです。\r\n\r\n例えば\r\n\r\n「もし宝くじがあたって(当たる)、今1億円あるとしたら何を買いますか？」\r\n\r\nとか、今回のエピソードのテーマ\r\n\r\n「いくらあったら満足できますか？」などです。\r\n\r\nいつもいろんな答えがあるし、「なるほど〜」と思うことも多いです。\r\n\r\n私がこういうことを質問する目的は、学生に今まで勉強した文法や単語を使って話してほしいからです。\r\n\r\nみなさんはどうですか？\r\n\r\n今１億円あったら、何を買いたいですか？何をしたいですか？\r\n\r\n3年前くらいに教えていた学生は「プライベートジェット」がほしいと言っていました。\r\n\r\nプライベートジェットというのは自分専用の飛行機のことです。\r\n\r\nあとは「学校を買いたい」という人もいました。理由もいっしょに聞いてみるとけっこう盛り上がります。\r\n\r\nこの前「いくらあったら満足できますか？」と学生にきいたとき、\r\n\r\n「いくらあっても満足できない」とか、「あればあるほどいい」という答えがでてきて、とてもおもしろかったし、「～ば～ほど」の文法を使って話すことができたので、とてもよかったです。\r\n\r\nこのテーマはちゃんと考えたら、真剣に考えたらけっこう深いテーマですよね。\r\n\r\nいくらあったら満足できるのかというのは、どういう生活をしたいのかによって全然ちがいますよね。\r\n\r\n例えば東京の一等地にある家を買って、毎日豪遊する生活をしたいなら、お金がいくらあっても足りません。「一等地」というのは、簡単にいうと一番いい土地、条件がいい土地のことです。\r\n\r\n「豪遊する」というのはお金をたくさん使って遊ぶ、という意味です。\r\n\r\nそんな生活は1億円じゃ何年も続けることができないと思います。\r\n\r\nでも、田舎にある安い家を買って、自給自足の生活をするなら、そんなにお金は必要ないかもしれません。\r\n\r\n「自給自足」というのは、たとえば自分のために野菜や果物を育てて、それを食べて生活することです。\r\n\r\nみなさんはどんな生活がしたいですか？\r\n\r\nちなみに、私はもし宝くじで1億円当たったとしても、日本語を教える仕事をやめたくないです。\r\n\r\nみなさんはどうですか？もし1億円当たったら、今の仕事をすぐにやめますか？\r\n\r\nPodcastのエピソードの募集はPatreonで行っています。\r\n\r\n興味がある人は参加してください。\r\n\r\n☆漢字の読み方\r\n\r\n経済：けいざい\r\n\r\n節約：せつやく\r\n\r\n宝くじ：たからくじ\r\n\r\n一等地：いっとうち\r\n\r\n豪遊：ごうゆう\r\n\r\n自給自足：じきゅうじそく\r\n\r\n条件：じょうけん', '2026-02-05 08:35:14');

--
-- Triggers `lessons`
--
DELIMITER $$
CREATE TRIGGER `after_lesson_delete` AFTER DELETE ON `lessons` FOR EACH ROW BEGIN
   DECLARE tutorName VARCHAR(150);
   DECLARE courseTitle VARCHAR(255);

   -- Find tutor who owned the course
   SELECT t.name, c.Title
   INTO tutorName, courseTitle
   FROM TCA tc
   JOIN Tutor t ON tc.TID = t.TID
   JOIN Courses c ON c.CID = tc.CID
   WHERE c.CID = OLD.CID
   LIMIT 1;

   INSERT INTO Activity_Log (user_type, user_name, action, details)
   VALUES ('Tutor', tutorName, 'LESSON_DELETED',
           CONCAT('Deleted lesson: ', OLD.Title, ' from course: ', courseTitle));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `popularcourses`
-- (See below for the actual view)
--
CREATE TABLE `popularcourses` (
`CID` int(11)
,`Title` varchar(50)
,`course_language` varchar(50)
,`tutor_name` varchar(100)
,`total_lessons` bigint(21)
,`total_enrollments` bigint(21)
,`avg_rating` decimal(7,4)
,`popularity_score` decimal(27,5)
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `RID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `LID` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `review` text DEFAULT NULL,
  `rate_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`RID`, `CID`, `LID`, `rating`, `review`, `rate_date`) VALUES
(1, 1, 1, 4, 'Your voice is so charming.', '2026-02-05 14:54:04'),
(2, 2, 2, 3, 'Amazing!!!!', '2026-02-05 15:06:42');

--
-- Triggers `ratings`
--
DELIMITER $$
CREATE TRIGGER `after_rating_insert` AFTER INSERT ON `ratings` FOR EACH ROW BEGIN
    DECLARE learnerName VARCHAR(150);
    DECLARE courseTitle VARCHAR(255);

    -- Get learner name
    SELECT name 
    INTO learnerName 
    FROM Learner 
    WHERE LID = NEW.LID;

    -- Get course title
    SELECT Title 
    INTO courseTitle 
    FROM Courses 
    WHERE CID = NEW.CID;

    -- Insert into Activity_Log with course title and rating
    INSERT INTO Activity_Log (user_type, user_name, action, details)
    VALUES (
        'Learner',
        learnerName,
        'COURSE_RATED',
        CONCAT('Rated course "', courseTitle, '" with ', NEW.rating)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tca`
--

CREATE TABLE `tca` (
  `TCID` int(11) NOT NULL,
  `TID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tca`
--

INSERT INTO `tca` (`TCID`, `TID`, `CID`, `assigned_at`) VALUES
(1, 1, 1, '2026-02-05 07:57:13'),
(2, 2, 2, '2026-02-05 08:02:06'),
(3, 3, 3, '2026-02-05 08:04:48'),
(4, 4, 4, '2026-02-05 08:29:04'),
(5, 5, 5, '2026-02-05 08:33:43');

--
-- Triggers `tca`
--
DELIMITER $$
CREATE TRIGGER `after_tca_delete` AFTER DELETE ON `tca` FOR EACH ROW BEGIN
   DECLARE tutorName VARCHAR(150);
   DECLARE courseTitle VARCHAR(255);

   -- Get tutor name
   SELECT name INTO tutorName FROM Tutor WHERE TID = OLD.TID;

   -- Get course title
   SELECT Title INTO courseTitle FROM Courses WHERE CID = OLD.CID;

   -- Insert log
   INSERT INTO Activity_Log (user_type, user_name, action, details)
   VALUES ('Tutor', tutorName, 'COURSE_DELETED', CONCAT('Deleted course: ', courseTitle));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_tca_insert` AFTER INSERT ON `tca` FOR EACH ROW BEGIN
   DECLARE tutorName VARCHAR(150);
   DECLARE courseTitle VARCHAR(255);

   SELECT name INTO tutorName FROM Tutor WHERE TID = NEW.TID;
   SELECT Title INTO courseTitle FROM Courses WHERE CID = NEW.CID;

   INSERT INTO Activity_Log (user_type, user_name, action, details)
   VALUES ('Tutor', tutorName, 'COURSE_CREATED', CONCAT('Created course: ', courseTitle));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `TID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`TID`, `name`, `password`, `email`) VALUES
(1, 'Yu Yu', 'icn4btMIuDJWWIg1sidJXQ==', 'yuyu@mail.com'),
(2, 'Gue Gue', 'QsZHbWw4+rr1ie41I5rt9A==', 'guegue@mail.com'),
(3, 'Honey', 'ThNRE97LRu0YlHn2tzXKBw==', 'honey@mail.com'),
(4, 'Thiha', 'ePpwLuzEhKtN+UKWuUZ+Og==', 'thiha@mail.com'),
(5, 'Nyein Thu', 'WUGDSvZvvg7rjSaj64fHxw==', 'nyeinthu@mail.com');

-- --------------------------------------------------------

--
-- Structure for view `popularcourses`
--
DROP TABLE IF EXISTS `popularcourses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `popularcourses`  AS SELECT `c`.`CID` AS `CID`, `c`.`Title` AS `Title`, `c`.`language` AS `course_language`, `t`.`name` AS `tutor_name`, count(distinct `l`.`LessonID`) AS `total_lessons`, count(distinct `e`.`EnID`) AS `total_enrollments`, coalesce(avg(`r`.`rating`),0) AS `avg_rating`, count(distinct `e`.`EnID`) * 0.7 + coalesce(avg(`r`.`rating`),0) * 0.3 AS `popularity_score`, `c`.`created_at` AS `created_at` FROM (((((`courses` `c` join `tca` `tc` on(`c`.`CID` = `tc`.`CID`)) join `tutor` `t` on(`tc`.`TID` = `t`.`TID`)) left join `lessons` `l` on(`c`.`CID` = `l`.`CID`)) left join `enrollment` `e` on(`c`.`CID` = `e`.`CID`)) left join `ratings` `r` on(`c`.`CID` = `r`.`CID`)) GROUP BY `c`.`CID`, `c`.`Title`, `c`.`language`, `t`.`name`, `c`.`created_at` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`LogID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`EnID`),
  ADD KEY `CID` (`CID`),
  ADD KEY `LID` (`LID`);

--
-- Indexes for table `learner`
--
ALTER TABLE `learner`
  ADD PRIMARY KEY (`LID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`LessonID`),
  ADD KEY `CID` (`CID`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`RID`),
  ADD KEY `CID` (`CID`),
  ADD KEY `LID` (`LID`);

--
-- Indexes for table `tca`
--
ALTER TABLE `tca`
  ADD PRIMARY KEY (`TCID`),
  ADD KEY `TID` (`TID`),
  ADD KEY `CID` (`CID`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`TID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `EnID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `learner`
--
ALTER TABLE `learner`
  MODIFY `LID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `LessonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tca`
--
ALTER TABLE `tca`
  MODIFY `TCID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tutor`
--
ALTER TABLE `tutor`
  MODIFY `TID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`CID`) REFERENCES `courses` (`CID`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`LID`) REFERENCES `learner` (`LID`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`CID`) REFERENCES `courses` (`CID`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`CID`) REFERENCES `courses` (`CID`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`LID`) REFERENCES `learner` (`LID`) ON DELETE CASCADE;

--
-- Constraints for table `tca`
--
ALTER TABLE `tca`
  ADD CONSTRAINT `tca_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `tutor` (`TID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tca_ibfk_2` FOREIGN KEY (`CID`) REFERENCES `courses` (`CID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
