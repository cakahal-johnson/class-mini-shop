USE mini_shop_class;

-- categories
INSERT INTO categories (name, slug, description) VALUES ('Electronics', 'electronics', 'Phones, laptops, accessories'),
('Fashion', 'fashion', 'Clothing & accessories');

-- product
INSERT INTO products (category_id, name, slug, description, price, stock, image) VALUES (1, 'Wireless Earbugs', 'wireless-earbuds', 'BT 5.3, nosie reduction', 29.99, 120, 'default.png'),
(1, 'Laptop Sleeve 15"', 'laptop-sleeve-15', 'Water-resistant neoprene', 15.50, 80,  'default.png'),
(2, 'Classic T-Shirt', 'classic-t-shirt', '100% cotton, unisex', 9.99, 200, 'default.png')
(2, 'Sports Cap', 'sports-cap', 'Adjustable, breathable', 7.50, 150, 'default.png')

-- user
INSERT INTO users (name, email, password_hash, role) VALUES ('cakahal', 'user@examplecom', '1234', 'user' );