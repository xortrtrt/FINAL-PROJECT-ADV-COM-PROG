<?php
session_start();
require_once('crudDatabase.php'); // Include your CrudDatabase class

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: enrollments.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if course_id is dfound
if (isset($_POST['course_id'])) {
    $course_id = (int)$_POST['course_id'];

    $crud = new CrudDatabase();

    // Enroll the user in the course
    $enrollment = $crud->enrollUserInCourse($user_id, $course_id);

    if ($enrollment) {
        // Redirect to the enrollments page after successful enrollment
        header("Location: enrollments.php");
        exit();
    } else {
        echo "You are already enrolled in this course. <a href='enrollments.php'>View your enrollments</a>";
    }
} else {
    echo "Invalid course ID.";
}
?>
