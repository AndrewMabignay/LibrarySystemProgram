<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookTitle = $_POST['bookTitle'];
    $bookAuthor = $_POST['bookAuthor'];
    $bookISBN = $_POST['bookISBN'];
    $bookCategory = $_POST['bookCategory'];
    $bookCopyRight = $_POST['copyRight'];
    $bookQuantity = $_POST['bookQuantity'];

    require_once '../function/Model.php';

    $model = new Model();
    $result = $model->addBook($bookTitle, $bookAuthor, $bookISBN, $bookCategory, $bookCopyRight, $bookQuantity);

    echo json_encode([
        'status' => $result === 'Successfully Inserted' ? 'success' : 'error',
        'message' => $result
    ]);
}

?>