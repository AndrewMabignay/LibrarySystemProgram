<?php 

require_once '../function/Model.php';

if (isset($_POST['searchStudentID'])) {
    $studentIDDisplay = $_POST['studentNumber'];

    $searchStudentID = new Model();
    $studentInformation = $searchStudentID->studentID($studentIDDisplay);

    echo count($studentInformation);

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

$showBook = new Model();
$dataBook = $showBook->showBook();

?>

<div class="borrowing-list-container">
    

    <hr class="seperator-line">

    <!-- LIST OF BOOKS -->
    <div class="table-wrapper">
        <div class="student-borrowing-input-container">
            <form action="admin.php?page=borrowing" method="POST">
                <!-- SEARCH STUDENT # -->
                <div class="search-student-number">
                    <div class="input-container">
                        <label for="studentNumber">Student #</label>
                        <input type="text" name="studentNumber" value="<?php echo isset($studentIDDisplay) ? $studentIDDisplay : '' ?>">
                    </div>

                    <!-- DATE -->
                    <div class="input-container">
                        <label for="date">Date</label>
                        <input type="text" name="date" value="<?php echo date("Y-m-d") ?>">
                    </div>

                    <!-- TIME -->
                    <div class="input-container">
                        <label for="major">Time</label>
                        <input type="text" name="time" value="<?php echo date("h:i:s A") ?>">
                    </div>

                    <button type="submit" name="searchStudentID">
                        SEARCH STUDENT
                    </button>
                </div>

                <!-- STUDENT PERSONAL INFORMATION -->
                <div class="student-personal-information">

                    <!-- STUDENT NAME -->
                    <div class="input-container">
                        <label for="studentName">Student Name</label>
                        <input type="text" name="studentName" value="<?php echo isset($studentNameDisplay) ? $studentNameDisplay : '' ?>">
                    </div>

                    <?php date_default_timezone_set('Asia/Manila'); ?>

                    

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
                                    
                                
                                    <input type="hidden" name="borrowID" value="<?php echo $books['BookID'] ?>">



                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <!-- END BOOK BORROWING OUTPUT -->
                </tbody>
            </table>
            </form>
            
            
        </div>
    

        

        <table>
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- SEARCH OUTPUT -->
                <?php if(isset($searchField) && $searchField != ''): ?>
                    <?php if(isset($searchDataBook) && count($searchDataBook) > 0): ?>
                        <?php foreach($searchDataBook as $books): ?>
                            <tr>
                                <td><?php echo $books['BookID'] ?></td>
                                <td><?php echo $books['Title'] ?></td>
                                <td><?php echo $books['Author'] ?></td>
                                <td><?php echo $books['ISBN'] ?></td>
                                <td><?php echo $books['Category'] ?></td>
                                <td>
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <button type="submit" name="editBookVerify">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No Books Found!</td>
                        </tr>    
                    <?php endif; ?>

                <!-- SEARCH NULL VALUES -->
                <?php elseif(isset($searchField) && $searchField == ''): ?>
                    <tr>
                        <td colspan="7">No Books Found!</td>
                    </tr>

                <!-- REFRESH TABLE -->
                <?php elseif(isset($refreshTable) && $refreshTable == true): ?>
                    <?php if(count($dataBook) > 0): ?>
                        <?php foreach($dataBook as $books): ?>
                            <tr>
                                <td><?php echo $books['BookID'] ?></td>
                                <td><?php echo $books['Title'] ?></td>
                                <td><?php echo $books['Author'] ?></td>
                                <td><?php echo $books['ISBN'] ?></td>
                                <td><?php echo $books['Category'] ?></td>
                                <td><?php echo $books['Copies'] ?></td>
                                <td>
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <input type="hidden" value="<?php echo $books['Copies'] ?>" name="copies">
                                        <button type="submit" name="edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Empty Books</td>
                        </tr>
                    <?php endif; ?>

                <!-- DEFAULT -->
                <?php else: ?>
                    <?php if(count($dataBook) > 0): ?>
                        <?php foreach($dataBook as $books): ?>
                            <tr>
                                <td><?php echo $books['BookID'] ?></td>
                                <td><?php echo $books['Title'] ?></td>
                                <td><?php echo $books['Author'] ?></td>
                                <td><?php echo $books['ISBN'] ?></td>
                                <td><?php echo $books['Category'] ?></td>
                                <td><?php echo $books['Copies'] ?></td>
                                <td>
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <input type="hidden" value="<?php echo $books['Copies'] ?>" name="copies">
                                        <button type="submit" name="edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Empty Books</td>
                        </tr>
                    <?php endif; ?>
                <?php endif; // END CONDITION ?> 
            </tbody>
        </table>
    </div>

    <!-- ADD STUDENT FOR BOOK BORROWING -->
    <?php ?>
        
    <?php ?>
</div>