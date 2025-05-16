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



    <!-- TABLE LIST OF BOOKS TO BORROW -->
    <div class="table-wrapper">
        <div class="personal-information">

            <!-- STUDENT # -->
            <div class="label-container">
                <label for="">Student #</label>
                <input type="text" value="<?php ?>" >
            </div>

            <!-- STUDENT NAME -->
            <div class="label-container">
                <label for="">Student Name</label>
                <input type="text" value="<?php ?>" >
            </div>

            <!-- COURSE -->
            <div class="label-container">
                <label for="">Course</label>
                <input type="text" value="<?php ?>" >
            </div>

            <!-- MAJOR -->
            <div class="label-container">
                <label for="">Major</label>
                <input type="text" value="<?php ?>" >
            </div>

            <!-- YEAR LEVEL -->
            <div class="label-container">
                <label for="">Year Level</label>
                <input type="text" value="<?php ?>" >
            </div>

            <?php date_default_timezone_set('Asia/Manila'); ?>
            
            <!-- DATE -->
            <div class="label-container">
                <label for="">Date</label>
                <input type="date" value="<?php echo date('Y-m-d') ?>" >
            </div>
            
            <!-- TIME -->
            <div class="label-container">
                <label for="">Time</label>
                <input type="time" value="<?php echo date('H:i') ?>" >
            </div>
        </div>

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

                <?php if(isset($searchField) && $searchField != ''): ?>
                    <?php if(isset($searchDataBook) && count($searchDataBook) > 0): ?>
                        <?php foreach($searchDataBook as $books): ?>
                            <tr>
                                <td><?php echo $books['Title'] ?></td>
                                <td><?php echo $books['Author'] ?></td>
                                <td>
                                    <form action="client.php?page=borrowing" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <input type="hidden" value="<?php echo $books['CopyRight'] ?>" name="copyright">
                                        <button type="submit" name="borrowBook">
                                            Borrow
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No Books Found!</td>
                        </tr>    
                    <?php endif; ?>

                <!-- SEARCH NULL VALUES -->
                <?php elseif(isset($searchField) && $searchField == ''): ?>
                    <tr>
                        <td colspan="6">No Books Found!</td>
                    </tr>

                <!-- REFRESH TABLE -->
                <?php elseif(isset($refreshTable) && $refreshTable == true): ?>
                    <?php if(count($dataBook) > 0): ?>
                        <?php foreach($dataBook as $books): ?>
                            <tr>
                                <tr>
                                <td><?php echo $books['BookID'] ?></td>
                                <td><?php echo $books['Title'] ?></td>
                                <td><?php echo $books['Author'] ?></td>
                                <td><?php echo $books['ISBN'] ?></td>
                                <td><?php echo $books['Category'] ?></td>
                                <td>
                                    <form action="client.php?page=borrowing" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <input type="hidden" value="<?php echo $books['CopyRight'] ?>" name="copyright">
                                        <button type="submit" name="borrowBook">
                                            Borrow
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Empty Books</td>
                        </tr>
                    <?php endif; ?>

                <!-- DEFAULT -->
                <?php else: ?>
                    <?php if(count($dataBook) > 0): ?>
                        <?php foreach($dataBook as $books): ?>
                            <tr>
                                <td><?php echo $books['BookID'] ?></td>
                                <td><?php echo $books['Title'] ?></td>
                                <td><?php echo $books['Author'] ?></td>
                                <td><?php echo $books['ISBN'] ?></td>
                                <td><?php echo $books['Category'] ?></td>
                                <td>
                                    <form action="client.php?page=borrowing" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <input type="hidden" value="<?php echo $books['CopyRight'] ?>" name="copyright">
                                        <button type="submit" name="borrowBook">
                                            Borrow
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Empty Books</td>
                        </tr>
                    <?php endif; ?>
                <?php endif; // END CONDITION ?>

            </tbody>
        </table>
    </div>
</div>