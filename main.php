<?php
session_start();
require_once('crudDatabase.php'); 

$crud = new CrudDatabase();

$courses = $crud->getAllCourses();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Main Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css"> 
    <link href="https://fonts.googleapis.com/css?family=Arvo&display=swap" rel="stylesheet"> 
</head>
<script>
    function searchCourses() {
    const searchQuery = document.getElementById("searchInput").value;
    const xhr = new XMLHttpRequest();

    xhr.open("POST", "search_courses.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        const cardContainer = document.getElementById("courseCardContainer");
        cardContainer.innerHTML = "";

        if (xhr.status === 200) {
            const courses = JSON.parse(xhr.responseText);
            if (courses.length > 0) {
                courses.forEach(course => {
                    cardContainer.innerHTML += `
                        <div class="card">
                            <a href="course_details.php?course_id=${course.course_id}">
                                <img src="${course.image_path}" alt="${course.course_name}">
                                <h2>${course.course_name}</h2>
                                <p>${course.description}</p>
                            </a>
                        </div>`;
                });
            } else {
                cardContainer.innerHTML = "<p>No courses found.</p>";
            }
        } else {
            cardContainer.innerHTML = "<p>Error loading courses. Please try again.</p>";
        }
    };

    xhr.send(`query=${encodeURIComponent(searchQuery)}`);
}



    </script>
<body>
    <header>
        <h1>WELCOME TO SKILL DEVELOPMENT PORTAL</h1>
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
        <h2>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <div class="search-container">
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Search courses..." 
                oninput="searchCourses()" 
                class="search-bar"
            />
            <button onclick="searchCourses()" class="search-button">Search</button>
        </div>
        <section>
            <h1>Available Courses</h1>
            <div id="courseCardContainer" class="card-container">
    <?php
    if ($courses) {
        foreach ($courses as $course) {
            echo '<a href="course_details.php?course_id=' . urlencode($course['course_id']) . '" class="card">';
            echo '<img src="' . htmlspecialchars($course['image_path']) . '" alt="' . htmlspecialchars($course['course_name']) . '">';
            echo '<h2>' . htmlspecialchars($course['course_name']) . '</h2>';
            echo '<p>' . htmlspecialchars($course['description']) . '</p>';
            echo '</a>';
        }
    } else {
        echo "<p>No courses available at the moment.</p>";
    }
    ?>
</div>

        </section>
    </main>
</body>
</html>
