<?php 

if (isset($_POST['search'])) {
    $searchField = $_POST['searchBook'];

    require_once '../function/Model.php';

    $searchBook = new Model();
    $searchDataBook = $searchBook->searchBook($searchField);
}