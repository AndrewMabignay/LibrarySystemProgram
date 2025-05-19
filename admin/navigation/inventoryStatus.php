<?php 

$view = isset($_POST['viewInventory']) ? $_POST['viewInventory'] : 'allBooks';
echo $view;




?>

<div class="inventory-container">
    <form action="admin.php?page=inventoryStatus" method="POST" class="inventory-container-form">
        <h2>Inventory</h2>    

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

            

            
        </div>
    </form>

    <!-- SEPERATOR LINE -->
    <hr class="seperator-line">

    <div class="table-wrapper">
        <form action="admin.php?page=inventoryStatus" method="POST">
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
    </div>
</div>