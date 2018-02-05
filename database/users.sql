
-- Create the users table

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    first_name varchar(255),
    last_name varchar(255),
    password varchar(255),
    PRIMARY KEY (id),
    UNIQUE INDEX (email)
);