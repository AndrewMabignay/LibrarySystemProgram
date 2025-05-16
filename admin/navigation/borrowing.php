<?php 

require_once '../function/Model.php';

$showBook = new Model();
$dataBook = $showBook->showBook();

?>

<div class="borrowing-list-container">
    <form action="admin.php?page=book" method="POST">
        <h2>List of Book Borrowing</h2>    

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
                    <th>Quantity</th>
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
                                <td><?php echo $books['Copies'] ?></td>
                                <td>
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <input type="hidden" value="<?php echo $books['Copies'] ?>" name="copies">
                                        <button type="submit" name="editBookVerify">
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
                                <td><?php echo $books['Copies'] ?></td>
                                <td>
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <input type="hidden" value="<?php echo $books['Copies'] ?>" name="copies">
                                        <button type="submit" name="edit">
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
                                <td><?php echo $books['Copies'] ?></td>
                                <td>
                                    <form action="admin.php?page=book" method="POST">
                                        <input type="hidden" value="<?php echo $books['BookID'] ?>" name="bookID">
                                        <input type="hidden" value="<?php echo $books['Title'] ?>" name="title">
                                        <input type="hidden" value="<?php echo $books['Author'] ?>" name="author">
                                        <input type="hidden" value="<?php echo $books['ISBN'] ?>" name="isbn">
                                        <input type="hidden" value="<?php echo $books['Category'] ?>" name="category">
                                        <input type="hidden" value="<?php echo $books['Copies'] ?>" name="copies">
                                        <button type="submit" name="edit">
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
</div>