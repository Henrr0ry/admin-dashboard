DROP DATABASE temp_db;
CREATE DATABASE temp_db;
USE temp_db;

CREATE TABLE uploads (
    ID int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    size int,
    path VARCHAR(100)
);

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
CREATE TABLE opentable (
    ID int AUTO_INCREMENT PRIMARY KEY,
    underline BOOLEAN,
    day VARCHAR(50),
    start VARCHAR(10),
    end VARCHAR(10)
);

CREATE TABLE map (
    ID int AUTO_INCREMENT PRIMARY KEY,
    map_url VARCHAR(200),
    description VARCHAR(1000)
);

CREATE TABLE news (
    ID int AUTO_INCREMENT PRIMARY KEY,
    visible BOOLEAN,
    title VARCHAR(50),
    description VARCHAR(1000),
    visible_img BOOLEAN,
    img VARCHAR(150),
    date DATE
);

CREATE TABLE contact (
    ID int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    value VARCHAR(50)
);
/* set values */

INSERT INTO profile VALUES (0, "0.png", "Main Administrator", "admin", "$2y$10$.Zc3/IHeWpR6EIXpin/kX.F7GN6nGhdFyNtp23oSw6JVQBii1D.y6", 1, 1, 1, 1, 1);
INSERT INTO profile VALUES (0, "3.png", "Moj Admin", "admin1", "$2y$10$.Zc3/IHeWpR6EIXpin/kX.F7GN6nGhdFyNtp23oSw6JVQBii1D.y6", 1, 1, 1, 1, 1);

INSERT INTO opentable (underline, day, start, end) VALUES (false, "Pondělí", "6:00", "20:00");
INSERT INTO opentable (underline, day, start, end) VALUES (false, "Úterý", "6:00", "20:00");
INSERT INTO opentable (underline, day, start, end) VALUES (false, "Středa", "6:00", "20:00");
INSERT INTO opentable (underline, day, start, end) VALUES (false, "Čtvrtek", "6:00", "20:00");
INSERT INTO opentable (underline, day, start, end) VALUES (true, "Pátek", "6:00", "20:00");
INSERT INTO opentable (underline, day, start, end) VALUES (false, "Sobota", "7:00", "18:00");
INSERT INTO opentable (underline, day, start, end) VALUES (true, "Neděle", "7:00", "18:00");
INSERT INTO opentable (underline, day, start, end) VALUES (false, "Štědrý den", "7:00", "12:00");