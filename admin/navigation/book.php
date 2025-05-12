<?php 

if (isset($_POST['addBookVerify'])) {
    $addBookVerify = true;
}

if (isset($_POST['addBook'])) {
    $bookID = $_POST['bookID'];
    $bookTitle = $_POST['bookTitle'];
    $bookAuthor = $_POST['bookAuthor'];
    $bookISBN = $_POST['bookISBN'];
    $bookCategory = $_POST['bookCategory'];
    $bookQuantity = $_POST['bookQuantity'];

    require_once '../function/Model.php';

    $addBook = new Model();
    $addBookPrompt = $addBook->addBook($bookID, $bookTitle, $bookAuthor, $bookISBN, $bookCategory, $bookQuantity);
    echo $addBookPrompt;

    $addBookVerify = true;
}

if (isset($_POST['search'])) {
    $searchField = $_POST['searchBook'];

    require_once '../function/Model.php';

    $searchBook = new Model();
    $searchDataBook = $searchBook->searchBook($searchField);
}

if (isset($_POST['refresh'])) {
    $refreshTable = true;
}

require_once '../function/Model.php';

$showBook = new Model();
$dataBook = $showBook->showBook();

?>

<div class="book-container">
    <header>
        <form action="admin.php?page=book" method="POST">
            
            <!-- SEARCH INPUT -->
            <div class="search-container">
                <input type="text" name="searchBook">
                <button type="submit" name="search">SEARCH</button>
            </div>

            <!-- REFRESH BUTTON -->
            <button type="submit" name="refreshBook">REFRESH</button>

            <!-- ADD BUTTON -->
            <button type="submit" name="addBookVerify">CREATE</button>
        </form>


    </header>

    <div class="book-list-container">
        
        <!-- LIST OF BOOKS -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Category</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- SEARCH OUTPUT -->
                    <?php if(isset($searchField) && $searchField != ''): ?>
                        <?php if(isset($searchDataBook) && count($searchDataBook) > 0): ?>
                            <?php foreach($searchDataBook as $books): ?>
                                <tr>
                                    <td><?php echo $books['BookID'] ?></td>
                                    <td><?php echo $books['Title'] ?></td>
                                    <td><?php echo $books['Author'] ?></td>
                                    <td><?php echo $books['ISBN'] ?></td>
                                    <td><?php echo $books['Category'] ?></td>
                                    <td><?php echo $books['Copies'] ?></td>
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
                                    <td><?php echo $books['BookID'] ?></td>
                                    <td><?php echo $books['Title'] ?></td>
                                    <td><?php echo $books['Author'] ?></td>
                                    <td><?php echo $books['ISBN'] ?></td>
                                    <td><?php echo $books['Category'] ?></td>
                                    <td><?php echo $books['Copies'] ?></td>
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
                                    <td><?php echo $books['Copies'] ?></td>
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

        

        <!-- ADD BOOKS -->
        <?php if(isset($addBookVerify) && $addBookVerify == true): ?>
            <form action="admin.php?page=book" method="POST">

                <!-- BOOK ID -->
                <div class="input-container">
                    <label for="bookID">Book ID</label>
                    <input type="text" id="bookID" name="bookID" value="<?php  ?>">
                </div>

                <!-- BOOK TITLE -->
                <div class="input-container">
                    <label for="bookTitle">Book Title</label>
                    <input type="text" id="bookTitle" name="bookTitle" value="<?php  ?>">
                </div>

                <!-- BOOK AUTHOR -->
                <div class="input-container">
                    <label for="bookAuthor">Book Author</label>
                    <input type="text" id="bookAuthor" name="bookAuthor" value="<?php  ?>">
                </div>

                <!-- BOOK ISBN -->
                <div class="input-container">
                    <label for="bookISBN">Book ISBN</label>
                    <input type="text" id="bookISBN" name="bookISBN" value="<?php  ?>">
                </div>

                <!-- BOOK CATEGORY -->
                <div class="input-container">
                    <label for="bookCategory">Book Category</label>
                    <input type="text" id="bookCategory" name="bookCategory" value="<?php  ?>">
                </div>

                <!-- BOOK QUANTITY -->
                <div class="input-container">
                    <label for="bookQuantity">Book Quantity</label>
                    <input type="text" id="bookQuantity" name="bookQuantity" value="<?php  ?>">
                </div>

                <button type="submit" name="addBook">ADD</button>
            </form>
        <?php endif; ?>
    </div>
</div>