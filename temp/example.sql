DROP TABLE if EXISTS reservations;
DROP TABLE if EXISTS users;
DROP TABLE if EXISTS rol;
DROP TABLE if EXISTS labs;
DROP TABLE if EXISTS status;


CREATE TABLE rol
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255)
);

CREATE TABLE users
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email    VARCHAR(255) NOT NULL UNIQUE,
    rol_id   INT          NOT NULL,
    password VARCHAR(255) NOT NULL,
    FOREIGN KEY (rol_id) REFERENCES rol (id)
);

CREATE TABLE status
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255)
);

CREATE TABLE labs
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    status_id   INT,
    description VARCHAR(255),
    FOREIGN KEY (status_id) REFERENCES status (id)
);

CREATE TABLE reservations
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT,
    lab_id     INT,
    date_start DATE NOT NULL,
    date_size  INT, /* weeks */
    time_start INT  NOT NULL,
    time_end   INT  NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (lab_id) REFERENCES labs (id)
);


INSERT INTO rol (description)
VALUES ("admin");
INSERT INTO status (description)
VALUES ("available");
INSERT INTO users (username, email, rol_id, password)
VALUES ("dsad65", "medina@gmail.com", 1, "asdpasdasd");
INSERT INTO users (username, email, rol_id, password)
VALUES ("wq54asd", "m2users_labsedina@gmail.com", 1, "asdpasdasd");
INSERT INTO labs (description, status_id)
VALUES ("#354", 1);
INSERT INTO reservations (user_id, lab_id, date_start, time_start, time_end)
VALUES (1, 1, current_timestamp, 9, 15);
INSERT INTO reservations (user_id, lab_id, date_start, date_size, time_start, time_end)
VALUES (2, 1, CURRENT_TIMESTAMP, 5, 15, 18);