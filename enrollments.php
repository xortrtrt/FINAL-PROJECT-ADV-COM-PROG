<?php
session_start();
require_once('crudDatabase.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$crud = new CrudDatabase();
$courses = $crud->getUserEnrollments($user_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/enrollments.css">
    <title>My Enrollments</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css"> 
    <link href="https://fonts.googleapis.com/css?family=Arvo&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <h1>COURSE ENROLLMENT</h1>
    <nav role="navigation" class="primary-navigation">
        <ul>
            <li><a href="main.php">Home</a></li>
            <li><a href="profile.php">Profile &dtrif;</a>
                <ul class="dropdown">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </li>
            <li><a href="enrollments.php">Enrollments</a></li>
        </ul>
    </nav>
</header>

<main>
<section>
        
        <h1>Enrolled Courses</h1>
        <div class="card-container" id="courseCardContainer">
            <?php
            if ($courses) {
                foreach ($courses as $course) {
                    echo '<div class="card">';
                    echo '<a href="course_topics.php?course_id=' . urlencode($course['course_id']) . '">';
                    echo '<img src="' . htmlspecialchars($course['image_path']) . '" alt="' . htmlspecialchars($course['course_name']) . '">';
                    echo '<h2>' . htmlspecialchars($course['course_name']) . '</h2>';
                    echo '<p>' . htmlspecialchars($course['description']) . '</p>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>You are not enrolled in any courses yet.</p>";
            }
            ?>
        </div>
    </section>
</main>
</body>
</html>
