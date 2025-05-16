-- NEW UPDATE INSERT BOOK (05/16/2025)
DROP TABLE books;

CREATE TABLE books(
    BookID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    ISBN VARCHAR(100) NOT NULL,
    Category VARCHAR(100) NOT NULL
);

-- INSERT INTO books(Title, Author, ISBN, Category) VALUES (?, ?, ?, ?);

ALTER TABLE books
ADD COLUMN CopyRight YEAR AFTER Category;

-- NEW UPDATE ADD BOOK DELIMITER (05/16/2025)
DELIMITER //

CREATE PROCEDURE AddBook(
    IN p_Title VARCHAR(255),
    IN p_Author VARCHAR(255),
    IN p_ISBN VARCHAR(50),
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



