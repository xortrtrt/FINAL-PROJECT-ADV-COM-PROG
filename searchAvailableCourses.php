<?php
session_start();
require_once('crudDatabase.php');

$crud = new CrudDatabase();
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$courses = $crud->searchAvailableCourses($searchTerm);

if ($courses) {
    foreach ($courses as $course) {
        echo '<a href="course_details.php?course_id=' . urlencode($course['course_id']) . '" class="card">';
        echo '<img src="' . htmlspecialchars($course['image_path']) . '" alt="' . htmlspecialchars($course['course_name']) . '">';
        echo '<h2>' . htmlspecialchars($course['course_name']) . '</h2>';
        echo '<p>' . htmlspecialchars($course['description']) . '</p>';
        echo '</a>';
    }
} else {
    echo "<p>No available courses found for search term: " . htmlspecialchars($searchTerm) . "</p>";
    error_log("No courses found for search term: " . $searchTerm);
}
?>
