<?php 

session_start();

if (!isset($_SESSION['id'])):
    header("Location: ../auth/login.php");
    exit;
elseif ($_SESSION['role'] !== "Admin"):
    header("Location: ../client/client.php");
    exit;
endif;

if (isset($_POST['logout'])) {
    require_once '../function/Model.php';
    $logout = new Model();
    $logout->logout();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// echo $page;

if (isset($_POST['book']) || $page == 'book') {
    ob_start();
    include('navigation/book.php');
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
else if (isset($_POST['dashboard']) || $page == 'dashboard') {
    ob_start();
    include('navigation/dashboard.php');
    $content = ob_get_clean();
} else if (isset($_POST['result']) || $page == 'inventoryStatus') {
    ob_start();
    include('navigation/inventoryStatus.php');
    $content = ob_get_clean();
} else if (isset($_POST['studentList']) || $page == 'studentList') {
    ob_start();
    include('navigation/studentList.php');
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

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!-- SIDEBAR NAVIGATION -->
    <nav>

        <!-- BUTTON FORMS -->
        <div class="form-buttons-container">
            <form action="admin.php" method="GET">
                <button type="submit" name="page" value="dashboard">
                    <i class="fas fa-columns"></i> Dashboard
                </button>
                <button type="submit" name="page" value="studentList">
                    <i class="fas fa-user"></i> Student List
                </button>
                <button type="submit" name="page" value="book">
                    <i class="fas fa-book"></i> Books
                </button>
                <button type="submit" name="page" value="borrowing">
                    <i class="fas fa-user"></i> Borrowing
                </button>
                <button type="submit" name="page" value="returning">
                    <i class="fas fa-user"></i> Returning
                </button>
                <button type="submit" name="page" value="inventoryStatus">
                    <i class="fas fa-chart-line"></i> Inventory Status
                </button>
            </form>

            <!-- LOGOUT FORM -->
            <form action="admin.php" method="POST">
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