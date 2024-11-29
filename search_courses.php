<?php
session_start();
require_once('crudDatabase.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; 

$searchQuery = isset($_POST['query']) ? $_POST['query'] : '';

$crud = new CrudDatabase();
$results = $crud->searchCourses($user_id, $searchQuery);

echo json_encode($results);
?>
