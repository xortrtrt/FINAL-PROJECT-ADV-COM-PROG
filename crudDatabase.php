<?php
require_once('config.php');
class CrudDatabase {
    private $db;  

    // Constructor to create an instance of the Database class
    public function __construct() {
        // Initialize Database object to handle DB operations
        $this->db = new Database();
    }

    public function createUser($username, $password, $email, $age) {
        $query = "INSERT INTO users (username, password, email, age) VALUES (?, ?, ?, ?)";
        $params = [$username, $password, $email, $age];
        return $this->db->runQuery($query, $params);  // Execute the query
    }

    public function getUserByUsername($username) {
        $query = "SELECT * FROM users WHERE username = ?";
        $params = [$username];
        return $this->db->fetchSingle($query, $params);  // Fetch a single record
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        return $this->db->fetchResults($query);  // Fetch all users
    }

    public function getCourseById($course_id) {
        $query = "SELECT * FROM courses WHERE course_id = ?";
        $params = [$course_id];
        return $this->db->fetchSingle($query, $params);  
    }

    public function getAllCourses() {
        $query = "SELECT * FROM courses";
        return $this->db->fetchResults($query);  
    }

   
    public function enrollUserInCourse($user_id, $course_id) {
        $query = "SELECT COUNT(*) FROM enrollments WHERE user_id = ? AND course_id = ?";
        $params = [$user_id, $course_id];
        $result = $this->db->fetchSingle($query, $params);  

            //To check if the user is already enrolled in the course
        if ($result['COUNT(*)'] > 0) {
            return false;  
        }
    
       
        $query = "INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)";
        $params = [$user_id, $course_id];
        return $this->db->runQuery($query, $params); 
    }

   
    // show the courses for a specific user 
    public function getUserEnrollments($user_id) {
        $query = "SELECT courses.course_name, courses.description, courses.image_path
                  FROM enrollments
                  JOIN courses ON enrollments.course_id = courses.course_id
                  WHERE enrollments.user_id = ?";
        $params = [$user_id];
        return $this->db->fetchResults($query, $params);
    }

    
}
?>