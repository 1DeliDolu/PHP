-- lege DB an
CREATE DATABASE project;
-- wähle DB aus
USE project;
-- lege Tabellen an
CREATE TABLE `user` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    registered_at INT NOT NULL DEFAULT UNIX_TIMESTAMP()
);
CREATE TABLE stats (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    log_at INT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    `type` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
    fail BOOLEAN NOT NULL DEFAULT false,
    ipv4 VARCHAR(15),
    browser VARCHAR(255),
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE ON UPDATE RESTRICT
);
-- lege DB-User as
CREATE USER `project_user`@`localhost` IDENTIFIED BY 'Pa$$w0rd';
-- gebe DB-User DML & DQL Rechte
GRANT SELECT, INSERT, UPDATE, DELETE ON project.* TO `project_user`@`localhost`;