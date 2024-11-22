<?php
session_start(); // Start the session

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user information from the session
$username = $_SESSION['username'];
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
      <div class="card">
        <h2>PHP</h2>
        <img src="/CSS PICS/php.jpg" alt="PHP" />
        <p>Learn PHP concepts and applications.</p>
      </div>
      <div class="card">
        <h2>Web Development</h2>
        <img src="/CSS PICS/web-development1.png" alt="Island" />
        <p>A beginner-friendly guide to web development.</p>
      </div>
      <div class="card">
        <h2>Java OOP</h2>
        <img src="/CSS PICS/Java-Logo.png" alt="Nature" />
        <p>An introduction to Java.</p>
      </div>
      <div class="card">
        <h2>AI and Machine Learning</h2>
        <img src="/CSS PICS/AI_part_1.jpg" alt="Mount Fuji" />
        <p>Dive into artificial intelligence and machine learning.</p>
      </div>
      <div class="card">
        <h2>DBMS</h2>
        <img src="/CSS PICS/dbms.png" alt="Sunrise" />
        <p>Learn the basics and advanced applications of DBMS</p>
      </div>
      
  </section>
    </main>
</body>
</html>
