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