<?php

session_start();

if (!isset($_SESSION['id'])):
    header("Location: ../auth/login.php");
    exit;
elseif ($_SESSION['role'] !== "Student"):
    header("Location: ../admin/admin.php?page=dashboard");
    exit;
endif;

if (isset($_POST['logout'])) {
    require_once '../function/Model.php';
    $logout = new Model();
    $logout->logout();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

if (isset($_POST['dashboard']) || $page == 'dashboard') {
    ob_start();
    include('navigation/dashboard.php');
    $content = ob_get_clean();
} else if (isset($_POST['borrowing']) || $page == 'borrowing') {
    ob_start();
    include('navigation/borrowing.php');
    $content = ob_get_clean();
} else if (isset($_POST['returning']) || $page == 'returning') {
    ob_start();
    include('navigation/returning.php');
    $content = ob_get_clean();
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- CSS FILES -->
    <link rel="stylesheet" href="../public/css/general.css">
    <link rel="stylesheet" href="../public/css/admin/admin.css">
    <link rel="stylesheet" href="../public/css/admin/borrowingList.css">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!-- SIDEBAR NAVIGATION -->
    <nav>

        <!-- BUTTON FORMS -->
        <div class="form-buttons-container">
            <form action="client.php?page=dashboard" method="GET">
                <button type="submit" name="page" value="dashboard">
                    <i class="fas fa-columns"></i> Dashboard
                </button>
                <button type="submit" name="page" value="borrowing">
                    <i class="fas fa-user"></i> Borrowing
                </button>
                <button type="submit" name="page" value="returning">
                    <i class="fas fa-user"></i> Returning
                </button>
            </form>

            <!-- LOGOUT FORM -->
            <form action="client.php" method="POST">
                <button type="submit" name="logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>

        <!-- BOX VISUALIZATION -->
        <div class="box-container"></div>
    </nav>

    <!-- CONTENT CONTAINER -->
    <div class="container">
        <header class="header-one">
            <i class="fa-solid fa-user-gear"></i>
            <p>Hello, <?php echo $_SESSION['username'] . ' ' . '[' . $_SESSION['role'] . ']' ?></p>
        </header>

        <?php echo $content ?>
    </div>
    
</body>
</html>