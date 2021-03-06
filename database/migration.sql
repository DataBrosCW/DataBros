-- -------------------------
-- DATABROS MIGRATION FILE
-- -------------------------

-- Create the users table

CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (email)
);

-- Create product table

CREATE TABLE IF NOT EXISTS products(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    epid VARCHAR(255) NOT NULL,
    img VARCHAR(255),
    description LONGTEXT DEFAULT NULL,
    price FLOAT,
    link VARCHAR(255) DEFAULT NULL,
    subgroup VARCHAR(255),
    PRIMARY KEY (id),
    UNIQUE (epid)
);

-- Create category table

CREATE TABLE IF NOT EXISTS categories (
    id INT NOT NULL AUTO_INCREMENT,
    ebay_id VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL ,
    PRIMARY KEY (id),
    UNIQUE (ebay_id)
);

-- Create category stat table

CREATE TABLE IF NOT EXISTS category_stats(
    category_id INT NOT NULL,
    graph_type VARCHAR(255) NOT NULL,
    id INT NOT NULL AUTO_INCREMENT,
    content JSON,
    PRIMARY KEY (id),
    FOREIGN KEY(category_id) REFERENCES categories(id)
);

-- Create product stats table

CREATE TABLE IF NOT EXISTS product_stats(
    product_id INT NOT NULL,
    graph_type VARCHAR(255) NOT NULL,
    id INT NOT NULL AUTO_INCREMENT,
    content JSON,
    PRIMARY KEY (id),
    FOREIGN KEY(product_id) REFERENCES products(id)
);

-- Create relationship table between users and products

CREATE TABLE IF NOT EXISTS user_products (
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    followed BOOLEAN NOT NULL,
    count INT NOT NULL,
    PRIMARY KEY (user_id,product_id),
    UNIQUE  (user_id,product_id),
    FOREIGN KEY(product_id) REFERENCES products(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

-- Create relationship table between users and categories

CREATE TABLE IF NOT EXISTS user_categories (
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    count INT DEFAULT 0,
    followed BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (user_id,category_id),
    UNIQUE  (user_id,category_id),
    FOREIGN KEY(category_id) REFERENCES categories(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

-- Create table to store app key

CREATE TABLE IF NOT EXISTS application_tokens (
    id INT NOT NULL AUTO_INCREMENT,
    token TEXT NOT NULL,
    expires_at datetime,
    PRIMARY KEY (id)
);
