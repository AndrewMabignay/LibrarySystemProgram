<?php 

echo 'Hello Student List';

// ADD STUDENT
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

    require_once '../function/Model.php';
    $addStudent = new Model();
    $addStudent->setDatabaseTable('student');
    $addStudentPrompting = $addStudent->addStudent($studentNo, $studentName, $studentCourse, $studentMajor, $studentYearLevel, $studentStatus, $studentPassword, $studentPasswordVerify);
    echo $addStudentPrompting;
}

// EDIT STUDENT
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

    require_once '../function/Model.php';
    $updateStudent = new Model();
    $updatePrompt = $updateStudent->editStudent($currentStudentNo, $updateStudentNo, $updateStudentName, $updateStudentCourse, $updateStudentMajor, $updateStudentYearLevel, $updateStudentStatus, $updateStudentPassword, $updateStudentPasswordVerify);
    echo $updatePrompt;

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
}

// SHOW STUDENT
require_once '../function/Model.php';

$showStudents = new Model();
$dataStudents = $showStudents->showStudent();

?>

<div class="student-container">
    <header>
        <form action="admin.php?page=studentList" method="POST">
            <button type="submit" name="addStudentVerify">
                Add
            </button>
        </form>
    </header>

    <div class="student-list-container">
    
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
                    <!-- CONDITIONING -->
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
                                    <input type="text" name="studentIdEdit" value="<?php echo $students['StudentID'] ?>">
                                    <input type="text" name="studentNameEdit" value="<?php echo $students['StudentName'] ?>">
                                    <input type="text" name="studentCourseEdit" value="<?php echo $students['Course'] ?>">
                                    <input type="text" name="studentMajorEdit" value="<?php echo $students['Major'] ?>">
                                    <input type="text" name="studentYearLevelEdit" value="<?php echo $students['YearLevel'] ?>">
                                    <input type="text" name="studentStatusEdit" value="<?php echo $students['Status'] ?>">
                                
                                    <button type="submit" name="editStudentVerify">
                                           

                                        Edit
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
        </div>

        <!-- VIEW ADD FORM -->
        <?php if(isset($addVerify) && $addVerify == true): ?> 
            <!-- ADD STUDENT FORM -->
            <form action="admin.php?page=studentList" method="POST">
                
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

                <button type="submit" name="addStudent">ADD</button>
            </form>                
        <?php endif; ?>

        <!-- VIEW EDIT FORM -->
        <?php if(isset($editVerify) && $editVerify == true): ?>

            <!-- EDIT STUDENT FORM -->
            <form action="admin.php?page=studentList" method="POST">
                <input type="hidden" name="currentStudentNo" value="<?php echo isset($studentIDEdit) ? $studentIDEdit : '' ?>">    

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

                <button type="submit" name="updateStudent">UPDATE</button>
            </form>
        <?php endif; ?>
    </div>
</div>