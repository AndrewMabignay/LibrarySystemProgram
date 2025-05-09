<?php 

echo 'Hello Student List';

if (isset($_POST['addStudent'])) {
    $studentNo = $_POST['studentNo'];
    $studentName = $_POST['studentName'];
    $studentCourse = $_POST['studentCourse'];
    $studentMajor = $_POST['studentMajor'];
    $studentYearLevel = $_POST['studentYearLevel'];
    $studentStatus = $_POST['studentStatus'];
    $studentPassword = $_POST['password'];
    $studentPasswordVerify = $_POST['verifyPassword'];

    require_once '../function/Model.php';
    $addStudent = new Model();
    $addStudent->setDatabaseTable('student');
    $addStudentPrompting = $addStudent->addStudent($studentNo, $studentName, $studentCourse, $studentMajor, $studentYearLevel, $studentStatus, $studentPassword, $studentPasswordVerify);
    echo $addStudentPrompting;
}

?>

<div class="student-container">
    <header>

    </header>

    <div class="student-list-container">

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
    </div>
</div>