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
    description TEXT DEFAULT NULL,
    price FLOAT,
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

-- CREATE TABLE IF NOT EXISTS category_stats(
--     category_id INT NOT NULL,
--     ebay_id VARCHAR(255) NOT NULL,
--     description TEXT,
--     PRIMARY KEY (id),
--     UNIQUE INDEX (ebay_id)
-- );

-- Create product stats table

CREATE TABLE IF NOT EXISTS product_stats(
    product_id INT NOT NULL,
    graph_type VARCHAR(255) NOT NULL,
    id INT NOT NULL AUTO_INCREMENT,
    content JSON,
    PRIMARY KEY (id)
);


-- Create best product table

CREATE TABLE IF NOT EXISTS category_feed_product (
    category_id INT NOT NULL,
    product_id INT NOT NULL,
    PRIMARY KEY (category_id,product_id),
    UNIQUE (category_id,product_id)
);

-- Create feed product table

CREATE TABLE IF NOT EXISTS category_best_product (
    category_id INT NOT NULL,
    product_id INT NOT NULL,
    PRIMARY KEY (category_id,product_id),
    UNIQUE (category_id,product_id)
);


-- Create relationship table between users and products

CREATE TABLE IF NOT EXISTS user_products (
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    followed BOOLEAN NOT NULL,
    count INT NOT NULL,
    PRIMARY KEY (user_id,product_id),
    UNIQUE  (user_id,product_id)
);

-- Create relationship table between users and categories

CREATE TABLE IF NOT EXISTS user_categories (
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (user_id,category_id),
    UNIQUE  (user_id,category_id)
);

-- Create table to store app key

CREATE TABLE IF NOT EXISTS application_tokens (
    id INT NOT NULL AUTO_INCREMENT,
    token TEXT NOT NULL,
    expires_at datetime,
    PRIMARY KEY (id)
);



ALTER TABLE products
ADD link VARCHAR(255);

ALTER TABLE products
DROP COLUMN link
ADD link VARCHAR(255) DEFAULT NULL;


ALTER TABLE user_categories
ADD count INT DEFAULT 0,
ADD followed BOOLEAN DEFAULT FALSE ;




