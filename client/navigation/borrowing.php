<?php 

require_once '../function/Model.php';

// ================ DEFAULT DISPLAY FOR STUDENT INFORMATION ================
$studentIDDisplay = $_SESSION['username'];
$studentIDUserDisplay = $studentIDDisplay;

$searchStudentID = new Model();
$studentInformation = $searchStudentID->searchStudentBorrowBook($studentIDDisplay);

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

$showAddToList = new Model();
$displayAddToList = $showAddToList->showAddToList($studentIDDisplay);


// ================ ADD TO LIST BOOK ================
if (isset($_POST['addToListBook'])) {
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

    $addToListBook = new Model();
    $addToListPrompt = $addToListBook->addToList($studentNumber, $studentName, $course, $major, $yearLevel, $bookID, $userID, $date, $time);    
    // echo $addToListPrompt;

    $studentIDDisplay = $studentNumber;
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

    $showAddToList = new Model();
    $displayAddToList = $showAddToList->showAddToList($studentIDDisplay);
}

if (isset($_POST['deleteAddtoListBook'])) {
    // STUDENT #
    $studentNumber = $_POST['studentNumber'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $bookID = $_POST['bookID'];
    $userID = $_POST['userID'];

    $borrowBook = new Model();
    $borrowBookPrompt = $borrowBook->deleteAddToList($userID, $bookID);    
    // echo $borrowBookPrompt;

    $studentIDDisplay = $studentNumber;
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

    $showAddToList = new Model();
    $displayAddToList = $showAddToList->showAddToList($studentIDDisplay);
}


// ================ BORROW BOOK ================
if (isset($_POST['borrowBook'])) {
    // STUDENT #
    $studentNumber = $_POST['studentNumber'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $bookID = $_POST['bookID'];
    $userID = $_POST['userID'];

    $borrowBook = new Model();
    $borrowBookPrompt = $borrowBook->addBorrowBook($bookID, $userID, $date, $time);    
    // echo $borrowBookPrompt;

    $studentIDDisplay = $studentNumber;
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

    $showAddToList = new Model();
    $displayAddToList = $showAddToList->showAddToList($studentIDDisplay);
} 


$showBook = new Model();
$dataBook = $showBook->showAvailableBorrowBook();

if (isset($_POST['searchBookAvailable'])) {
    $dataBook = $showBook->searchAvailableBook($_POST['searchBookAvailableName']);

    $studentIDDisplay = $_POST['studentNumber'];
    $studentIDUserDisplay = $_POST['studentNumber'];
    $studentNameDisplay = $_POST['studentName'];
    $courseDisplay = $_POST['course'];
    $majorDisplay = $_POST['major'];
    $yearLevelDisplay = $_POST['yearLevel'];

}

?>

<div class="borrowing-list-container">
    <form action="client.php?page=borrowing" method="POST" class="header-two">
        <h2>Book Borrowing</h2>    

        <div class="input-container">
            
            <!-- SEARCH INPUT -->
            <!-- SEARCH INPUT -->
            <div class="search-container">
                <input type="text" name="searchBookAvailableName" placeholder="Search Book" <?php echo isset($studentIDDisplay) ? '' : 'disabled' ?>>
                
                <!-- hidden inputs to preserve student info -->
                <input type="hidden" name="studentNumber" value="<?php echo isset($studentIDUserDisplay) ? $studentIDUserDisplay : '' ?>">
                <input type="hidden" name="studentName" value="<?php echo isset($studentNameDisplay) ? $studentNameDisplay : '' ?>">
                <input type="hidden" name="course" value="<?php echo isset($courseDisplay) ? $courseDisplay : '' ?>">
                <input type="hidden" name="major" value="<?php echo isset($majorDisplay) ? $majorDisplay : '' ?>">
                <input type="hidden" name="yearLevel" value="<?php echo isset($yearLevelDisplay) ? $yearLevelDisplay : '' ?>">
                <input type="hidden" name="date" value="<?php echo date("Y-m-d") ?>">
                <input type="hidden" name="time" value="<?php echo date("H:i:s") ?>">

                
                <button type="submit" name="searchBookAvailable" <?php echo isset($studentIDDisplay) ? '' : 'disabled' ?>>
                    <label for="">
                        <i class="fas fa-search"></i>
                    </label>
                </button>
            </div>

            <!-- REFRESH BUTTON -->
            <button type="submit" name="refreshStudent">
                <i class="fas fa-sync"></i>
            </button>
        </div>
    </form>

    <hr class="seperator-line">

    <!-- LIST OF BOOKS -->
    <div class="table-wrapper">
        <div class="student-borrowing-input-container">
            <div class="student-borrowing-input-container-inner">
                <!-- SEARCH STUDENT # -->
                <form class="search-student-number" action="client.php?page=borrowing" method="POST">
                    <div class="input-container">
                        <label for="studentNumber">Student #</label>
                        <input type="text" name="studentNumber" value="<?php echo isset($studentIDUserDisplay) ? $studentIDUserDisplay : '' ?>">
                    </div>

                    <!-- STUDENT NAME -->
                    <div class="input-container">
                        <label for="studentName">Student Name</label>
                        <input type="text" name="studentName" value="<?php echo isset($studentNameDisplay) ? $studentNameDisplay : '' ?>">
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
                </form>

                <hr class="seperator-line-table">

                <!-- SEARCH BOOKS -->
                <div class="search-books-information">
                    
                </div>

                <!-- BOOK TABLE [ADD-TO-LIST] -->
                <table>
                    <thead>
                        <tr>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>ISBN</th>
                            <th>Category</th>
                            <th>Copyright</th>
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
                                    <form action="client.php?page=borrowing" method="POST">
                                        <input type="hidden" name="bookID" value="<?php echo $books['BookID'] ?>">
                                        <input type="hidden" name="userID" value="<?php echo isset($studentIDDisplay) ? $studentIDDisplay : '' ?>">

                                        <input type="hidden" name="studentNumber" value="<?php echo isset($studentIDUserDisplay) ? $studentIDUserDisplay : '' ?>">
                                        <input type="hidden" name="date" value="<?php echo date("Y-m-d") ?>">
                                        <input type="hidden" name="time" value="<?php echo date("H:i:s") ?>">
                                        <input type="hidden" name="studentName" value="<?php echo isset($studentNameDisplay) ? $studentNameDisplay : '' ?>">
                                        <input type="hidden" name="course" value="<?php echo isset($courseDisplay) ? $courseDisplay : '' ?>">
                                        <input type="hidden" name="major" value="<?php echo isset($majorDisplay) ? $majorDisplay : '' ?>">
                                        <input type="hidden" name="yearLevel" value="<?php echo isset($yearLevelDisplay) ? $yearLevelDisplay : '' ?>">

                                        <button type="submit" name="addToListBook" id="add_to_list">
                                            Add
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- END BOOK BORROWING OUTPUT -->
                    </tbody>
                </table>

                <!-- BOOK TABLE [BORROWING] -->
                <?php if (isset($displayAddToList)): ?>
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
                            
                                <?php foreach ($displayAddToList as $addToList): ?>
                                    <tr>
                                        <td><?php echo $addToList['BookID'] ?></td>
                                        <td><?php echo $addToList['Title'] ?></td>
                                        <td><?php echo $addToList['Author'] ?></td>
                                        <td><?php echo $addToList['ISBN'] ?></td>
                                        <td><?php echo $addToList['Category'] ?></td>
                                        <td><?php echo $addToList['CopyRight'] ?></td>
                                        <td>
                                            <form action="client.php?page=borrowing" method="POST">
                                                <input type="hidden" name="bookID" value="<?php echo $addToList['BookID'] ?>">
                                                <input type="hidden" name="userID" value="<?php echo $addToList['UserID'] ?>">
                                                <input type="hidden" name="date" value="<?php echo date("Y-m-d") ?>">
                                                <input type="hidden" name="time" value="<?php echo date("H:i:s") ?>">

                                                <input type="hidden" name="studentNumber" value="<?php echo isset($studentIDUserDisplay) ? $studentIDUserDisplay : '' ?>">
                                                <input type="hidden" name="studentName" value="<?php echo isset($studentNameDisplay) ? $studentNameDisplay : '' ?>">
                                                <input type="hidden" name="course" value="<?php echo isset($courseDisplay) ? $courseDisplay : '' ?>">
                                                <input type="hidden" name="major" value="<?php echo isset($majorDisplay) ? $majorDisplay : '' ?>">
                                                <input type="hidden" name="yearLevel" value="<?php echo isset($yearLevelDisplay) ? $yearLevelDisplay : '' ?>">

                                                <button type="submit" name="borrowBook" id="borrowed">
                                                    Borrow
                                                </button>

                                                <button type="submit" name="deleteAddtoListBook" id="removed">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ADD STUDENT FOR BOOK BORROWING -->
    <?php ?>
        
    <?php ?>
</div>