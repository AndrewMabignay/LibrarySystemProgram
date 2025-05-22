<?php 

require_once '../function/Model.php';

// ------------  ADD STUDENT ------------ 
if (isset($_POST['addUserVerify'])) {
    $addUserVerify = true;    
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

// ------------ SEARCH STUDENT ------------  
if (isset($_POST['searchStudent'])) {
    $searchStudentID = $_POST['searchStudentNumber'];

    $searchStudentOutput = new Model();
    $resultStudentOutput = $searchStudentOutput->searchStudentID($searchStudentID);
}


// ------------ EDIT STUDENT ------------
if (isset($_POST['editUserVerify'])) {
    $userIDEdit = $_POST['usernameEdit'];
    $userUsernameEdit = $_POST['passwordEdit'];
    $userPasswordEdit = $_POST['studentCourseEdit'];
    $userRoleEdit = $_POST['roleEdit'];
    $userStatusEdit = $_POST['statusEdit'];

    $editUserVerify = true;
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
$showUserManagement = new Model();
$dataUsers = $showUserManagement->showUserManagement();

?>

<div class="student-container">
    <form action="admin.php?page=studentList" method="POST" class="student-container-form">
        <h2>User Management</h2>    

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
            <button type="submit" name="refreshUser">
                <i class="fas fa-sync"></i>
            </button>

            <!-- ADD BUTTON -->
            <button type="submit" name="addUserVerify">
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
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($refreshTable) && $refreshTable == true): ?>        
                    <?php foreach ($dataUsers as $users): ?>
                        <tr>
                            <td><?php echo $users['ID'] ?></td>
                            <td><?php echo $users['Username'] ?></td>
                            <td><?php echo $users['Role'] ?></td>
                            <td><?php echo $users['Status'] ?></td>
                            <td>
                                <form action="admin.php?page=userManagement" method="POST">
                                    <input type="hidden" name="usernameEdit" value="<?php echo $users['Username'] ?>">
                                    <input type="hidden" name="passwordEdit" value="<?php echo $users['Role'] ?>">
                                    <input type="hidden" name="roleEdit" value="<?php echo $users['Role'] ?>">
                                    <input type="hidden" name="statusEdit" value="<?php echo $users['Status'] ?>">
                                
                                    <button type="submit" name="editUserVerify">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php foreach ($dataUsers as $users): ?>
                        <tr>
                            <td><?php echo $users['ID'] ?></td>
                            <td><?php echo $users['Username'] ?></td>
                            <td><?php echo $users['Role'] ?></td>
                            <td><?php echo $users['Status'] ?></td>
                            <td>
                                <form action="admin.php?page=userManagement" method="POST">
                                    <input type="hidden" name="usernameEdit" value="<?php echo $users['Username'] ?>">
                                    <input type="hidden" name="passwordEdit" value="<?php echo $users['Role'] ?>">
                                    <input type="hidden" name="roleEdit" value="<?php echo $users['Role'] ?>">
                                    <input type="hidden" name="statusEdit" value="<?php echo $users['Status'] ?>">
                                
                                    <button type="submit" name="editUserVerify">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- VIEW ADD FORM -->
    <?php if(isset($addUserVerify) && $addUserVerify == true): ?>
        <div class="overlay"></div>
        <!-- ADD STUDENT FORM -->
        <form action="admin.php?page=studentList" method="POST" class="add-container">
            <h2>
                <i class="fas fa-user-graduate"></i>
                Add User
            </h2>

            <div class="grid-container">
                

                
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
    <?php if(isset($editUserVerify) && $editUserVerify == true): ?>
        <div class="overlay"></div>
        <!-- EDIT STUDENT FORM -->
        <form action="admin.php?page=studentList" method="POST" class="edit-container">
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