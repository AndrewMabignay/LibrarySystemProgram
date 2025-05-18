<?php 

if (isset($_POST['search'])) {
    $searchField = $_POST['searchBook'];

    
    echo 'Hello WOrld;';

    require_once '../function/Model.php';

    $searchBook = new Model();
    $searchDataBook = $searchBook->searchBook($searchField);
}

if (isset($_POST['borrowBook'])) {
    $bookID = $_POST['bookID'];
    $bookTitle = $_POST['title'];   
    $bookAuthor = $_POST['author'];   
    $bookISBN = $_POST['isbn'];   
    $bookCategory = $_POST['category'];   
    $bookCopyright = $_POST['copyright'];   

    echo $bookID;
    echo $bookTitle;
    echo $bookAuthor;
    echo $bookISBN;
    echo $bookCategory;
    echo $bookCopyright;
}

require_once '../function/Model.php';

$showBook = new Model();
$dataBook = $showBook->showBook();


?>

<div class="borrowing-list-container">

    <form action="admin.php?page=book" method="POST">
        <h2>List of Book Returning</h2>    

        <div class="input-container">
            
            <!-- SEARCH INPUT -->
            <div class="search-container">
                <input type="text" name="searchBook">
                <button type="submit" name="search">
                    <label for="">
                        <i class="fas fa-search"></i>
                    </label>
                </button>
            </div>

            <!-- REFRESH BUTTON -->
            <button type="submit" name="refreshBook">
                <i class="fas fa-sync"></i>
            </button>

            <!-- ADD BUTTON -->
            <button type="submit" name="addBookVerify">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </form>



    <!-- TABLE LIST OF BOOKS TO BORROW -->
    <div class="table-wrapper">
        

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

                

            </tbody>
        </table>
    </div>
</div>