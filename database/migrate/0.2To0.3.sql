-- because I forgot to add constraint names to the foreign keys in OpenStore 0.2 it is recommended
-- that you create a new database using the OpenStore 0.3 scripts.
-- if that is not possible then please use the script here to migrate the data.
-- This migration script relies on the ForeignKeys in the AnOrder table being called
-- AnOrder_ibfk_1 and AnOrder_ibfk_2. You can use the "show create table AnOrder" mysql 
-- query to confirm that these are the correct names. 

CREATE TABLE Coupon (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					code VARCHAR(10) NOT NULL,
					discount INT NOT NULL,
					start BIGINT NOT NULL,
					end BIGINT NOT NULL,
					
					PRIMARY KEY (id),
					UNIQUE id (id),
					UNIQUE code (code),
					INDEX idx(id)
) TYPE=INNODB;


CREATE TABLE InvoiceCoupon (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					orderId INT UNSIGNED NOT NULL,
					code VARCHAR(10)  NOT NULL,
					discount INT NOT NULL,
					
					
					PRIMARY KEY (id),
					UNIQUE id (id),
					INDEX orderIdx(orderId),
					FOREIGN KEY (orderId) REFERENCES AnOrder(id)
) TYPE=INNODB;

ALTER TABLE AnOrder DROP FOREIGN KEY `AnOrder_ibfk_1`;
ALTER TABLE AnOrder DROP FOREIGN KEY `AnOrder_ibfk_2`;
ALTER TABLE AnOrder DROP INDEX Order_customerIndex;
ALTER TABLE AnOrder DROP INDEX Order_addressIndex;
ALTER TABLE AnOrder DROP INDEX Order_statusIndex;	
								
ALTER TABLE AnOrder ADD COLUMN couponId INT UNSIGNED after password;

ALTER TABLE AnOrder ADD INDEX Order_couponIndex(couponId);
ALTER TABLE AnOrder ADD INDEX Order_customerIndex(customerId);
ALTER TABLE AnOrder ADD INDEX Order_statusIndex(status);
ALTER TABLE AnOrder ADD INDEX Order_addressIndex(addressId);

ALTER TABLE ANOrder ADD CONSTRAINT AnOrder_FK_1 FOREIGN KEY (customerId) REFERENCES Customer(id);
ALTER TABLE ANOrder ADD CONSTRAINT AnOrder_FK_2 FOREIGN KEY (couponId) REFERENCES Coupon(id);
ALTER TABLE ANOrder ADD CONSTRAINT AnOrder_FK_3 FOREIGN KEY (addressId) REFERENCES Address(id);

