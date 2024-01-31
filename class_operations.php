<?php

// Include the database connection file
require_once 'dbconnection.php';

class ClassOperations {
    // Property to hold the database connection
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Method to get all records from the "students" table
    public function getAllStudentsRecords() {
        try {
            $query = $this->conn->prepare("SELECT * FROM students");
            $query->execute();
            $records = $query->fetchAll(PDO::FETCH_ASSOC);
            return $records;
        } catch (PDOException $e) {
            $response = array('success' => false, 'error' => 'Query failed: ' . $e->getMessage());
            echo json_encode($response);
        }
    }

    // Method to add a new student
    public function addStudent($studentName) {
        try {
            $query = $this->conn->prepare("INSERT INTO students (full_name) VALUES (:student_name)");
            $query->bindParam(':student_name', $studentName);
            $query->execute();

            $response = array('success' => true, 'message' => 'Student added successfully');
            echo json_encode($response);
        } catch (PDOException $e) {
            $response = array('success' => false, 'error' => 'Query failed: ' . $e->getMessage());
            echo json_encode($response);
        }
    }
}

// Create an instance of ClassOperations with the database connection
$classOperations = new ClassOperations($conn);

// Check the action parameter and call the appropriate method
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'addstudent' && isset($_POST['studentName'])) {
        $studentName = $_POST['studentName'];
        $classOperations->addStudent($studentName);
    } elseif ($action === 'getallstudents') {
        $records = $classOperations->getAllStudentsRecords();
        echo json_encode($records);
    } else {
        $response = array('success' => false, 'error' => 'Invalid action or parameters');
        echo json_encode($response);
    }
}

?>
