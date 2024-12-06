<?php
session_start();
require_once('crudDatabase.php');
$crud = new CrudDatabase();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username']; 
$userDetails = $crud->getUserDetails($user_id);

if (!$userDetails) {
    echo "Error fetching user details.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_email'])) {
        $newEmail = $_POST['email'];
        $message = $crud->updateUserEmail($user_id, $newEmail, null);  
        echo "<p>$message</p>";
    } 

    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/profile.css">
    <title>Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arvo&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <h1>Profile Page</h1>
    <nav role="navigation" class="primary-navigation">
        <ul>
            <li><a href="main.php">Home</a></li>
            <li><a href="enrollments.php">Enrollments</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="profile-container">
        <h2>Your Profile</h2>
        <div class="profile-details">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($userDetails['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userDetails['email']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($userDetails['age']); ?></p>
            <p><strong>Joined On:</strong> <?php echo htmlspecialchars($userDetails['created_at']); ?></p>
        </div>

        <h3>Update Email</h3>
        <form method="POST" action="" class="profile-form">
            <label for="email">New Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($userDetails['email']); ?>" required>
            <button type="submit" name="update_email" class="update-button">Update Email</button>
        </form>

         </form>
    </section>
</main>
<p class="about-us"><a href="about_us.php">About Us</a></p>

</body>
</html>
