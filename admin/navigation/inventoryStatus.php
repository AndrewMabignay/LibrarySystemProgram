<?php 

require_once '../function/Model.php';

$view = isset($_POST['viewInventory']) ? $_POST['viewInventory'] : 'allBooks';
$searchTerm = isset($_POST['searchBook']) ? $_POST['searchBook'] : null;

$displayAllBooks = new Model();

// Logic to display based on view + search
if (isset($_POST['search']) && $searchTerm !== null) {
    switch ($view) {
        case 'bookCategory':
            $bookDisplay = $displayAllBooks->searchBookCategory($searchTerm);
            break;
        case 'archieveBooks':
            $bookDisplay = $displayAllBooks->searchArchivedBooks($searchTerm);
            break;
        default:
            $bookDisplay = $displayAllBooks->searchAllBooks($searchTerm);
            break;
    }
} else {
    switch ($view) {
        case 'bookCategory':
            $bookDisplay = $displayAllBooks->inventoryBookCategory();
            break;
        case 'archieveBooks':
            $bookDisplay = $displayAllBooks->inventoryArchivedBooks();
            break;
        default:
            $bookDisplay = $displayAllBooks->inventoryAllBooks();
            break;
    }
}
?>


<div class="inventory-container">
    <form action="admin.php?page=inventoryStatus" method="POST" class="inventory-container-form">
        <h2>Inventory</h2>    

        <div class="input-container">
            
            <!-- SEARCH INPUT -->
            <div class="search-container">
                <input type="text" name="searchBook" value="<?php echo isset($searchTerm) ? $searchTerm : ''; ?>">
                <input type="hidden" name="viewInventory" value="<?php echo htmlspecialchars($view); ?>">

                <button type="submit" name="search">
                    <label for="">
                        <i class="fas fa-search"></i>
                    </label>
                </button>
            </div>
        </div>
    </form>

    <!-- SEPERATOR LINE -->
    <hr class="seperator-line">

    <div class="table-wrapper">
        <form action="admin.php?page=inventoryStatus" method="POST" class="buttons-container">
            <!-- ALL BOOKS -->
            <button type="submit" name="viewInventory" value="allBooks">
                <i class="fas fa-book"></i> ALL BOOKS
            </button>

            <!-- BOOK CATEGORY -->
            <button type="submit" name="viewInventory" value="bookCategory">
                <i class="fas fa-layer-group"></i> BOOK CATEGORY 
            </button>

            <!-- ARCHIEVE BOOKS -->
            <button type="submit" name="viewInventory" value="archieveBooks">
                <i class="fas fa-archive"></i> ARCHIEVE BOOK 
            </button>
        </form>

        <hr class="seperator-line-table">

        <table>
            <thead>
                <tr>
                    <?php if ($view == 'bookCategory'): ?>
                        <th>Category</th>
                        <th>Quantity</th>
                    <?php else: ?>
                        <th>BookID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Category</th>
                        <th>Copyright</th>
                        <th>Status</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($bookDisplay as $books): ?>
                    <tr>
                        <?php if ($view === 'bookCategory'): ?>
                            <td><?php echo $books['Category'] ?></td>
                            <td><?php echo $books['Quantity'] ?></td>
                        <?php else: ?>
                            <td><?php echo $books['BookID'] ?></td>
                            <td><?php echo $books['Title'] ?></td>
                            <td><?php echo $books['Author'] ?></td>
                            <td><?php echo $books['ISBN'] ?></td>
                            <td><?php echo $books['Category'] ?></td>
                            <td><?php echo $books['CopyRight'] ?></td>
                            <td><?php echo $books['Status'] ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>