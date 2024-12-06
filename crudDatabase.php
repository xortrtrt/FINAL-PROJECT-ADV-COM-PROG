<?php
require_once('config.php');
class CrudDatabase {
    private $db;  

    public function __construct() {
        $this->db = new Database();
    }

    public function createUser($username, $password, $email, $age) {
        // Check if username or email already exists
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        if ($stmt->fetchColumn() > 0) {
            // Redirect to register.php if username or email is duplicate
            header("Location: register.php?error=duplicate");
            exit(); // Ensure the script stops executing after the redirect
        }
    
        // If no duplicates, proceed with the insert
        $sql = "INSERT INTO users (username, password, email, age) VALUES (:username, :password, :email, :age)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':age', $age);
        $stmt->execute();
    }
    

    public function getUserByUsername($username) {
        $query = "SELECT * FROM users WHERE username = ?";
        $params = [$username];
        return $this->db->fetchSingle($query, $params);  
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        return $this->db->fetchResults($query); 
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

        if ($result['COUNT(*)'] > 0) {
            return false;  
        }
    
       
        $query = "INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)";
        $params = [$user_id, $course_id];
        return $this->db->runQuery($query, $params); 
    }

   
    public function getUserEnrollments($user_id) {
        $query = "SELECT courses.course_id, courses.course_name, courses.description, courses.image_path
          FROM courses
          JOIN enrollments ON enrollments.course_id = courses.course_id
          WHERE enrollments.user_id = ?";
        $params = [$user_id];
        return $this->db->fetchResults($query, $params);
    }


    public function searchAvailableCourses($searchTerm) {    
        $query = "SELECT course_id, course_name, description, image_path FROM courses WHERE course_name LIKE :searchTerm";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR); 
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);    
        return $courses;
    }
    
    public function getCourseDetails($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE course_id = ?");
        $stmt->execute([$course_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCourseTopics($course_id) {
        $stmt = $this->db->prepare("SELECT * FROM topics WHERE course_id = ?");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTopicContent($topic_id) {
        $stmt = $this->db->prepare("SELECT * FROM topics WHERE topic_id = ?");
        $stmt->execute([$topic_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getTopicDescription($topic_id) {
        $query = "SELECT topic_description FROM topics WHERE topic_id = :topic_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getUserDetails($user_id) {
        $query = "SELECT username, email, age, created_at FROM users WHERE user_id = ?";
        $params = [$user_id];
    
        return $this->db->fetchSingle($query, $params); 
    }
    
    public function updateUserEmail($user_id, $newEmail) {
        $query = "UPDATE users SET email = :email WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);  

        $stmt->bindParam(':email', $newEmail, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "Email updated successfully.";
        } else {
            return "Error updating email.";
        }
    }


    public function unenrollFromCourse($user_id, $course_id) {
        // Prepare the DELETE query
        $query = "DELETE FROM enrollments WHERE user_id = :user_id AND course_id = :course_id";
        
        // Prepare the statement
        $stmt = $this->db->prepare($query);
        
        // Bind the parameters
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        
        // Execute the statement
        return $stmt->execute();
    }


}
    

    
   
?>