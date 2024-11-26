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

<!-- Registration Form -->
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

<?php

echo 'Click here to ' . "<a href='login.php'>login </a>" . 'instead';

?>