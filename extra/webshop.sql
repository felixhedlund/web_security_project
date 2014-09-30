SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS order_products;
DROP TABLE IF EXISTS reviews;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE customers (
  id           bigint AUTO_INCREMENT PRIMARY KEY,
  username     text NOT NULL,
  password     char(64) NOT NULL,
  salt         char(16) NOT NULL,
  address      text NOT NULL);

CREATE TABLE products (
  id       bigint AUTO_INCREMENT PRIMARY KEY,
  name     text NOT NULL,
  image    text NOT NULL,
  price    bigint NOT NULL);


CREATE TABLE reviews (
  message        text NOT NULL,
  customer_id    bigint NOT NULL REFERENCES customers(id),
  product_id     bigint NOT NULL REFERENCES products(id),
  PRIMARY KEY (customer_id, product_id));

##### TEST DATA #####
INSERT INTO products VALUES (NULL, 'Sphynx', 'assets/images/cat01.jpg', 1500);
INSERT INTO products VALUES (NULL, 'Sphynx #2', 'assets/images/cat02.jpg', 2000);
