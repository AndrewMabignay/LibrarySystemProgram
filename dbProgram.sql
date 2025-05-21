-- NEW UPDATE INSERT BOOK (05/16/2025)
DROP TABLE books;

CREATE TABLE books(
    BookID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    ISBN VARCHAR(100) NOT NULL,
    Category VARCHAR(100) NOT NULL,
    CopyRight YEAR NOT NULL
);

-- INSERT INTO books(Title, Author, ISBN, Category) VALUES (?, ?, ?, ?);

ALTER TABLE books
ADD COLUMN CopyRight YEAR AFTER Category;

-- NEW UPDATE ADD BOOK DELIMITER (05/16/2025)
DROP PROCEDURE IF EXISTS AddBook;

DELIMITER //

CREATE PROCEDURE AddBook (
    IN p_Title VARCHAR(255),
    IN p_Author VARCHAR(255),
    IN p_ISBN VARCHAR(100),
    IN p_Category VARCHAR(100),
    IN p_CopyRight YEAR,
    IN p_Copies INT,
    OUT p_message VARCHAR(255)
)
BEGIN
    DECLARE i INT DEFAULT 0;

    WHILE i < p_Copies DO
        INSERT INTO books (Title, Author, ISBN, Category, CopyRight)
        VALUES (p_Title, p_Author, p_ISBN, p_Category, p_CopyRight);

        SET i = i + 1;
    END WHILE;

    SET p_message = 'Successfully Inserted';
END //

DELIMITER ;

SHOW PROCEDURE STATUS WHERE Db = 'librarysystem';

CREATE TABLE borrowings(
    BorrowID INT PRIMARY KEY AUTO_INCREMENT,
    BookID INT NOT NULL,
    UserID INT NOT NULL,
    BorrowDate DATE NOT NULL
);

INSERT INTO borrowings(BookID, UserID, BorrowDate) VALUES 
(1, 8, '2025-05-15');

SELECT 
    b.Title, 
    b.Author, 
    b.ISBN, 
    b.Category, 
    b.CopyRight,
    COUNT(b.BookID) AS total_copies,
    COUNT(b.BookID) - COUNT(br.BookID) AS available_copies
FROM books b
LEFT JOIN borrowings br ON b.BookID = br.BookID
GROUP BY b.Title, b.Author, b.ISBN, b.Category, b.CopyRight;


-- OPTIONAL IF NEEDED
SELECT COUNT(*) FROM books WHERE Title = 'Rizal', Author = 'Top G', ISBN = '987654321'; 


CREATE TABLE add_to_lists(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    StudentNo ID INT NOT NULL,
    BookID INT NOT NULL,
    Date_To_List DATE NOT NULL,
    Time_To_List TIME NOT NULL
);


-- 05 / 18 / 2025
SELECT b.* FROM books b LEFT JOIN borrowings br ON b.BookID = br.bookID WHERE br.BookID IS NULL;

SELECT b.*, br.BorrowDate, br.BorrowTime FROM books b JOIN borrowings br ON b.BookID = br.BookID WHERE TIMESTAMP(br.BorrowDate, br.BorrowTime) < NOW() - INTERVAL 3 DAY;

-- DISPLAY BORROWED BOOK BASED ON USER ID
SELECT b.*, br.BorrowDate, br.BorrowTime FROM borrowings br JOIN books b ON br.BookID = b.BookID WHERE br.UserID = 8;

-- 05 / 19 / 2025
SELECT ID FROM user WHERE Username = '2022-10029';

-- DISPLAY STATUS EITHER AVAILABLE OR BORROWED BOOK [INVENTORY]
SELECT 
    b.BookID,
    b.Title,
    b.Author,
    b.ISBN,
    b.Category,
    b.CopyRight,
    CASE 
        WHEN br.BookID IS NOT NULL THEN 'Borrowed'
        ELSE 'Available'
    END AS Status
FROM 
    books b
LEFT JOIN 
    borrowings br ON b.BookID = br.BookID;

-- RETURNING TABLE
CREATE TABLE returning(
    ReturnID INT PRIMARY KEY AUTO_INCREMENT,
    BorrowID INT NOT NULL,
    UserID INT NOT NULL,
    BorrowDate DATE NOT NULL,
    BorrowTime TIME NOT NULL,
    ReturnDate DATE NOT NULL,
    ReturnTime TIME NOT NULL,
    Penalty ENUM('Yes', 'No') DEFAULT 'No'
);

-- DISPLAY BOOKS BASED BOOK ID UNDER BORROWING
SELECT 
    borrowings.BorrowID,
    books.BookID,
    books.Title,
    books.Author,
    books.ISBN,
    books.Category,
    books.CopyRight,
    borrowings.UserID,
    borrowings.BorrowDate,
    borrowings.BorrowTime
FROM books
JOIN borrowings ON books.BookID = borrowings.BookID
WHERE borrowings.UserID = ?;

ALTER TABLE returning DROP COLUMN Penalty;

ALTER TABLE borrowings ADD COLUMN Penalty ENUM('Yes', 'No') DEFAULT 'No' AFTER BorrowTime;

INSERT INTO returning(BorrowID, UserID, BorrowDate, BorrowTime, ReturnDate, ReturnTime) VALUES (1, 1, '2025-06-15', '05:15:25', '2025-06-15', '05:15:25');


-- 05/20/2025
ALTER TABLE books
ADD COLUMN Status ENUM('available', 'reserved', 'borrowed') DEFAULT 'available',
ADD COLUMN ReservedBy INT NULL,
ADD COLUMN ReservedAt DATETIME NULL;

-- INVENTORY FOR VIEWING
SELECT 
    r.BookID,
    b.Title,
    b.Author,
    b.Category,
    b.Status,
    CONCAT(r.ReturnDate, ' ', r.ReturnTime) AS `Last Accessed`,
    u.Username AS `Last User`
FROM `returning` r
JOIN books b ON r.BookID = b.BookID
JOIN user u ON r.UserID = u.ID
WHERE (r.ReturnDate, r.ReturnTime) IN (
    SELECT 
        MAX(ReturnDate), MAX(ReturnTime)
    FROM `returning` r2
    WHERE r2.BookID = r.BookID
)
GROUP BY r.BookID;

-- INVENTORY GROUP BY
SELECT COUNT(*) AS 'Quantity' FROM books GROUP BY Category

SELECT b.*
FROM books b
JOIN add_to_list a ON b.BookID = a.BookID
WHERE a.UserID = 8 AND Status = 'Reserved';

SELECT b.*, a.UserID
FROM books b
JOIN add_to_list a ON b.BookID = a.BookID
WHERE a.UserID = 8 AND b.Status = 'Reserved';

DELETE FROM add_to_list WHERE BookID = ? AND UserID = ?;

SELECT Category, COUNT(*) AS Quantity
FROM books
WHERE Category = 'History';
