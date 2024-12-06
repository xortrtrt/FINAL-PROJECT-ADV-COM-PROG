<?php
session_start(); 
require_once('crudDatabase.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
if ($course_id === 0) {
    echo "Invalid course ID.";
    exit();
}

$crud = new CrudDatabase();
$course = $crud->getCourseById($course_id); 

if (!$course) {
    echo "Course not found.";
    exit();
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/course_details.css" type="text/css">
    <title><?php echo htmlspecialchars($course['course_name']); ?> - Course Details</title>
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
        <h2><?php echo htmlspecialchars($course['course_name']); ?></h2>
        <img class="course-image" src="<?php echo htmlspecialchars($course['image_path']); ?>" alt="<?php echo htmlspecialchars($course['course_name']); ?>">
        <p class="course-description"><?php echo htmlspecialchars($course['description']); ?></p>
        </section>
        <!-- Enroll Button -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST" action="enroll.php" class="center-form">
    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
    <button type="submit">Enroll in this Course</button>
</form>

        <?php else: ?>
            <p>Please <a href="login.php">log in</a> to enroll in this course.</p>
        <?php endif; ?>
    </main>
</body>
</html>
