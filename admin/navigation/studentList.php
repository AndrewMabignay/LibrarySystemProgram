<?php 

require_once '../function/Model.php';

// ------------  ADD STUDENT ------------ 
if (isset($_POST['addStudentVerify'])) {
    $addVerify = true;    
}


if (isset($_POST['addStudent'])) {
    $studentNo = $_POST['studentNo'];
    $studentName = $_POST['studentName'];
    $studentCourse = $_POST['studentCourse'];
    $studentMajor = $_POST['studentMajor'];
    $studentYearLevel = $_POST['studentYearLevel'];
    $studentStatus = $_POST['studentStatus'];
    $studentPassword = $_POST['password'];
    $studentPasswordVerify = $_POST['verifyPassword'];

    $addVerify = true;

    $addStudent = new Model();
    $addStudent->setDatabaseTable('student');
    $addStudentPrompting = $addStudent->addStudent($studentNo, $studentName, $studentCourse, $studentMajor, $studentYearLevel, $studentStatus, $studentPassword, $studentPasswordVerify);
    // echo $addStudentPrompting;
}

if (isset($_POST['closeAdd'])) {
    unset($addVerify);
}

if (isset($_POST['closeEdit'])) {
    unset($editVerify);
}

// ------------ SEARCH STUDENT ------------  
if (isset($_POST['searchStudent'])) {
    $searchStudentID = $_POST['searchStudentNumber'];

    $searchStudentOutput = new Model();
    $resultStudentOutput = $searchStudentOutput->searchStudentID($searchStudentID);
}


// ------------ EDIT STUDENT ------------
if (isset($_POST['editStudentVerify'])) {
    $studentIDEdit = $_POST['studentIdEdit'];
    $studentNameEdit = $_POST['studentNameEdit'];
    $studentCourseEdit = $_POST['studentCourseEdit'];
    $studentMajorEdit = $_POST['studentMajorEdit'];
    $studentYearLevelEdit = $_POST['studentYearLevelEdit'];
    $studentStatusEdit = $_POST['studentStatusEdit'];

    $editVerify = true;
}

if (isset($_POST['updateStudent'])) {
    $currentStudentNo = $_POST['currentStudentNo'];

    $updateStudentNo = $_POST['studentNo'];
    $updateStudentName = $_POST['studentName'];
    $updateStudentCourse = $_POST['studentCourse'];
    $updateStudentMajor = $_POST['studentMajor'];
    $updateStudentYearLevel = $_POST['studentYearLevel'];
    $updateStudentStatus = $_POST['studentStatus'];
    $updateStudentPassword = $_POST['password'];
    $updateStudentPasswordVerify = $_POST['verifyPassword'];

    $editVerify = true;

    $updateStudent = new Model();
    $updatePrompt = $updateStudent->editStudent($currentStudentNo, $updateStudentNo, $updateStudentName, $updateStudentCourse, $updateStudentMajor, $updateStudentYearLevel, $updateStudentStatus, $updateStudentPassword, $updateStudentPasswordVerify);
    // echo $updatePrompt;

    $currentStudentUpdate = new Model();
    $dataStudent = $currentStudentUpdate->studentID($currentStudentNo);
    foreach ($dataStudent as $data) {
        $studentIDEdit = $data['StudentID'];
        $studentNameEdit = $data['StudentName'];
        $studentCourseEdit = $data['Course'];
        $studentMajorEdit = $data['Major'];
        $studentYearLevelEdit = $data['YearLevel'];
        $studentStatusEdit = $data['Status'];
    }

    if ($updatePrompt == 'Successfully Password Updated') {
        $updateStudentPassword = '';
        $updateStudentPasswordVerify = '';
    }
}

// ------------ REFRESH TABLE ------------
if (isset($_POST['refresh'])) {
    $refreshTable = true;
}

// ------------ SHOW STUDENT ------------
$showStudents = new Model();
$dataStudents = $showStudents->showStudent();

?>

<div class="student-container">
    <form action="admin.php?page=studentList" method="POST" class="student-container-form">
        <h2>List of Students</h2>    

        <div class="input-container">
            
            <!-- SEARCH INPUT -->
            <div class="search-container">
                <input type="text" name="searchStudentNumber">
                <button type="submit" name="searchStudent">
                    <label for="">
                        <i class="fas fa-search"></i>
                    </label>
                </button>
            </div>

            <!-- REFRESH BUTTON -->
            <button type="submit" name="refreshStudent">
                <i class="fas fa-sync"></i>
            </button>

            <!-- ADD BUTTON -->
            <button type="submit" name="addStudentVerify">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </form>

    <!-- SEPERATOR LINE -->
    <hr class="seperator-line">
    
    <!-- STUDENT LIST TABLE -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Student #</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Major</th>
                    <th>Year Level</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- FIRST CONDITION -->
                <?php if (isset($searchStudentID) && $searchStudentID != ''): ?>
                    <?php if (isset($resultStudentOutput) && count($resultStudentOutput)): ?>
                        <?php foreach ($resultStudentOutput as $students): ?>
                            <tr>
                                <td><?php echo $students['StudentID'] ?></td>
                                <td><?php echo $students['StudentName'] ?></td>
                                <td><?php echo $students['Course'] ?></td>
                                <td><?php echo $students['Major'] ?></td>
                                <td><?php echo $students['YearLevel'] ?></td>
                                <td><?php echo $students['Status'] ?></td>
                                <td>
                                    <form action="admin.php?page=studentList" method="POST">
                                        <input type="hidden" name="studentIdEdit" value="<?php echo $students['StudentID'] ?>">
                                        <input type="hidden" name="studentNameEdit" value="<?php echo $students['StudentName'] ?>">
                                        <input type="hidden" name="studentCourseEdit" value="<?php echo $students['Course'] ?>">
                                        <input type="hidden" name="studentMajorEdit" value="<?php echo $students['Major'] ?>">
                                        <input type="hidden" name="studentYearLevelEdit" value="<?php echo $students['YearLevel'] ?>">
                                        <input type="hidden" name="studentStatusEdit" value="<?php echo $students['Status'] ?>">
                                    
                                        <button type="submit" name="editStudentVerify">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No student found.</td>
                        </tr>
                    <?php endif; ?>

                <!-- SECOND CONDITION -->
                <?php elseif (isset($resultStudentOutput) && $searchStudentID == ''): ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">No student found.</td>
                    </tr>

                <!-- THIRD CONDITION -->
                <?php elseif (isset($refreshTable) && $refreshTable == true): ?>
                    <?php foreach($dataStudents as $students): ?>
                        <tr>
                            <td><?php echo $students['StudentID'] ?></td>
                            <td><?php echo $students['StudentName'] ?></td>
                            <td><?php echo $students['Course'] ?></td>
                            <td><?php echo $students['Major'] ?></td>
                            <td><?php echo $students['YearLevel'] ?></td>
                            <td><?php echo $students['Status'] ?></td>
                            <td>
                                <form action="admin.php?page=studentList" method="POST">
                                    <input type="hidden" name="studentIdEdit" value="<?php echo $students['StudentID'] ?>">
                                    <input type="hidden" name="studentNameEdit" value="<?php echo $students['StudentName'] ?>">
                                    <input type="hidden" name="studentCourseEdit" value="<?php echo $students['Course'] ?>">
                                    <input type="hidden" name="studentMajorEdit" value="<?php echo $students['Major'] ?>">
                                    <input type="hidden" name="studentYearLevelEdit" value="<?php echo $students['YearLevel'] ?>">
                                    <input type="hidden" name="studentStatusEdit" value="<?php echo $students['Status'] ?>">
                                
                                    <button type="submit" name="editStudentVerify">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <!-- LAST CONDITION -->
                <?php else: ?>
                    <?php foreach($dataStudents as $students): ?>
                        <tr>
                            <td><?php echo $students['StudentID'] ?></td>
                            <td><?php echo $students['StudentName'] ?></td>
                            <td><?php echo $students['Course'] ?></td>
                            <td><?php echo $students['Major'] ?></td>
                            <td><?php echo $students['YearLevel'] ?></td>
                            <td><?php echo $students['Status'] ?></td>
                            <td>
                                <form action="admin.php?page=studentList" method="POST">
                                    <input type="hidden" name="studentIdEdit" value="<?php echo $students['StudentID'] ?>">
                                    <input type="hidden" name="studentNameEdit" value="<?php echo $students['StudentName'] ?>">
                                    <input type="hidden" name="studentCourseEdit" value="<?php echo $students['Course'] ?>">
                                    <input type="hidden" name="studentMajorEdit" value="<?php echo $students['Major'] ?>">
                                    <input type="hidden" name="studentYearLevelEdit" value="<?php echo $students['YearLevel'] ?>">
                                    <input type="hidden" name="studentStatusEdit" value="<?php echo $students['Status'] ?>">
                                
                                    <button type="submit" name="editStudentVerify">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <!-- END CONDITION -->
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- VIEW ADD FORM -->
    <?php if(isset($addVerify) && $addVerify == true): ?>
        <div class="overlay"></div>
        <!-- ADD STUDENT FORM -->
        <form action="admin.php?page=studentList" method="POST" class="add-container">
            <h2>
                <i class="fas fa-user-graduate"></i>
                Add Student
            </h2>

            <div class="grid-container">
                <!-- STUDENT NUMBER CONTAINER -->
                <div class="input-container">
                    <label for="studentNo">Student #</label>
                    <input type="text" id="studentNo" name="studentNo" value="<?php  ?>">
                </div>

                <!-- STUDENT NAME CONTAINER -->
                <div class="input-container">
                    <label for="studentName">Student Name</label>
                    <input type="text" id="studentNo" name="studentName" value="<?php  ?>">
                </div>

                <!-- COURSE CONTAINER -->
                <div class="input-container">
                    <label for="studentCourse">Course</label>
                    <input type="text" id="studentCourse" name="studentCourse" value="<?php  ?>">
                </div>

                <!-- MAJOR CONTAINER -->
                <div class="input-container">
                    <label for="studentMajor">Major</label>
                    <input type="text" id="studentMajor" name="studentMajor" value="<?php  ?>">
                </div>

                <!-- YEAR LEVEL CONTAINER -->
                <div class="input-container">
                    <label for="studentYearLevel">Year Level</label>
                    <input type="text" id="studentYearLevel" name="studentYearLevel" value="<?php  ?>">
                </div>

                <!-- STATUS CONTAINER -->
                <div class="input-container">
                    <label for="studentStatus">Status</label>
                    <select name="studentStatus" id="studentStatus">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <!-- PASSWORD CONTAINER -->
                <div class="input-container">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" value="">
                </div>

                <!-- VERIFY PASSWORD CONTAINER -->
                <div class="input-container">
                    <label for="verifyPassword">Verify Password</label>
                    <input type="password" id="verifyPassword" name="verifyPassword" value="">
                </div>
            </div>

            <?php if (isset($addStudentPrompting)): ?>
                <div class="alert-form">
                    <?php if ($addStudentPrompting == 'Successfully Inserted'): ?>
                        <p style="color: green"><?php echo $addStudentPrompting; ?></p>
                    <?php else: ?>
                        <p><?php echo $addStudentPrompting; ?></p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p></p>
            <?php endif; ?>

            <div class="button-container">
                <button type="submit" name="closeAdd" class="back">
                    <i class="fas fa-arrow-left"></i> 
                    BACK
                </button>
                <button type="submit" name="addStudent" class="save">
                    <i class="fas fa-plus"></i>
                    CREATE
                </button>
            </div>
        </form>                
    <?php endif; ?>

    <!-- VIEW EDIT FORM -->
    <?php if(isset($editVerify) && $editVerify == true): ?>
        <div class="overlay"></div>
        <!-- EDIT STUDENT FORM -->
        <form action="admin.php?page=studentList" method="POST" class="edit-container">
            <h2>
                <i class="fas fa-user-graduate"></i>
                Edit Student
            </h2>

            <input type="hidden" name="currentStudentNo" value="<?php echo isset($studentIDEdit) ? $studentIDEdit : '' ?>">    

            <div class="grid-container">
                <!-- STUDENT NUMBER CONTAINER -->
                <div class="input-container">
                    <label for="studentNo">Student #</label>
                    <input type="text" id="studentNo" name="studentNo" value="<?php echo isset($studentIDEdit) ? $studentIDEdit : '' ?>">
                </div>

                <!-- STUDENT NAME CONTAINER -->
                <div class="input-container">
                    <label for="studentName">Student Name</label>
                    <input type="text" id="studentNo" name="studentName" value="<?php echo isset($studentNameEdit) ? $studentNameEdit : '' ?>">
                </div>

                <!-- COURSE CONTAINER -->
                <div class="input-container">
                    <label for="studentCourse">Course</label>
                    <input type="text" id="studentCourse" name="studentCourse" value="<?php echo isset($studentCourseEdit) ? $studentCourseEdit : '' ?>">
                </div>

                <!-- MAJOR CONTAINER -->
                <div class="input-container">
                    <label for="studentMajor">Major</label>
                    <input type="text" id="studentMajor" name="studentMajor" value="<?php echo isset($studentMajorEdit) ? $studentMajorEdit : '' ?>">
                </div>

                <!-- YEAR LEVEL CONTAINER -->
                <div class="input-container">
                    <label for="studentYearLevel">Year Level</label>
                    <input type="text" id="studentYearLevel" name="studentYearLevel" value="<?php echo isset($studentYearLevelEdit) ? $studentYearLevelEdit : '' ?>">
                </div>

                <!-- STATUS CONTAINER -->
                <div class="input-container">
                    <label for="studentStatus">Status</label>
                    <select name="studentStatus" id="studentStatus">
                        <option value="Active" <?php echo isset($studentStatusEdit) && $studentStatusEdit == 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?php echo isset($studentStatusEdit) && $studentStatusEdit == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <!-- PASSWORD CONTAINER -->
                <div class="input-container">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" value="<?php echo isset($updateStudentPassword) ? $updateStudentPassword : '' ?>">
                </div>

                <!-- VERIFY PASSWORD CONTAINER -->
                <div class="input-container">
                    <label for="verifyPassword">Verify Password</label>
                    <input type="password" id="verifyPassword" name="verifyPassword" value="<?php echo isset($updateStudentPasswordVerify) ? $updateStudentPasswordVerify : '' ?>">
                </div>
            </div>

            <?php if (isset($updatePrompt)): ?>
                <div class="alert-form">
                    <?php if ($updatePrompt == 'Successfully Password Updated' || $updatePrompt == 'Successfully Updated'): ?>
                        <p style="color: green"><?php echo $updatePrompt; ?></p>
                    <?php elseif ($updatePrompt == 'No changes made.' || $updatePrompt == 'No password changes made.'): ?>
                        <p style="color: #222831"><?php echo $updatePrompt; ?></p>
                    <?php else: ?>
                        <p><?php echo $updatePrompt; ?></p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p></p>
            <?php endif; ?>

            <div class="button-container">
                <button type="submit" name="closeEdit" class="back">
                    <i class="fas fa-arrow-left"></i> 
                    BACK
                </button>
                <button type="submit" name="updateStudent" class="save">
                    <i class="fas fa-sync-alt"></i>
                    UPDATE
                </button>
            </div>      
        </form>
    <?php endif; ?>
    </div>
</div>