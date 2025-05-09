<?php 

require '../config/config.php';

class Model {
    private $databaseTable = '';
    private $query = '';

    public function setDatabaseTable($databaseTable) {
        $this->databaseTable = $databaseTable;
    }

    // 1. LOGIN AUTHENTICATION 
    public function authentication($username, $password) {
        global $conn;

        if (empty($username) || empty($password)) {
            return 'Please enter both username and password.';
        }

        $this->query = "SELECT * FROM {$this->databaseTable} WHERE Username = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $users = $result->fetch_assoc();

            // Debugging step: Checking password input vs stored hash.
            echo "Input Password: " . $password . "<br>";
            echo "Stored Hash: " . $users['Password'] . "<br>";

            // if (password_verify($password, $users['Password'])) {

            if ($password === $users['Password']) {
                session_start();
                $_SESSION['id'] = $users['ID'];
                $_SESSION['username'] = $users['Username'];
                $_SESSION['password'] = $users['Password'];
                $_SESSION['role'] = $users['Role'];

                switch ($_SESSION['role']) {
                    case 'Admin':
                        header('Location: ../admin/admin.php');
                        exit;
                    case 'Student':
                        header('Location: ../client/client.php');
                        exit;
                }
            } else {
                return 'Invalid Password.';
            }
        } else {
            return 'Invalid Username and Password.';
        }

        // echo 'Testing pa';
    }

    // 1.1. AUTHENTICATION | LOGOUT
    public function logout() {
        session_start();
        session_unset();

        header('Location: ../auth/login.php');
        exit;
    }

    // 2. ADMIN | STUDENT LIST | ADD STUDENT 
    public function addStudent($studentNumber, $studentName, $course, $major, $yearLevel, $status, $password, $verifyPassword) {
        global $conn;

        if (empty($studentNumber) || empty($studentName) || empty($course) || empty($major) || empty($yearLevel) || empty($status) || empty($password)) {
            return 'Fill up all fields';
        }

        $this->query = "INSERT INTO student(StudentID, StudentName, Course, Major, YearLevel, Status) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('ssssss', $studentNumber, $studentName, $course, $major, $yearLevel, $status);

        return $statement->execute() ? 'Successfully Inserted' : 'Not successfully Inserted';
    }

    // 2. ADMIN | STUDENT LIST (ADD STUDENT) && ADMIN LIST (ADD ADMIN) 
    // public function addUser() {

    // }
}