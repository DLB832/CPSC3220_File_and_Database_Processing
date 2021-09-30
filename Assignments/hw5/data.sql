use SuperStore; -- the database to be used

SET AUTOCOMMIT = 0; -- turns autocommit off before each table update.
--  ORDER TO INSERT DATA
-- 1: address
-- 2: customer
-- 3: order
-- 4: product
-- 5: warehouse
-- 6: order_item
-- 7: product_warehouse

INSERT INTO SuperStore.address (street,city,state,zip) 
    -- seperate different data values with a () to mark a record and , between records. terminate with ;
	VALUES 
    -- ('street','city','state','zip')
    ('5800 Home House Court','Chattanooga','TN','37415'),
    ('123 Address Lane', 'A real city', 'MN', '00342'),
    ('1616 One House Ln', 'Lansing', 'MI', '19987');

    COMMIT;
