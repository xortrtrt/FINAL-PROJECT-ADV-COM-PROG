<?php
session_start();
require_once('crudDatabase.php'); 

if (!isset($_SESSION['user_id'])) {
    header("Location: enrollments.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['course_id'])) {
    $course_id = (int)$_POST['course_id'];

    $crud = new CrudDatabase();

    $enrollment = $crud->enrollUserInCourse($user_id, $course_id);

    if ($enrollment) {
        header("Location: enrollments.php");
        exit();
    } else {
        echo "You are already enrolled in this course. <a href='enrollments.php'>View your enrollments</a>";
    }
} else {
    echo "Invalid course ID.";
}
?>
