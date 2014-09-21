SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS order_products;
DROP TABLE IF EXISTS reviews;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE customers (
  id           bigint AUTO_INCREMENT PRIMARY KEY,
  full_name    text NOT NULL,
  address      text NOT NULL);

CREATE TABLE orders (
  id               bigint AUTO_INCREMENT PRIMARY KEY,
  customer_id      bigint NOT NULL REFERENCES customers(id),
  purchase_date    date NOT NULL);

CREATE TABLE products (
  id       bigint AUTO_INCREMENT PRIMARY KEY,
  name     text NOT NULL,
  image    text NOT NULL,
  price    bigint NOT NULL);

CREATE TABLE order_products (
  order_id      bigint NOT NULL REFERENCES orders(id),
  product_id    bigint NOT NULL REFERENCES products(id),
  CONSTRAINT order_product_pkey PRIMARY KEY (order_id, product_id));

CREATE TABLE reviews (
  message        text NOT NULL,
  customer_id    bigint NOT NULL REFERENCES customers(id),
  product_id     bigint NOT NULL REFERENCES products(id),
  CONSTRAINT review_pkey PRIMARY KEY (customer_id, product_id));

##### TEST DATA #####
INSERT INTO customers VALUES (NULL, 'John Doe', '1 Infinite Loop');
INSERT INTO products VALUES (NULL, 'Sphynx', '', 1500);

