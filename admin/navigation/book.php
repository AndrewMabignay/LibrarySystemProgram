<?php 

require_once '../function/Model.php';

if (isset($_POST['addBookVerify'])) {
    $addBookVerify = true;
}

if (isset($_POST['addBook'])) {
    $bookTitle = $_POST['bookTitle'];
    $bookAuthor = $_POST['bookAuthor'];
    $bookISBN = $_POST['bookISBN'];
    $bookCategory = $_POST['bookCategory'];
    $bookCopyRight = $_POST['copyRight'];
    $bookQuantity = $_POST['bookQuantity'];

    require_once '../function/Model.php';

    $addBook = new Model();
    $addBookPrompt = $addBook->addBook($bookTitle, $bookAuthor, $bookISBN, $bookCategory, $bookCopyRight, $bookQuantity);

    $addBookVerify = true;
}

if (isset($_POST['editBookVerify'])) {
    $editBookVerify = true;

    $editBookID = $_POST['bookID'];
    $editTitle = $_POST['title'];
    $editAuthor = $_POST['author'];
    $editISBN = $_POST['isbn'];
    $editCategory = $_POST['category'];
    $editCopyright = $_POST['copyright'];
}

if (isset($_POST['updateBook'])) {
    $editBookID = $_POST['bookID'];
    $editTitle = $_POST['bookTitle'];
    $editAuthor = $_POST['bookAuthor'];
    $editISBN = $_POST['bookISBN'];
    $editCategory = $_POST['bookCategory'];
    $editCopyright = $_POST['bookCopyright'];
    
    $editBook = new Model();
    $editBookPrompt = $editBook->editBook($editBookID, $editTitle, $editAuthor, $editISBN, $editCategory, $editCopyright);

    $editBookVerify = true;
}

if (isset($_POST['closeAdd'])) {
    unset($addBookVerify);
}

if (isset($_POST['closeEdit'])) {
    unset($editBookVerify);
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
                <input type="text" name="searchBook" placeholder="Search Title">
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
                    <th>Copyright</th>
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
                                <td><?php echo $books['CopyRight'] ?></td>
                                <td>
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <input type="hidden" value="<?php echo $books['CopyRight'] ?>" name="copyright">
                                        <button type="submit" name="editBookVerify" <?php echo $books['Status'] == 'Borrowed' || $books['Status'] == 'Reserved' ? 'disabled' : ''?>>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No Books Found!</td>
                        </tr>    
                    <?php endif; ?>

                <!-- SEARCH NULL VALUES -->
                <?php elseif(isset($searchField) && $searchField == ''): ?>
                    <tr>
                        <td colspan="7">No Books Found!</td>
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
                                <td><?php echo $books['CopyRight'] ?></td>
                                <td>
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <input type="hidden" value="<?php echo $books['CopyRight'] ?>" name="copyright">
                                        <button type="submit" name="editBookVerify" <?php echo $books['Status'] == 'Borrowed' || $books['Status'] == 'Reserved' ? 'disabled' : ''?>>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Empty Books</td>
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
                                <td><?php echo $books['CopyRight'] ?></td>
                                <td>
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <input type="hidden" value="<?php echo $books['CopyRight'] ?>" name="copyright">
                                        <button type="submit" name="editBookVerify" <?php echo $books['Status'] == 'Borrowed' || $books['Status'] == 'Reserved' ? 'disabled' : ''?>>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Empty Books</td>
                        </tr>
                    <?php endif; ?>
                <?php endif; // END CONDITION ?> 
            </tbody>
        </table>
    </div>

    <!-- ADD BOOKS -->
    <?php if(isset($addBookVerify) && $addBookVerify == true): ?>
        <div class="overlay"></div>
        <form action="admin.php?page=book" method="POST" class="add-container">
            <h2>
                <i class="fas fa-book"></i> Add Book
            </h2>

            <div class="grid-container">
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

                <!-- COPYRIGHT -->
                <div class="input-container">
                    <label for="copyRight">Copyright</label>
                    <input type="number" name="copyRight" min="1000" max="9999">
                </div>

                <!-- BOOK QUANTITY -->
                <div class="input-container">
                    <label for="bookQuantity">Book Quantity</label>
                    <input type="text" id="bookQuantity" name="bookQuantity" value="<?php  ?>">
                </div>
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
            
            <div class="button-container">
                <button type="submit" name="closeAdd" class="back">
                    <i class="fas fa-arrow-left"></i> BACK
                </button>
                <button type="submit" name="addBook" class="save">
                    <i class="fas fa-save"></i> CREATE
                </button>
            </div>
        </form>
    <?php endif; ?>

    <!-- EDIT BOOKS -->
    <?php if(isset($editBookVerify) && $editBookVerify == true): ?>
        <div class="overlay"></div>
        <form action="admin.php?page=book" method="POST" class="edit-container">
            <h2>
                <i class="fas fa-book"></i>
                Edit Book
            </h2>

            <div class="grid-container">
                <!-- BOOK ID -->
                <div class="input-container">
                    <label for="bookID">Book ID</label>
                    <input type="text" id="bookID" name="bookID" value="<?php echo isset($editBookID) ? $editBookID : '' ?>" readonly>
                </div>

                <!-- BOOK TITLE -->
                <div class="input-container">
                    <label for="bookTitle">Book Title</label>
                    <input type="text" id="bookTitle" name="bookTitle" value="<?php echo isset($editTitle) ? $editTitle : '' ?>">
                </div>

                <!-- BOOK AUTHOR -->
                <div class="input-container">
                    <label for="bookAuthor">Book Author</label>
                    <input type="text" id="bookAuthor" name="bookAuthor" value="<?php echo isset($editAuthor) ? $editAuthor : '' ?>">
                </div>

                <!-- BOOK ISBN -->
                <div class="input-container">
                    <label for="bookISBN">Book ISBN</label>
                    <input type="text" id="bookISBN" name="bookISBN" value="<?php echo isset($editISBN) ? $editISBN : '' ?>">
                </div>

                <!-- BOOK CATEGORY -->
                <div class="input-container">
                    <label for="bookCategory">Book Category</label>
                    <input type="text" id="bookCategory" name="bookCategory" value="<?php echo isset($editCategory) ? $editCategory : '' ?>">
                </div>

                <!-- BOOK QUANTITY -->
                <div class="input-container">
                    <label for="bookQuantity">Book Copyright</label>
                    <input type="text" id="bookQuantity" name="bookCopyright" value="<?php echo isset($editCopyright) ? $editCopyright : '' ?>">
                </div>
            </div>

            <!-- MESSAGE DIALOG -->
            <?php if (isset($editBookPrompt)): ?>
                <div class="alert-form">
                    <?php if ($editBookPrompt == 'Successfully Updated'): ?>
                        <p style="color: green"><?php echo $editBookPrompt; ?></p>
                    <?php elseif ($editBookPrompt == 'No changes made.'): ?>
                    <p style="color: #222831"><?php echo $editBookPrompt; ?></p>
                    <?php else: ?>
                        <p><?php echo $editBookPrompt; ?></p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p></p>
            <?php endif; ?>

            <div class="button-container">
                <button type="submit" name="closeEdit" class="back">
                    <i class="fas fa-arrow-left"></i> BACK
                </button>
                <button type="submit" name="updateBook" class="save">
                    <i class="fas fa-sync-alt"></i> UPDATE
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>