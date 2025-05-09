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

echo $page;

if (isset($_POST['book']) || $page == 'book') {
    ob_start();
    include('navigation/book.php');
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
</head>
<body>
    <!-- SIDEBAR NAVIGATION -->
    <nav>
        <form action="admin.php" method="GET">
            <button type="submit" name="page" value="dashboard">
                <i class="fas fa-columns"></i> Dashboard
            </button>
            <button type="submit" name="page" value="book">
                <i class="fas fa-circle-notch"></i> Book
            </button>
            <button type="submit" name="page" value="inventoryStatus">
                <i class="fas fa-chart-line"></i> InventoryStatus
            </button>
            <button type="submit" name="page" value="studentList">
                <i class="fas fa-user"></i> studentList
            </button>
        </form>

        <form action="admin.php" method="POST"> 
            <hr>
            <button type="submit" name="logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </nav>

    <!-- CONTENT CONTAINER -->
    <?php echo $content ?>
</body>
</html>