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

        $this->query = "SELECT * FROM {$this->databaseTable} WHERE Username = ?";
        $statement = $conn->prepare($this->query);

        $statement->bind_param('s', $username);
        $statement->execute();


        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $users = $result->fetch_assoc();

            // Debugging step: Checking password input vs stored hash.
            echo "Input Password: " . $password . "<br>";
            echo "Stored Hash: " . $users['Password'] . "<br>";

            if (password_verify($password, $users['Password'])) {

            // if ($password === $users['Password']) {

                if ($users['Status'] == 'Active') {
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

        $this->query = "SELECT * FROM students WHERE StudentID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $studentNumber);
        $statement->execute();
        $verify = $statement->get_result();

        if ($verify->num_rows > 0) {
            return 'Duplicate Student # Invalid.';
        }

        // ADD STUDENT
        $this->query = "INSERT INTO students(StudentID, StudentName, Course, Major, YearLevel, Status) VALUES (?, ?, ?, ?, ?, ?)";
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

        $this->query = "SELECT * FROM students";
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

        $this->query = "SELECT * FROM students WHERE StudentID = ? AND StudentID != ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('ss', $currentStudentNumber, $studentNumber);
        $statement->execute();
        $verify = $statement->get_result();

        if ($verify->num_rows > 0) {
            return 'Duplicate Student # Invalid.';
        }

        $this->query = "SELECT ID FROM user WHERE Username = ?";
    $statement = $conn->prepare($this->query);
    $statement->bind_param('s', $currentStudentNumber);
    $statement->execute();
    $userResult = $statement->get_result();

    if ($userResult->num_rows === 0) {
        return 'User not found.';
    }

    $userRow = $userResult->fetch_assoc();
    $userId = $userRow['ID'];

    // If setting to Inactive, check borrowings and add_to_list
    if ($status === 'Inactive') {
        // Check for active borrowings
        $this->query = "SELECT * FROM borrowings WHERE UserID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('i', $userId);
        $statement->execute();
        $borrowings = $statement->get_result();

        if ($borrowings->num_rows > 0) {
            return 'Cannot inactivate student. They still have borrowed books.';
        }

        // Check for books in add_to_list
        $this->query = "SELECT * FROM add_to_list WHERE UserID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('i', $userId);
        $statement->execute();
        $addList = $statement->get_result();

        if ($addList->num_rows > 0) {
            return 'Cannot inactivate student. They still have books in their borrowing list.';
        }
    }


        // UPDATE STUDENT
        $this->query = "UPDATE students SET StudentName = ?, Course = ?, Major = ?, YearLevel = ?, Status = ? WHERE StudentID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('ssssss', $studentName, $course, $major, $yearLevel, $status, $studentNumber);


        // UPDATE USER
        if (empty($password) && empty($verifyPassword)) {
            $success = $statement->execute();
            if ($success && $statement->affected_rows > 0) {
                return 'Successfully Updated';
            } elseif ($success && $statement->affected_rows === 0) {
                return 'No changes made.';
            } else {
                return 'Not successfully Updated';
            }
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
        $success = $statement->execute();
        if ($success && $statement->affected_rows > 0) {
            return 'Successfully Password Updated';
        } elseif ($success && $statement->affected_rows === 0) {
            return 'No password changes made.';
        } else {
            return 'Not successfully password Updated';
        }
    }

    public function studentID($studentID) {
        global $conn;

        $this->query = "SELECT * FROM students WHERE StudentID = '$studentID'";
        $retrieve = \mysqli_query($conn, $this->query);

        $rows = [];

        if ($retrieve && mysqli_num_rows($retrieve) > 0) {
            while ($row = mysqli_fetch_assoc($retrieve)) {
                $rows[] = $row;
            }
        } 

        return $rows;
    }

    public function searchStudentID($input) {
        global $conn;

        $this->query = "SELECT * FROM students WHERE StudentID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $input);
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

    public function addBook($bookTitle, $bookAuthor, $bookISBN, $bookCategory, $copyRight, $copies) {
        global $conn;

        $this->query = "CALL AddBook(?, ?, ?, ?, ?, ?, @message)";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('ssssii', $bookTitle, $bookAuthor, $bookISBN, $bookCategory, $copyRight, $copies);
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

        $this->query = "SELECT * FROM books WHERE Title = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $input);
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

    public function editBook($editBookID, $editTitle, $editAuthor, $editISBN, $editCategory, $editCopyright) {
        global $conn;

        $this->query = "UPDATE books SET Title = ?, Author = ?, ISBN = ?, Category = ?, CopyRight = ? WHERE BookID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('sssssi', $editTitle, $editAuthor, $editISBN, $editCategory, $editCopyright, $editBookID);

        $success = $statement->execute();
        if ($success && $statement->affected_rows > 0) {
            return 'Successfully Updated';
        } elseif ($success && $statement->affected_rows === 0) {
            return 'No changes made.';
        } else {
            return 'Not successfully Updated';
        }
    }

    // 4. ============================ BORROWING ============================   
    public function searchAvailableBook($input) {
        global $conn;

        $this->query = "SELECT b.* FROM books b LEFT JOIN borrowings br ON b.BookID = br.bookID WHERE br.BookID IS NULL AND Status = 'Available' AND CopyRight >= YEAR(CURDATE()) - 6 AND Title = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $input);
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
    
    public function addToList($studentNumber, $studentName, $course, $major, $yearLevel, $bookID, $userID, $date, $time) {
        global $conn;

        // --- CONDITIONING ---
        if ($studentNumber == '' || $studentName == '' || $course == '' || $major == '' || $yearLevel == '' || $bookID == '' || $userID == '' || $date == '' || $time == '') {
            return 'Invalid Borrowing Book. Unidentified User';
        } 

        // --- START ADD TO LIST BOOK ---
        // GET THE ID FROM THE USER.
        $this->query = "SELECT ID FROM user WHERE Username = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $userID);
        $statement->execute();
        $result = $statement->get_result();

        $row = $result->fetch_assoc();
        $userID = $row['ID'];

        // PERFORM ADD TO LIST.
        $this->query = "INSERT INTO add_to_list(BookID, UserID) VALUES (?, ?)";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('ii', $bookID, $userID);
        $statement->execute();

        // UPDATE STATUS BOOKS [RESERVED].
        $this->query = "UPDATE books SET Status = 'Reserved' WHERE BookID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('i', $bookID);

        return $statement->execute() ? 'Successfully Add to List Book' : 'Not Successfully Borrowed Book';
    }

    public function showAddToList($userID) {
        global $conn;

        // GET THE ID FROM THE USER.
        $this->query = "SELECT ID FROM user WHERE Username = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $userID);
        $statement->execute();
        $result = $statement->get_result();

        $row = $result->fetch_assoc();
        if (!$row) {
            return [];
        }
        $userID = $row['ID'];

        $this->query = "SELECT b.*, a.UserID
            FROM books b
            JOIN add_to_list a ON b.BookID = a.BookID
            WHERE a.UserID = ? AND b.Status = 'Reserved'";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $userID);
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

    public function deleteAddToList($userID, $bookID) {
        global $conn;

        $this->query = "DELETE FROM add_to_list WHERE BookID = ? AND UserID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('ii', $bookID, $userID);
        $statement->execute();

        $this->query = "UPDATE books SET Status = 'Available' WHERE BookID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('i', $bookID);

        return $statement->execute() ? 'Successfully Deleted Book' : 'Not Successfully Deleted Book'; 
    }

    public function addBorrowBook($bookID, $userID, $date, $time) {
        global $conn;

        // --- CONDITIONING ---
        if ($bookID == '' || $userID == '' || $date == '' || $time == '') {
            return 'Invalid Borrowing Book. Unidentified User';
        } 

        // PERFORM BORROWING.
        $this->query = "INSERT INTO borrowings(BookID, UserID, BorrowDate, BorrowTime) VALUES (?, ?, ?, ?)";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('iiss', $bookID, $userID, $date, $time);
        $statement->execute();

        // DELETE ADD_TO_LIST BASED ON USER ID AND BOOK ID
        $this->query = "DELETE FROM add_to_list WHERE BookID = ? AND UserID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('ii', $bookID, $userID);
        $statement->execute();

        // UPDATE STATUS BOOKS.
        $this->query = "UPDATE books SET Status = 'Borrowed' WHERE BookID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('i', $bookID);

        return $statement->execute() ? 'Successfully Borrowed Book' : 'Not Successfully Borrowed Book';
    }

    public function searchStudentBorrowBook($input) {
        global $conn;

        $this->query = "SELECT * FROM students WHERE StudentID = ? AND Status = 'Active'";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $input);
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

    public function showAvailableBorrowBook() {
        global $conn;

        $this->query = "SELECT b.* FROM books b LEFT JOIN borrowings br ON b.BookID = br.bookID WHERE br.BookID IS NULL AND Status = 'Available' AND CopyRight >= YEAR(CURDATE()) - 6";

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


    // 5. ============================ RETURNING ============================ 
    public function addReturnBook($borrowID, $userID, $borrowDate, $borrowTime, $returnDate, $returnTime, $bookID) {
        global $conn;

        $this->query = "INSERT INTO returning(BorrowID, UserID, BorrowDate, BorrowTime, ReturnDate, ReturnTime, BookID) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('iissssi', $borrowID, $userID, $borrowDate, $borrowTime, $returnDate, $returnTime, $bookID);
        $statement->execute();
   
        $this->query = "DELETE FROM borrowings WHERE BorrowID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('i', $borrowID);
        $statement->execute();

        // UPDATE STATUS BOOKS.
        $this->query = "UPDATE books SET Status = 'Available' WHERE BookID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('i', $bookID);

        return $statement->execute() ? 'Successfully Returned Book' : 'Not Successfully Returned Book';
    }

    public function showBorrowedBookForReturn($userID) {
        global $conn;

        // GET THE USERID FROM USER
        $this->query = "SELECT ID FROM user WHERE Username = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $userID);
        $statement->execute();
        $result = $statement->get_result();

        $row = $result->fetch_assoc();
        if (!$row) {
            return [];
        }


        $userID = $row['ID'];

        // DISPLAY BORROWED BOOK FROM USER ID
        $this->query = "SELECT 
                    borrowings.BorrowID,
                    books.BookID,
                    books.Title,
                    books.Author,
                    books.ISBN,
                    books.Category,
                    books.CopyRight,
                    borrowings.UserID,
                    borrowings.BorrowDate,
                    borrowings.BorrowTime,
                    CASE 
                        WHEN TIMESTAMPDIFF(HOUR, CONCAT(borrowings.BorrowDate, ' ', borrowings.BorrowTime), NOW()) > 72 
                        THEN 'Yes'
                        ELSE 'No'
                    END AS Penalty
                FROM books
                JOIN borrowings ON books.BookID = borrowings.BookID
                WHERE borrowings.UserID = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('i', $userID);
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

    // 6. ============================ INVENTORY [ALL BOOKS] ============================
    public function inventoryAllBooks() {
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

    public function inventoryBookCategory() {
        global $conn;

        $this->query = "SELECT Category, COUNT(*) AS 'Quantity' FROM books GROUP BY Category";
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

    public function inventoryArchivedBooks() {
        global $conn;

        $this->query = "SELECT * FROM books WHERE CopyRight <= YEAR(CURDATE()) - 6";
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

    public function searchAllBooks($input) {
        global $conn;

        $this->query = "SELECT * FROM books WHERE Title = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $input);
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

    public function searchBookCategory($input) {
        global $conn;

        $this->query = "SELECT Category, COUNT(*) AS Quantity FROM books WHERE Category = ? GROUP BY Category";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $input);
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

    public function searchArchivedBooks($input) {
        global $conn;

        $this->query = "SELECT * FROM books WHERE CopyRight <= YEAR(CURDATE()) - 6 AND Title = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $input);
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

    public function showUserManagement() {
        global $conn;

        $this->query = "SELECT * FROM user WHERE Role != 'Student' AND Username <> 'admin'";
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

    public function searchUserManagement($input) {
        global $conn;

        $this->query = "SELECT * FROM user WHERE Username = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $input);
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

    public function addUserManagement($username, $password, $role, $status) {
        global $conn;

        // CHECK CONDITION
        $this->query = "SELECT * FROM user WHERE Username = ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('s', $username);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            return 'Username already exists';
        }

        // ADD USER
        $role = 'Admin';

        $this->query = "INSERT INTO user(Username, Password, Role, Status) VALUES (?, ?, ?, ?)";
        $statement = $conn->prepare($this->query);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $statement->bind_param('ssss', $username, $hashedPassword, $role, $status);
        return $statement->execute() ? 'Successfully Inserted' : 'Not successfully Inserted';
    }

    public function editUserManagement($id, $username, $password, $status) {
        global $conn;

        // CHECK CONDITION
        $this->query = "SELECT * FROM user WHERE Username = ? AND ID != ?";
        $statement = $conn->prepare($this->query);
        $statement->bind_param('si', $username, $id);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            return 'Username already exists';
        }

        // UPDATE USER
        

        if (empty($password)) {
            $this->query = "UPDATE user SET Username = ?, Status = ? WHERE ID = ?";
            $statement = $conn->prepare($this->query);
            $statement->bind_param('ssi', $username, $status, $id);
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $this->query = "UPDATE user SET Username = ?, Status = ?, Password = ? WHERE ID = ?";
            $statement = $conn->prepare($this->query);
            $statement->bind_param('sssi', $username, $status, $hashedPassword, $id);
        }

        $success = $statement->execute();
        if ($success && $statement->affected_rows > 0) {
            return 'Successfully Updated';
        } elseif ($success && $statement->affected_rows === 0) {
            return 'No changes made.';
        } else {
            return 'Not successfully Updated';
        }
    }

}