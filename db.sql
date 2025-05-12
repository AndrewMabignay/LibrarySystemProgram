-- USERS TABLE
CREATE TABLE users(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(100) NOT NULL,
    Password VARCHAR(100) NOT NULL,
    Role ENUM('Admin', 'Student') NOT NULL,
    Status ENUM('Active', 'Inactive') NOT NULL
);

INSERT INTO users(Username, Password, Role, Status) VALUES 
('admin', 'admin', 'Admin', 'Active'),
('2022-10029', '2022-10029', '2022-10029', 'Active'); --Testing palang


-- STUDENTS TABLE
CREATE TABLE student(
    StudentID VARCHAR(20) PRIMARY KEY,
    StudentName VARCHAR(100) NOT NULL,
    Course VARCHAR(20) NOT NULL,
    Major VARCHAR(100) NOT NULL,
    YearLevel VARCHAR(20) NOT NULL,
    Status ENUM('Active', 'Inactive') NOT NULL
);

INSERT INTO student(StudentID, StudentName, Course, Major, YearLevel, Status) VALUES 
('2022-10030', 'Papi River', 'BSCS', 'Computer Science', '3', 'Active');

SELECT * FROM student WHERE StudentID = '2022-10029';

SELECT * FROM user WHERE Username = '2022-10029';

UPDATE student SET Name = '', Course = '', Major = '', YearLevel = '', Status = '' WHERE StudentID = ''
UPDATE user SET Password = '', Status = '' WHERE Username = '';

CREATE TABLE books(
    BookID VARCHAR(100) PRIMARY KEY,
    Title VARCHAR(50) NOT NULL,
    Author VARCHAR(100) NOT NULL,
    ISBN VARCHAR(100) NOT NULL,
    Category VARCHAR(100) NOT NULL,
    Copies INT NOT NULL
);

INSERT INTO books(BookID, Title, Author, ISBN, Category, Copies) VALUES (?, ?, ?, ?, ?, ?);

SELECT * FROM books WHERE BookID LIKE '%2%' OR Title LIKE '%1%' OR Author LIKE '%1%' OR ISBN LIKE '%1%' OR Category LIKE '%1%' OR Copies LIKE '%1%';