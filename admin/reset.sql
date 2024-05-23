DROP DATABASE temp_db;
CREATE DATABASE temp_db;
USE temp_db;

CREATE TABLE profile (
    ID int AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(100),
    display_name VARCHAR(100),
    name VARCHAR(100),
    password VARCHAR(100),
    users BOOLEAN,
    logs BOOLEAN,
    files BOOLEAN,
    tables BOOLEAN,
    analytics BOOLEAN
);

CREATE TABLE log (
    log VARCHAR(100)
);

CREATE TABLE analytics (
    date DATE,
    views int,
    clicks int
);

INSERT INTO profile VALUES (0, "0.png", "Administrator", "admin", "$2y$10$.Zc3/IHeWpR6EIXpin/kX.F7GN6nGhdFyNtp23oSw6JVQBii1D.y6", 1, 1, 1, 1, 1);
--      END OF TOOL DB
