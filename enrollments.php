<?php
session_start();
require_once('crudDatabase.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

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
</head>
<body>
    <header>
        <h2><strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></h2>
        <h1>My Enrollments</h1>
        <div class="dropdown">
            <button class="dropdown-toggle">▼</button>
            <div class="dropdown-menu">
                <a href="profile.php">View Profile</a>
                <a href="main.php">Main Page</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <main>
        <section>
            <h1>Enrolled Courses</h1>
            <div class="card-container">
                <?php
                if ($courses) {
                    foreach ($courses as $course) {
                        echo '<div class="card">';
                        echo '<img src="' . htmlspecialchars($course['image_path']) . '" alt="' . htmlspecialchars($course['course_name']) . '">';
                        echo '<h2>' . htmlspecialchars($course['course_name']) . '</h2>';
                        echo '<p>' . htmlspecialchars($course['description']) . '</p>';
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
