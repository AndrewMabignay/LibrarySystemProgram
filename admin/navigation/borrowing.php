<?php 

// echo 'Hello Admin Borrowing!';

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
</div>