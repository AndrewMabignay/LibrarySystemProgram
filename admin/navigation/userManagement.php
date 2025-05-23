<?php 

require_once '../function/Model.php';

// ------------  ADD STUDENT ------------ 
if (isset($_POST['addUserVerify'])) {
    $addUserVerify = true;    
}


if (isset($_POST['addUser'])) {
    $userUsername = $_POST['userUsername'];
    $userPassword = $_POST['userPassword'];
    $userStatus = $_POST['userStatus'];

    $addUser = new Model();
    $addUserPrompting = $addUser->addUserManagement($userUsername, $userPassword, '', $userStatus);
    
    $addVerify = true;
}

if (isset($_POST['closeAdd'])) {
    unset($addVerify);
}




// ------------ EDIT STUDENT ------------
if (isset($_POST['editUserVerify'])) {
    $userIDEdit = $_POST['idEdit'];
    $userUsernameEdit = $_POST['usernameEdit'];
    $userStatusEdit = $_POST['statusEdit'];

    $editUserVerify = true;
}

if (isset($_POST['updateStudent'])) {
    $userIDEdit = $_POST['userID'];
    $userUsernameEdit = $_POST['userUsername'];
    $userPasswordEdit = $_POST['userPassword'];
    $userStatusEdit = $_POST['userStatus'];

    $updateUser = new Model();
    $updatePrompt = $updateUser->editUserManagement($userIDEdit, $userUsernameEdit, $userPasswordEdit, $userStatusEdit);

    $editUserVerify = true;
}

// ------------ REFRESH TABLE ------------
if (isset($_POST['refresh'])) {
    $refreshTable = true;
}

// ------------ SHOW STUDENT ------------
$showUserManagement = new Model();
$dataUsers = $showUserManagement->showUserManagement();

// ------------ SEARCH STUDENT ------------  
if (isset($_POST['searchUser'])) {
    $searchUserInput = $_POST['searchUserInput'];

    $dataUsers = $showUserManagement->searchUserManagement($searchUserInput);
}

?>

<div class="student-container">
    <form action="admin.php?page=userManagement" method="POST" class="student-container-form">
        <h2>User Management</h2>    

        <div class="input-container">
            
            <!-- SEARCH INPUT -->
            <div class="search-container">
                <input type="text" name="searchUserInput">
                <button type="submit" name="searchUser">
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
                                    <input type="hidden" name="idEdit" value="<?php echo $users['ID'] ?>">
                                    <input type="hidden" name="usernameEdit" value="<?php echo $users['Username'] ?>">
                                    <!--  -->
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
        <form action="admin.php?page=userManagement" method="POST" class="add-container">
            <h2>
                <i class="fas fa-user"></i>
                Add User
            </h2>

            <div class="grid-container">
                <!-- USERNAME -->
                <div class="input-container">
                    <label for="userUsername">Username</label>
                    <input type="text" id="userUsername" name="userUsername" value="<?php  ?>">
                </div>
                
                <!-- PASSWORD -->
                <div class="input-container">
                    <label for="userPassword">Password</label>
                    <input type="text" id="userPassword" name="userPassword" value="<?php  ?>">
                </div>

                <!-- STATUS -->
                <div class="input-container">
                    <label for="userStatus">Status</label>
                    <select name="userStatus" id="userStatus">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>                
            </div>

            <?php if (isset($addUserPrompting)): ?>
                <div class="alert-form">
                    <?php if ($addUserPrompting == 'Successfully Inserted'): ?>
                        <p style="color: green"><?php echo $addUserPrompting; ?></p>
                    <?php else: ?>
                        <p><?php echo $addUserPrompting; ?></p>
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
                <button type="submit" name="addUser" class="save">
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
        <form action="admin.php?page=userManagement" method="POST" class="edit-container">
            <input type="hidden" name="currentStudentNo" value="<?php echo isset($studentIDEdit) ? $studentIDEdit : '' ?>">    

            <h2>
                <i class="fas fa-user"></i>
                Edit User
            </h2>

            <input type="hidden" name="currentStudentNo" value="<?php echo isset($studentIDEdit) ? $studentIDEdit : '' ?>">    

            <div class="grid-container">
                <!-- ID -->
                <div class="input-container">
                    <label for="userID">ID</label>
                    <input type="text" id="userID" name="userID" value="<?php echo isset($userIDEdit) ? $userIDEdit : '' ?>" readonly>
                </div>

                <!-- USERNAME -->
                <div class="input-container">
                    <label for="userUsername">Username</label>
                    <input type="text" id="userUsername" name="userUsername" value="<?php echo isset($userUsernameEdit) ? $userUsernameEdit : '' ?>">
                </div>
                
                <!-- PASSWORD -->
                <div class="input-container">
                    <label for="userPassword">Password</label>
                    <input type="text" id="userPassword" name="userPassword" value="<?php  ?>">
                </div>

                <!-- STATUS -->
                <div class="input-container">
                    <label for="userStatus">Status</label>
                    <select name="userStatus" id="userStatus">
                        <option value="Active" <?php echo isset($userStatus) && $userStatus == 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?php echo isset($userStatus) && $userStatus == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
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