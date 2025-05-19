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
5 rows in set (0.00 sec)

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
6 rows in set (0.01 sec)

SHOW PROCEDURE STATUS WHERE Db = DATABASE();
+---------------+---------+-----------+----------------+---------------------+---------------------+---------------+---------+----------------------+----------------------+--------------------+
| Db            | Name    | Type      | Definer        | Modified            | Created             | Security_type | Comment | character_set_client | collation_connection | Database Collation |
+---------------+---------+-----------+----------------+---------------------+---------------------+---------------+---------+----------------------+----------------------+--------------------+
| librarysystem | AddBook | PROCEDURE | root@localhost | 2025-05-16 18:41:34 | 2025-05-16 18:41:34 | DEFINER       |         | cp850                | cp850_general_ci     | utf8mb4_0900_ai_ci |
+---------------+---------+-----------+----------------+---------------------+---------------------+---------------+---------+----------------------+----------------------+--------------------+
1 row in set (0.07 sec)