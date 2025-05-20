+-------------------------+
| Tables_in_librarysystem |
+-------------------------+
| books                   |
| borrowings              |
| returning               |
| students                |
| user                    |
+-------------------------+
5 rows in set (0.07 sec)

DESC books;
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| BookID    | int          | NO   | PRI | NULL    | auto_increment |
| Title     | varchar(255) | NO   |     | NULL    |                |
| Author    | varchar(255) | NO   |     | NULL    |                |
| ISBN      | varchar(100) | NO   |     | NULL    |                |
| Category  | varchar(100) | NO   |     | NULL    |                |
| CopyRight | year         | NO   |     | NULL    |                |
+-----------+--------------+------+-----+---------+----------------+
6 rows in set (0.01 sec)

CREATE TABLE books(
    BookID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    ISBN VARCHAR(100) NOT NULL,
    Category VARCHAR(100) NOT NULL,
    CopyRight YEAR NOT NULL
);

DESC borrowings;
+------------+------+------+-----+---------+----------------+
| Field      | Type | Null | Key | Default | Extra          |
+------------+------+------+-----+---------+----------------+
| BorrowID   | int  | NO   | PRI | NULL    | auto_increment |
| BookID     | int  | NO   |     | NULL    |                |
| UserID     | int  | NO   |     | NULL    |                |
| BorrowDate | date | NO   |     | NULL    |                |
| BorrowTime | time | YES  |     | NULL    |                |
+------------+------+------+-----+---------+----------------+
5 rows in set (0.01 sec)

CREATE TABLE borrowings(
    BorrowID INT PRIMARY KEY AUTO_INCREMENT,
    BookID INT NOT NULL,
    UserID INT NOT NULL,
    BorrowDate DATE NOT NULL,
    BorrowTime TIME NOT NULL
);

DESC returning;
+------------+------+------+-----+---------+----------------+
| Field      | Type | Null | Key | Default | Extra          |
+------------+------+------+-----+---------+----------------+
| ReturnID   | int  | NO   | PRI | NULL    | auto_increment |
| BorrowID   | int  | NO   |     | NULL    |                |
| UserID     | int  | NO   |     | NULL    |                |
| BorrowDate | date | NO   |     | NULL    |                |
| BorrowTime | time | NO   |     | NULL    |                |
| ReturnDate | date | NO   |     | NULL    |                |
| ReturnTime | time | NO   |     | NULL    |                |
+------------+------+------+-----+---------+----------------+
7 rows in set (0.01 sec)

CREATE TABLE `returning` (
    ReturnID INT PRIMARY KEY AUTO_INCREMENT,
    BorrowID INT NOT NULL,
    UserID INT NOT NULL,
    BorrowDate DATE NOT NULL,
    BorrowTime TIME NOT NULL,
    ReturnDate DATE NOT NULL,
    ReturnTime TIME NOT NULL
);

DESC user;
+----------+-------------------------------------+------+-----+---------+----------------+
| Field    | Type                                | Null | Key | Default | Extra          |
+----------+-------------------------------------+------+-----+---------+----------------+
| ID       | int                                 | NO   | PRI | NULL    | auto_increment |
| Username | varchar(100)                        | NO   |     | NULL    |                |
| Password | varchar(100)                        | NO   |     | NULL    |                |
| Role     | enum('Admin','Student','Librarian') | NO   |     | NULL    |                |
| Status   | enum('Active','Inactive')           | NO   |     | Active  |                |
+----------+-------------------------------------+------+-----+---------+----------------+

CREATE TABLE user(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(100) NOT NULL,
    Password VARCHAR(100) NOT NULL,
    Role ENUM('Admin', 'Student', 'Librarian') NOT NULL,
    Status ENUM('Active', 'Inactive') DEFAULT 'Active' 
);

INSERT INTO user(Username, Password, Role, Status) VALUES('admin', 'admin', 'Admin', 'Active');

DESC students;
+-------------+---------------------------+------+-----+---------+-------+
| Field       | Type                      | Null | Key | Default | Extra |
+-------------+---------------------------+------+-----+---------+-------+
| StudentID   | varchar(20)               | NO   | PRI | NULL    |       |
| StudentName | varchar(100)              | NO   |     | NULL    |       |
| Course      | varchar(20)               | NO   |     | NULL    |       |
| Major       | varchar(100)              | NO   |     | NULL    |       |
| YearLevel   | varchar(20)               | NO   |     | NULL    |       |
| Status      | enum('Active','Inactive') | NO   |     | NULL    |       |
+-------------+---------------------------+------+-----+---------+-------+

CREATE TABLE students(
    StudentID VARCHAR(20) PRIMARY KEY,
    StudentName VARCHAR(100) NOT NULL,
    Course VARCHAR(20) NOT NULL,
    Major VARCHAR(100) NOT NULL,
    YearLevel VARCHAR(20) NOT NULL,
    Status ENUM('Active', 'Inactive') NOT NULL
);


SHOW PROCEDURE STATUS WHERE Db = DATABASE();
+---------------+---------+-----------+----------------+---------------------+---------------------+---------------+---------+----------------------+----------------------+--------------------+
| Db            | Name    | Type      | Definer        | Modified            | Created             | Security_type | Comment | character_set_client | collation_connection | Database Collation |
+---------------+---------+-----------+----------------+---------------------+---------------------+---------------+---------+----------------------+----------------------+--------------------+
| librarysystem | AddBook | PROCEDURE | root@localhost | 2025-05-16 18:41:34 | 2025-05-16 18:41:34 | DEFINER       |         | cp850                | cp850_general_ci     | utf8mb4_0900_ai_ci |
+---------------+---------+-----------+----------------+---------------------+---------------------+---------------+---------+----------------------+----------------------+--------------------+
1 row in set (0.07 sec)