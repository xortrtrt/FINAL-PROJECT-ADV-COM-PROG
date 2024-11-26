<?php

session_start(); 
require_once('crudDatabase.php');  

if (!isset($_SESSION['username'])) {
    echo "You need to be logged in to enroll in a course.";
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
</head>
<body>
    <header>
        <h1>Course Details</h1>
        <h2>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <div class="dropdown">
            <button class="dropdown-toggle">▼</button>
            <div class="dropdown-menu">
                <a href="main.php">Main Page</a>
                <a href="profile.php">View Profile</a>
                <a href="enrollments.php">My Enrollments</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <main>
        <h2><?php echo htmlspecialchars($course['course_name']); ?></h2>
        <img src="<?php echo htmlspecialchars($course['image_path']); ?>" alt="<?php echo htmlspecialchars($course['course_name']); ?>" style="max-width: 100%; height: auto;">
        <p><?php echo htmlspecialchars($course['description']); ?></p>
        
        <!-- Enroll Button -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST" action="enroll.php">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                <button type="submit">Enroll in this Course</button>
            </form>
        <?php else: ?>
            <p>Please <a href="login.php">log in</a> to enroll in this course.</p>
        <?php endif; ?>
    </main>
</body>
</html>
