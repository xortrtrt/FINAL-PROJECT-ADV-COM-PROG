<?php
session_start(); 
include ('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$sql = "SELECT id, course_name, description, image_path FROM courses";  
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="main.css" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
</head>
<body>
    <header>
        <h2><strong><?php echo htmlspecialchars($username); ?> </strong></h2>
        <h1>Welcome to the Skill Development Portal</h1>
        <div class="dropdown">
            <button class="dropdown-toggle">▼</button>
            <div class="dropdown-menu">
                <a href="profile.php">View Profile</a>
                <a href="enrollments.php">My Enrollments</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>
    
    <main>
        <div class="progress-bar"></div>
        <section>
            <h1>Courses</h1>
            <div class="card-container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Retrieve course data
                        $course_id = $row["id"];  // Course ID for linking
                        $image_path = htmlspecialchars($row["image_path"]);
                        $course_name = htmlspecialchars($row["course_name"]);
                        $description = htmlspecialchars($row["description"]);

                        echo '<a href="course_details.php?id=' . $course_id . '" class="card-link">';
                        echo '<div class="card">';
                        echo '<img src="' . $image_path . '" alt="' . $course_name . '">';
                        echo '<h2>' . $course_name . '</h2>';
                        echo '<p>' . $description . '</p>';
                        echo '</div>';
                        echo '</a>';
                    }
                } else {
                    echo "<p>No courses available at the moment. Please check back later!</p>";
                }
                ?>
            </div>
        </section>
    </main>
</body>
</html>
