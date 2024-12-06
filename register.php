<?php
session_start();
require_once('crudDatabase.php');

$crud = new CrudDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  
    $email = $_POST['email'];
    $age = $_POST['age'];

    $crud->createUser($username, $password, $email, $age);
    echo "User registered successfully!";
    header("Location: login.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles/register.css">
</head>
<body>
    <div class="register-container">
        <h1>Register</h1>
        <form method="post" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <label>Age:</label>
            <input type="number" name="age" required>
            
            <button type="submit">Register</button>
        </form>
        
        <p>Already have an account? <a href="login.php">Login here</a></p>

        <?php
        if (isset($_GET['error']) && $_GET['error'] === 'duplicate') {
        echo "<p style='color:red;'>Username or email already exists. Please choose another one.</p>";
        }
    ?>

        <p class="about-us"><a href="about_us.php">About Us</a></p>

    </div>

    
</body>


</html>
