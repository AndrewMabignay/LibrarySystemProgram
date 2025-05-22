-- 05/22/2025
SELECT * FROM books WHERE CopyRight >= YEAR(CURDATE()) - 6;

UPDATE books SET Title = ?, Author = ?, ISBN = ?, Category = ?, CopyRight = ? WHERE BookID = ?;