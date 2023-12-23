DROP DATABASE pumpa_db;
CREATE DATABASE pumpa_db;
USE pumpa_db;

CREATE TABLE opentable (
    ID int AUTO_INCREMENT PRIMARY KEY,
    underline BOOLEAN,
    day VARCHAR(50),
    start VARCHAR(10),
    end VARCHAR(10)
);
ALTER TABLE opentable AUTO_INCREMENT = 1;   

CREATE TABLE map (
    ID int AUTO_INCREMENT PRIMARY KEY,
    map_url VARCHAR(200),
    description VARCHAR(1000)
);
ALTER TABLE map AUTO_INCREMENT = 1;

CREATE TABLE news (
    ID int AUTO_INCREMENT PRIMARY KEY,
    visible BOOLEAN,
    title VARCHAR(50),
    description VARCHAR(1000),
    visible_img BOOLEAN,
    img VARCHAR(150),
    date DATE
);
ALTER TABLE news AUTO_INCREMENT = 1;

CREATE TABLE contact (
    ID int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    value VARCHAR(50)
);
ALTER TABLE contact AUTO_INCREMENT = 1;
/* set values */
INSERT INTO opentable (underline, day, start, end) VALUES (false, "Pondělí", "6:00", "20:00");
INSERT INTO opentable (underline, day, start, end) VALUES (false, "Úterý", "6:00", "20:00");
INSERT INTO opentable (underline, day, start, end) VALUES (false, "Středa", "6:00", "20:00");
INSERT INTO opentable (underline, day, start, end) VALUES (false, "Čtvrtek", "6:00", "20:00");
INSERT INTO opentable (underline, day, start, end) VALUES (true, "Pátek", "6:00", "20:00");
INSERT INTO opentable (underline, day, start, end) VALUES (false, "Sobota", "7:00", "18:00");
INSERT INTO opentable (underline, day, start, end) VALUES (true, "Neděle", "7:00", "18:00");
INSERT INTO opentable (underline, day, start, end) VALUES (false, "Štědrý den", "7:00", "12:00");