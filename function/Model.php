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

        echo $username;
        echo $password;

        $this->query = "SELECT * FROM user WHERE Username = ?";
        $statement = $conn->prepare($this->query);

        $statement->bind_param('s', $username);
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

        // CHECK CONDITION
        if (empty($studentNumber) || empty($studentName) || empty($course) || empty($major) || empty($yearLevel) || empty($status) || empty($password) || empty($verifyPassword)) {
            return 'Fill up all fields.';
        }

        if ($password !== $verifyPassword) {
            return 'Passwords do not match. Please try again.';
        }

        $this->query = "SELECT * FROM student WHERE StudentID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $studentNumber);
        $statement->execute();
        $verify = $statement->get_result();

        if ($verify->num_rows > 0) {
            return 'Duplicate Student # Invalid.';
        }

        // ADD STUDENT
        $this->query = "INSERT INTO student(StudentID, StudentName, Course, Major, YearLevel, Status) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('ssssss', $studentNumber, $studentName, $course, $major, $yearLevel, $status);
        $statement->execute();

        // ADD USER
        $this->query = "INSERT INTO user(Username, Password, Role, Status) VALUES (?, ?, 'Student', ?)";
        $statement = $conn->prepare($this->query);
        $hashedPassword = password_hash($studentNumber, PASSWORD_DEFAULT);
        $statement->bind_param('sss', $studentNumber, $hashedPassword, $status);

        return $statement->execute() ? 'Successfully Inserted' : 'Not successfully Inserted';
    }

    public function showStudent() {
        global $conn;

        $this->query = "SELECT * FROM student";
        $statement = mysqli_prepare($conn, $this->query);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $rows = [];

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        }

        return $rows;
    }
    

    // public function retrieveStudent($studentID) {
    //     global $conn;

    //     $stmt = $conn->prepare("SELECT * FROM user WHERE Username = ?");
    //     $stmt->bind_param("s", $studentID);
    //     $stmt->execute();
        
    //     $result = $stmt->get_result();
    //     $rows = $result->fetch_all(MYSQLI_ASSOC);
        
    //     $stmt->close();
        
    //     return $rows;
    // }

    // public function retrieveStudent($studentID) {
    //     global $conn;

    //     $this->query = "SELECT * FROM user WHERE Username = '$studentID' LIMIT 1";
    //     $result = mysqli_query($conn, $this->query);

    //     if ($result && mysqli_num_rows($result) > 0) {
    //         return mysqli_fetch_assoc($result); // returns single row
    //     }

    //     return [];
    // }



    // MAINTENANCE
    public function editStudent($currentStudentNumber, $studentNumber, $studentName, $course, $major, $yearLevel, $status, $password, $verifyPassword) {
        global $conn;

        $this->query = "SELECT * FROM student WHERE StudentID = ? AND StudentID != ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('ss', $currentStudentNumber, $studentNumber);
        $statement->execute();
        $verify = $statement->get_result();

        if ($verify->num_rows > 0) {
            return 'Duplicate Student # Invalid.';
        }

        // UPDATE STUDENT
        $this->query = "UPDATE student SET StudentName = ?, Course = ?, Major = ?, YearLevel = ?, Status = ? WHERE StudentID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('ssssss', $studentName, $course, $major, $yearLevel, $status, $studentNumber);


        // UPDATE USER
        if (empty($password) && empty($verifyPassword)) {
            return $statement->execute() ? 'Successfully Updated' : 'Not successfully Updated';
        }

        if (empty($password) && !empty($verifyPassword)) {
            return 'Please fill in the password field.';
        }

        if (!empty($password) && empty($verifyPassword)) {
            return 'Please confirm your password.';
        }

        $this->query = "UPDATE user SET Password = ?, Status = ? WHERE Username = ?";
        $statement = $conn->prepare($this->query);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement->bind_param('sss', $hashedPassword, $status, $studentNumber);
        return $statement->execute() ? 'Successfully Password Updated' : 'Not successfully password Updated';  
    }

    public function studentID($studentID) {
        global $conn;

        $this->query = "SELECT * FROM student WHERE StudentID = '$studentID'";
        $retrieve = \mysqli_query($conn, $this->query);

        $rows = [];

        if ($retrieve && mysqli_num_rows($retrieve) > 0) {
            while ($row = mysqli_fetch_assoc($retrieve)) {
                $rows[] = $row;
            }
        } 

        return $rows;
    }

    // 3. ADD BOOK
    // public function addBook($bookID, $bookTitle, $bookAuthor, $bookISBN, $bookCategory, $copies) {
    //     global $conn;

    //     $this->query = "SELECT * FROM books WHERE BookID = ?";
    //     $statement = $conn->prepare($this->query);
    //     $statement->bind_param('s', $bookID);
    //     $statement->execute();
    //     $verify = $statement->get_result();

    //     if ($verify->num_rows > 0) {
    //         return 'Duplicate Book ID is Invalid.';
    //     }

    //     $this->query = "INSERT INTO books(BookID, Title, Author, ISBN, Category, Copies) VALUES (?, ?, ?, ?, ?, ?)";
    //     $statement = $conn->prepare($this->query);
    //     $statement->bind_param('sssssi', $bookID, $bookTitle, $bookAuthor, $bookISBN, $bookCategory, $copies);
        
    //     return $statement->execute() ? 'Successfully Inserted' : 'Not successfully Inserted';        
    // }   

    // public function addBook($bookID, $bookTitle, $bookAuthor, $bookISBN, $bookCategory, $copies) {
    //     global $conn;

    //     $this->query = "CALL AddBook(?, ?, ?, ?, ?, ?, @message)";
    //     $statement = $conn->prepare($this->query);
    //     $statement->bind_param('sssssi', $bookID, $bookTitle, $bookAuthor, $bookISBN, $bookCategory, $copies);
    //     $statement->execute();
    //     $statement->close();

    //     $result = $conn->query("SELECT @message AS message");
    //     $row = $result->fetch_assoc();

    //     return $row['message'];
    // }

    public function addBook($bookTitle, $bookAuthor, $bookISBN, $bookCategory, $copies) {
        global $conn;

        $this->query = "CALL AddBook(?, ?, ?, ?, ?, @message)";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('ssssi', $bookTitle, $bookAuthor, $bookISBN, $bookCategory, $copies);
        $statement->execute();
        $statement->close();

        $result = $conn->query("SELECT @message AS message");
        $row = $result->fetch_assoc();

        return $row['message'];
    }

    // public function showBook() {
    //     global $conn;

    //     $this->query = "SELECT * FROM books";
    //     $retrieve = \mysqli_query($conn, $this->query);

    //     $rows = [];

    //     if ($retrieve && mysqli_num_rows($retrieve) > 0) {
    //         while ($row = mysqli_fetch_assoc($retrieve)) {
    //             $rows[] = $row;
    //         }
    //     } 

    //     return $rows;
    // }

    public function showBook() {
        global $conn;

        $this->query = "SELECT * FROM books";
        $statement = $conn->prepare($this->query);
        $statement->execute();
        $result = $statement->get_result();

        $rows = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        return $rows;
    }



    public function searchBook($input) {
        global $conn;

        $this->query = "SELECT * FROM books WHERE BookID LIKE '%$input%' OR Title LIKE '%$input%' OR Author LIKE '%$input%' OR ISBN LIKE '%$input%' OR Category LIKE '%$input%' OR Copies LIKE '%$input%'";
        $retrieve = \mysqli_query($conn, $this->query);

        $rows = [];

        if ($retrieve && mysqli_num_rows($retrieve) > 0) {
            while ($row = mysqli_fetch_assoc($retrieve)) {
                $rows[] = $row;
            }
        } 

        return $rows;
    }
}