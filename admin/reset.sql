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
    show_logs BOOLEAN NOT NULL,
    show_files BOOLEAN NOT NULL,
    show_console BOOLEAN NOT NULL,
    show_tables BOOLEAN NOT NULL
);

CREATE TABLE log (
    ID int AUTO_INCREMENT PRIMARY KEY,
    log VARCHAR(1000)
);

CREATE TABLE table_access (
    ID int AUTO_INCREMENT PRIMARY KEY,
    profile_id int NOT NULL,
    access_arr VARCHAR(100) NOT NULL,
    is_god BOOLEAN NOT NULL DEFAULT 0
);

INSERT INTO profile VALUES (0, "0.png", "Administrator", "admin", "$2y$10$.Zc3/IHeWpR6EIXpin/kX.F7GN6nGhdFyNtp23oSw6JVQBii1D.y6", 1, 1, 1, 1, 1);
INSERT INTO table_access VALUES (0, 0, "[]", 1);
--      END OF ADMIN DB
