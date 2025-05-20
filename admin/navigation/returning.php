<?php 

require_once '../function/Model.php';

if (isset($_POST['searchStudentID'])) {
    $studentNumber = $_POST['studentNumber']; 
    $studentIDUserDisplay = $studentNumber;

    // SEARCH USER 
    $searchStudentID = new Model();
    $studentInformation = $searchStudentID->searchStudentBorrowBook($studentNumber);

    if (count($studentInformation) == 0) {
        $studentNumber = '';
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

    // DISPLAY BORROWED BOOK BASED ON USER SEARCH
    $studentBorrowedBook = new Model();
    $dataBorrowedBook = $studentBorrowedBook->showBorrowedBookForReturn($studentNumber);
}

if (isset($_POST['returnBook'])) {
    $studentNumber = $_POST['studentNumber']; 

    $borrowID = $_POST['borrowID'];
    $bookID = $_POST['bookID'];
    $userID = $_POST['userID'];
    $borrowDate = $_POST['borrowDate'];
    $borrowTime = $_POST['borrowTime'];
    $returnDate = $_POST['date'];
    $returnTime = $_POST['time'];

    $studentBorrowedBook = new Model();
    $studentBorrowedBook->addReturnBook($borrowID, $userID, $borrowDate, $borrowTime, $returnDate, $returnTime, $bookID);
    $dataBorrowedBook = $studentBorrowedBook->showBorrowedBookForReturn($studentNumber);
}

?>

<div class="returning-list-container">
    <div class="header-two">
        <h2>Book Returning</h2>    
    </div>

    <hr class="seperator-line">

    <div class="table-wrapper">
        <div class="student-returning-input-container">
            <form action="admin.php?page=returning" method="POST">
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
                        <input type="text" name="date" value="<?php echo date("Y-m-d") ?>" readonly>
                    </div>

                    <!-- TIME -->
                    <div class="input-container">
                        <label for="major">Time</label>
                        <input type="text" name="time" value="<?php echo date("H:i:s") ?>" readonly>
                    </div>

                    <div class="input-container button">
                        <button type="submit" name="searchStudentID">
                            <i class="fas fa-user"></i>
                            SEARCH STUDENT
                        </button>
                    </div>

                    <!-- STUDENT NAME -->
                    <div class="input-container">
                        <label for="studentName">Student Name</label>
                        <input type="text" name="studentName" value="<?php echo isset($studentNameDisplay) ? $studentNameDisplay : '' ?>" readonly>
                    </div>

                    <!-- COURSE -->
                    <div class="input-container">
                        <label for="course">Course</label>
                        <input type="text" name="course" value="<?php echo isset($courseDisplay) ? $courseDisplay : '' ?>" readonly>
                    </div>

                    <!-- MAJOR -->
                    <div class="input-container">
                        <label for="major">Major</label>
                        <input type="text" name="major" value="<?php echo isset($majorDisplay) ? $majorDisplay : '' ?>" readonly>
                    </div>

                    <!-- YEAR LEVEL -->
                    <div class="input-container">
                        <label for="yearLevel">Year Level</label>
                        <input type="text" name="yearLevel" value="<?php echo isset($yearLevelDisplay) ? $yearLevelDisplay : '' ?>" readonly>
                    </div>
                </div>

                
                <!-- BOOK TABLE TESTING -->
                <hr class="seperator-line-table">

                <table>
                    <thead>
                        <tr>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>ISBN</th>
                            <th>Borrow Date</th>
                            <th>Penalty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DISPLAY BOOK BORROWING OUTPUT -->
                        <?php if (isset($dataBorrowedBook) && count($dataBorrowedBook) > 0): ?>
                            <?php foreach ($dataBorrowedBook as $borrow): ?>
                                <tr>
                                    <td><?php echo $borrow['BookID']; ?></td>
                                    <td><?php echo $borrow['Title']; ?></td>
                                    <td><?php echo $borrow['Author']; ?></td>
                                    <td><?php echo $borrow['ISBN']; ?></td>
                                    <td><?php echo $borrow['BorrowDate']; ?></td>
                                    <td>
                                        <label for="" <?php echo $borrow['Penalty'] == 'No' ? "id='penaltyNo'" : "id='penaltyYes'"; ?> id="penalty">
                                            <?php echo $borrow['Penalty']; ?>
                                        </label>
                                    </td>
                                    <td>
                                        <form action="admin.php?page=returning" method="POST">
                                            <input type="hidden" name="borrowID" value="<?php echo $borrow['BorrowID'] ?>">
                                            <input type="hidden" name="bookID" value="<?php echo $borrow['BookID'] ?>">
                                            <input type="hidden" name="userID" value="<?php echo $borrow['UserID'] ?>">
                                            <input type="hidden" name="borrowDate" value="<?php echo $borrow['BorrowDate'] ?>">
                                            <input type="hidden" name="borrowTime" value="<?php echo $borrow['BorrowTime'] ?>">
                                            
                                            <button type="submit" name="returnBook" id="returned">
                                                Return
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php elseif (!isset($dataBorrowedBook)): ?> 
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">No borrowed Book.</td>
                            </tr>
                        <?php endif; ?>
                        <!-- END BOOK BORROWING OUTPUT -->
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>