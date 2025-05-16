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

if (isset($_POST['editBookVerifiy'])) {
    $editBookVerify = true;

    $editBookID = $_POST['bookID'];
    $editTitle = $_POST['title'];
    $editAuthor = $_POST['author'];
    $editISBN = $_POST['isbn'];
    $editCategory = $_POST['category'];
    $editCopies = $_POST['copies'];
}

if (isset($_POST['editBook'])) {
    
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



<div class="book-list-container">    
    <form action="admin.php?page=book" method="POST">
        <h2>List of Books</h2>    

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

    <hr class="seperator-line">

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
                    <th>Action</th>
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
                                <td>
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <button type="submit" name="editBookVerify">
                                            <i class="fas fa-edit"></i>
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
                                <td><?php echo $books['BookID'] ?></td>
                                <td><?php echo $books['Title'] ?></td>
                                <td><?php echo $books['Author'] ?></td>
                                <td><?php echo $books['ISBN'] ?></td>
                                <td><?php echo $books['Category'] ?></td>
                                <td>
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <button type="submit" name="edit">
                                            <i class="fas fa-edit"></i>
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
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <button type="submit" name="edit">
                                            <i class="fas fa-edit"></i>
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

    <!-- ADD BOOKS -->
    <?php if(isset($addBookVerify) && $addBookVerify == true): ?>
        <div class="overlay"></div>
        <div class="add-book-container">
            <form action="admin.php?page=book" method="POST" class="add-book-function">
                <div class="close-container">
                    <h2>Add Candidate</h2>

                    <button type="submit" name="close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>

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

                <!-- MESSAGE DIALOG -->
                <?php if (isset($addBookPrompt)): ?>
                    <div class="alert-form">
                        <?php if ($addBookPrompt == 'Successfully Inserted'): ?>
                            <p style="color: green"><?php echo $addBookPrompt; ?></p>
                        <?php else: ?>
                            <p><?php echo $addBookPrompt; ?></p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p></p>
                <?php endif; ?>

                <button type="submit" name="addBook" class="save">
                    <i class="fas fa-save"></i> Create
                </button>
            </form>
        </div>            
    <?php endif; ?>


    <!-- EDIT BOOKS -->
    <?php if(isset($editBookVerify) && $editBookVerify == true): ?>
        <div class="overlay"></div>
        <div class="add-book-container">
            <form action="admin.php?page=book" method="POST" class="add-book-function">
                <div class="close-container">
                    <h2>Edit Candidate</h2>

                    <button type="submit" name="close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>

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

                <!-- MESSAGE DIALOG -->
                <?php if (isset($addBookPrompt)): ?>
                    <div class="alert-form">
                        <?php if ($addBookPrompt == 'Successfully Inserted'): ?>
                            <p style="color: green"><?php echo $addBookPrompt; ?></p>
                        <?php else: ?>
                            <p><?php echo $addBookPrompt; ?></p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p></p>
                <?php endif; ?>

                <button type="submit" name="addBook" class="save">
                    <i class="fas fa-save"></i> Create
                </button>
            </form>
        </div>            
    <?php endif; ?>
</div>