<?php

session_start();

if (!isset($_SESSION['id'])):
    header("Location: ../auth/login.php");
    exit;
elseif ($_SESSION['role'] !== "Student"):
    header("Location: ../admin/admin.php?page=dashboard");
    exit;
endif;

// echo 'Hello World!';

if (isset($_POST['logout'])) {
    require_once '../function/Model.php';
    $logout = new Model();
    $logout->logout();
}

$hash = password_hash('2022-10029', PASSWORD_DEFAULT);
echo $hash;
if (password_verify('2022-10029', $hash)) {
    echo true;
}


?>

<form action="client.php" method="POST" class="logout">
            <h2>Log out mo na student</h2>
            <button type="submit" name="logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>