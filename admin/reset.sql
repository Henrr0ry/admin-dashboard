DROP DATABASE admin_db;
CREATE DATABASE admin_db;
USE admin_db;

CREATE TABLE profile (
    ID int AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(100),
    display_name VARCHAR(100),
    name VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    change_users BOOLEAN NOT NULL,
    logs BOOLEAN NOT NULL,
    files BOOLEAN NOT NULL,
    edit_tables BOOLEAN NOT NULL,
    edit_data BOOLEAN NOT NULL
);

CREATE TABLE log (
    log VARCHAR(100)
);

CREATE TABLE table_access (
    ID int AUTO_INCREMENT PRIMARY KEY,
    profile_id int NOT NULL,
    table_name VARCHAR(100) NOT NULL
);

INSERT INTO profile VALUES (0, "0.png", "Administrator", "admin", "$2y$10$.Zc3/IHeWpR6EIXpin/kX.F7GN6nGhdFyNtp23oSw6JVQBii1D.y6", 1, 1, 1, 1, 1);
INSERT INTO table_access VALUES (0, 0, "god");
--      END OF ADMIN DB
