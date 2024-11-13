<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $email = $_POST['email'];
    $age = $_POST['age'];

    // Prepare SQL and bind parameters
    $stmt = $conn->prepare("INSERT INTO users (username, password, email,age) VALUES (?, ?, ?, ?)"); //this is to put the registration on the database
    $stmt->bind_param("sssi", $username, $password, $email,$age);

 

    if ($stmt->execute()) {
        echo"Registration Successful";
    } else {
        echo 'Error: ' . $stmt->error;
    }
    $stmt->close();
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
    <input type="age" name="age" required>
    <button type="submit">Register</button>
</form>


<?php
//this is to ensure that a user does not register again if they already have an account \
//this is also used to login after the regisration as this code will redirect the user to the login page
echo 'Click here to ' . "<a href='login.php'>login </a>" . 'instead';

?>