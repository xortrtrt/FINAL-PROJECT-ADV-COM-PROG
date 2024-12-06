<?php
session_start();
require_once('crudDatabase.php');

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $crud = new CrudDatabase();
    $courseDetails = $crud->getCourseDetails($course_id);
    $topics = $crud->getCourseTopics($course_id); 
} else {
    header("Location: enrollments.php");
    exit();
}

$course_id = $_GET['course_id']; 
$user_id = $_SESSION['user_id']; 

// Handle unenrollment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unenroll'])) {
    $crud->unenrollFromCourse($user_id, $course_id);
    header("Location: enrollments.php"); // Redirect after unenrollment
    exit();
}

$crud = new CrudDatabase();
$courseDetails = $crud->getCourseDetails($course_id); 
$topics = $crud->getCourseTopics($course_id);  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/course_topics.css">
    <title>Course Topics</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arvo&display=swap" rel="stylesheet">
    <script>
        function loadTopicContent(topic_id) {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", `getTopicDescription.php?topic_id=${encodeURIComponent(topic_id)}`, true);

            xhr.onload = function () {
                const contentDiv = document.getElementById('topic-content');
                if (xhr.status === 200) {
                    try {
                        const data = JSON.parse(xhr.responseText);
                        contentDiv.innerHTML = `<p>${data.success ? data.content : "Error: " + data.content}</p>`;
                    } catch {
                        contentDiv.innerHTML = `<p class="error">Invalid response format.</p>`;
                    }
                } else {
                    contentDiv.innerHTML = `<p class="error">Failed to load content. Please try again.</p>`;
                }
            };

            xhr.onerror = function () {
                document.getElementById('topic-content').innerHTML = `<p class="error">Network error. Please try again later.</p>`;
            };

            xhr.send();
        }
    </script>
</head>
<body>
<header>
    <h1><?php echo htmlspecialchars($courseDetails['course_name']); ?> Topics</h1>
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
    <div class="topics-container">
        <ul class="topics-tabs" id="topics-tabs">
            <?php
            if ($topics) {
                foreach ($topics as $topic) {
                    echo '<li onclick="loadTopicContent(' . intval($topic['topic_id']) . ')">'
                        . htmlspecialchars($topic['topic_title']) . '</li>';
                }
            } else {
                echo "<p>No topics available for this course.</p>";
            }
            ?>
        </ul>
        <div class="topic-content" id="topic-content">
            <p>Select a topic to view details.</p>
        </div>
    </div>

    <!-- Unenroll Button -->
    <form method="POST" action="course_topics.php?course_id=<?php echo htmlspecialchars($course_id); ?>">
        <button type="submit" name="unenroll" class="unenroll-button">Unenroll from this course</button>
    </form>
</main>

</body>
</html>
