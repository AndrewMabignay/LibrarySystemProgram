<?php 

require_once '../function/Model.php';

if (isset($_POST['searchStudentID'])) {
    $studentIDDisplay = $_POST['studentNumber'];
    $studentIDUserDisplay = $studentIDDisplay;

    $searchStudentID = new Model();
    $studentInformation = $searchStudentID->searchStudentBorrowBook($studentIDDisplay);

    if (count($studentInformation) == 0) {
        $studentIDDisplay = '';
    } 

    $studentNameDisplay = '';
    $courseDisplay = '';
    $majorDisplay = '';
    $yearLevelDisplay = '';

    foreach ($studentInformation as $data) {
        $studentNameDisplay = $data['StudentName'];
        $courseDisplay = $data['Course'];
        $majorDisplay = $data['Major'];
        $yearLevelDisplay = $data['YearLevel'];
    }
}

// MAINTENANCE | BORROW BOOK
if (isset($_POST['borrowBook'])) {
    // STUDENT #
    $studentNumber = $_POST['studentNumber'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // STUDENT INFORMATION
    $studentName = $_POST['studentName'];
    $course = $_POST['course'];
    $major = $_POST['major'];
    $yearLevel = $_POST['yearLevel'];

    // BORROWING FIELDS
    $bookID = $_POST['bookID'];
    $userID = $_POST['userID'];

    $borrowBook = new Model();
    $borrowBookPrompt = $borrowBook->addBorrowBook($studentNumber, $studentName, $course, $major, $yearLevel, $bookID, $userID, $date, $time);    
    echo $borrowBookPrompt;
} 


$showBook = new Model();
$dataBook = $showBook->showAvailableBorrowBook();

?>

<div class="borrowing-list-container">
    <div class="header-two">
        <h2>Book Borrowing</h2>    
    </div>

    <hr class="seperator-line">

    <!-- LIST OF BOOKS -->
    <div class="table-wrapper">
        <div class="student-borrowing-input-container">
            <form action="admin.php?page=borrowing" method="POST">
                <!-- SEARCH STUDENT # -->
                <div class="search-student-number">
                    <div class="input-container">
                        <label for="studentNumber">Student #</label>
                        <input type="text" name="studentNumber" value="<?php echo isset($studentIDUserDisplay) ? $studentIDUserDisplay : '' ?>">
                    </div>

                    <?php date_default_timezone_set('Asia/Manila'); ?>

                    <!-- DATE -->
                    <div class="input-container">
                        <label for="date">Date</label>
                        <input type="text" name="date" value="<?php echo date("Y-m-d") ?>">
                    </div>

                    <!-- TIME -->
                    <div class="input-container">
                        <label for="major">Time</label>
                        <input type="text" name="time" value="<?php echo date("H:i:s") ?>">
                    </div>

                    <div class="button">
                        <button type="submit" name="searchStudentID">
                            SEARCH STUDENT
                        </button>
                    </div>

                    <!-- STUDENT NAME -->
                    <div class="input-container">
                        <label for="studentName">Student Name</label>
                        <input type="text" name="studentName" value="<?php echo isset($studentNameDisplay) ? $studentNameDisplay : '' ?>">
                    </div>

                    <!-- COURSE -->
                    <div class="input-container">
                        <label for="course">Course</label>
                        <input type="text" name="course" value="<?php echo isset($courseDisplay) ? $courseDisplay : '' ?>">
                    </div>

                    <!-- MAJOR -->
                    <div class="input-container">
                        <label for="major">Major</label>
                        <input type="text" name="major" value="<?php echo isset($majorDisplay) ? $majorDisplay : '' ?>">
                    </div>

                    <!-- YEAR LEVEL -->
                    <div class="input-container">
                        <label for="yearLevel">Year Level</label>
                        <input type="text" name="yearLevel" value="<?php echo isset($yearLevelDisplay) ? $yearLevelDisplay : '' ?>">
                    </div>
                </div>

                <hr class="seperator-line-table">

                <!-- SEARCH BOOKS -->
                <div class="search-books-information">
                    <div class="input-container">
                        <label for="bookTitle">Book Title</label>
                        <input type="text" name="yearLevel" value="<?php echo isset($yearLevelDisplay) ? $yearLevelDisplay : '' ?>">
                    </div>
                </div>

                <!-- BOOK TABLE TESTING -->
                 <table>
                    <thead>
                        <tr>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>ISBN</th>
                            <th>Category</th>
                            <th>Copyright</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DISPLAY BOOK BORROWING OUTPUT -->
                        <?php foreach($dataBook as $books): ?>
                            <tr>
                                <td><?php echo $books['BookID'] ?></td>
                                <td><?php echo $books['Title'] ?></td>
                                <td><?php echo $books['Author'] ?></td>
                                <td><?php echo $books['ISBN'] ?></td>
                                <td><?php echo $books['Category'] ?></td>
                                <td><?php echo $books['CopyRight'] ?></td>
                                <td>
                                    <form>
                                        <input type="text" name="bookID" value="<?php echo $books['BookID'] ?>">
                                        <input type="text" name="userID" value="<?php echo isset($studentIDDisplay) ? $studentIDDisplay : '' ?>">
                                        
                                        
                                        <button type="submit" name="borrowBook">
                                            Borrow
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- END BOOK BORROWING OUTPUT -->
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <!-- ADD STUDENT FOR BOOK BORROWING -->
    <?php ?>
        
    <?php ?>
</div>