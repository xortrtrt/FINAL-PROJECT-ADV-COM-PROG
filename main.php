<?php
session_start(); // Start the session
include ('config.php');
// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user information from the session
$username = $_SESSION['username'];

//fetch course information from the database
$sql = "SELECT course_name, description FROM courses";
$sql = "SELECT course_name, description, image_path FROM courses";
$result = $conn->query($sql);



?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="main.css" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    
</head>
<body>
    <header>
        <h2 <strong><?php echo htmlspecialchars($username); ?> </h2>
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
        // Check if courses exist
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<img src="' . htmlspecialchars($row["image_path"]) . '" alt="' . htmlspecialchars($row["course_name"]) . '">';
                echo '<h2>' . htmlspecialchars($row["course_name"]) . '</h2>';
                echo '<p>' . htmlspecialchars($row["description"]) . '</p>';
                echo '</div>';
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
