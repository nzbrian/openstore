
CREATE TABLE Country (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					country VARCHAR(255) NOT NULL,
					PRIMARY KEY (id),
					UNIQUE id (id),
					UNIQUE country (country)
) TYPE=INNODB;


CREATE TABLE Address ( id INT UNSIGNED NOT NULL AUTO_INCREMENT,  
					street1 VARCHAR(255) NOT NULL,  
					street2 VARCHAR(255), 
					city VARCHAR(255) NOT NULL,
					state VARCHAR(255) NOT NULL,
					postcode VARCHAR(16),
					countryId INT UNSIGNED NOT NULL,  
					PRIMARY KEY (id),  
					UNIQUE id (id),
					INDEX Address_countryIdx(countryId),
					CONSTRAINT Address_FK_1 FOREIGN KEY (countryId) REFERENCES Country (id)
) TYPE=INNODB;
					
CREATE TABLE SaleType ( id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					type varchar(255),
					PRIMARY KEY (id),
					UNIQUE ID (id)
) TYPE=INNODB;

CREATE TABLE Customer ( id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					first VARCHAR(255),
					last VARCHAR(255) NOT NULL,
					middle VARCHAR(255),
					salutation VARCHAR(16),
					email VARCHAR(255) NOT NULL,
					phone1 VARCHAR(32) NOT NULL,
					phone2 VARCHAR(32),  
					saleTypeId INT UNSIGNED NOT NULL,
					PRIMARY KEY (id),  
					UNIQUE id (id),
					INDEX Customer_saleTypeIndex(saleTypeId),
					CONSTRAINT Customer_FK_1 FOREIGN KEY (saleTypeId) REFERENCES SaleType(id)
) TYPE=INNODB;

					 
CREATE TABLE MenuItem ( id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                    parentMenuId INT UNSIGNED,
					name VARCHAR(255) NOT NULL,
					smallImage VARCHAR(255) NOT NULL,
					largeImage VARCHAR(255) NOT NULL,
					saleTypeId INT UNSIGNED NOT NULL,  
					display TINYINT NOT NULL,
					
					PRIMARY KEY (id),  
					UNIQUE id (id),
					INDEX MenuItem_saleTypeIndex(saleTypeId),
					CONSTRAINT MenuItem_FK_1 FOREIGN KEY (saleTypeId) REFERENCES SaleType(id)
) TYPE=INNODB;

CREATE TABLE Coupon (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					code VARCHAR(10) NOT NULL,
					discount INT NOT NULL,
					start BIGINT NOT NULL,
					end BIGINT NOT NULL,
					
					PRIMARY KEY (id),
					UNIQUE id (id),
					UNIQUE code (code)
) TYPE=INNODB;
					 
CREATE TABLE Product ( id INT UNSIGNED NOT NULL AUTO_INCREMENT,
                    menuId INT UNSIGNED,
					name VARCHAR(255) NOT NULL,
					description1 TEXT NOT NULL,
					description2 TEXT,
					type TEXT,
					cost INT NOT NULL,
					weight MEDIUMINT NOT NULL,
					productImage VARCHAR(255) NOT NULL,
					graphicImage VARCHAR(255) NOT NULL,
					color1 VARCHAR(6) NOT NULL,
					color2 VARCHAR(6) NOT NULL,
					
					PRIMARY KEY (id),  
					UNIQUE id (id),
					INDEX Product_menu(menuId),
					CONSTRAINT Product_FK_1 FOREIGN KEY (menuId) REFERENCES MenuItem(id)
) TYPE=INNODB;

					
CREATE TABLE AnOrder ( id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					cost INT NOT NULL,
					customerId INT UNSIGNED NOT NULL,
					addressId INT UNSIGNED NOT NULL,
					status ENUM( 'ordered', 'processing', 'accepted', 
						'shipped', 'rejected', 'lost', 'returned', 'closed') NOT NULL,
					dateOrdered BIGINT NOT NULL,
					password VARCHAR(16) NOT NULL,
					couponId INT UNSIGNED,
					PRIMARY KEY (id),  
					UNIQUE id (id),
					INDEX Order_customerIndex(customerId),
					INDEX Order_addressIndex(addressId),
					INDEX Order_statusIndex(status),
					INDEX Order_couponIndex(couponId),
					CONSTRAINT AnOrder_FK_1 FOREIGN KEY (customerId) REFERENCES Customer(id),
					CONSTRAINT AnOrder_FK_2 FOREIGN KEY (couponId) REFERENCES Coupon(id),
					CONSTRAINT AnOrder_FK_3 FOREIGN KEY (addressId) REFERENCES Address(id)
) TYPE=INNODB;

					
					
CREATE TABLE OrderProducts ( id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					orderId INT UNSIGNED NOT NULL, 
					productId INT UNSIGNED NOT NULL,
					number MEDIUMINT NOT NULL,
					PRIMARY KEY (id),
					UNIQUE id (id),
					UNIQUE orderProduct (orderId, productId),
					INDEX orderIndex(orderId),
					INDEX productIndex(productId),
					CONSTRAINT OrderProducts_FK_1 FOREIGN KEY (orderId) REFERENCES AnOrder(id),
					CONSTRAINT OrderProducts_FK_2 FOREIGN KEY (productId) REFERENCES Product(id)
) TYPE=INNODB;
					
CREATE TABLE OrderHistory ( id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					date BIGINT NOT NULL,
					orderId INT UNSIGNED NOT NULL,
					status ENUM( 'ordered', 'processing', 'accepted', 
						'shipped', 'rejected', 'lost', 'returned', 'closed') NOT NULL,
					PRIMARY KEY (id),
					UNIQUE id (id),
					INDEX OrderHistory_orderIndex(orderId),
					INDEX OrderHistory_statusIndex(status),
					CONSTRAINT OrderHistory_FK_1 FOREIGN KEY (orderId) REFERENCES AnOrder(id)
) TYPE=INNODB;


					
CREATE TABLE Note (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					note TEXT NOT NULL,
					date BIGINT NOT NULL,
					orderId INT UNSIGNED NOT NULL,
					PRIMARY KEY (id),
					UNIQUE id (id),
					INDEX Note_orderIndex(orderId),
					CONSTRAINT Note_FK_1 FOREIGN KEY (orderId) REFERENCES AnOrder(id)
) TYPE=INNODB;	


CREATE TABLE ShippingRate (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					name VARCHAR(255) NOT NULL,
					expectedDaysTaken INT UNSIGNED NOT NULL,
					flagfall INT UNSIGNED NOT NULL,
					incrementalMeasureType ENUM( 'grams', 'cents' ) NOT NULL,
					incrementalMeasure INT UNSIGNED NOT NULL,
					incrementalValue INT UNSIGNED NOT NULL,
					maxMeasure INT UNSIGNED,
					
					PRIMARY KEY (id),
					UNIQUE id (id)
) TYPE=INNODB;	

CREATE TABLE ShippingCalc (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					rateId INT UNSIGNED NOT NULL,
					measureFrom INT UNSIGNED NOT NULL,
					flagfall INT UNSIGNED NOT NULL,
					incrementalMeasure INT UNSIGNED NOT NULL,
					incrementalValue INT UNSIGNED NOT NULL,
					
					PRIMARY KEY (id),
					UNIQUE id (id),
					INDEX rateIdx(rateId),
					INDEX measureFromIdx(measureFrom),
					CONSTRAINT ShippingCalc_FK_1 FOREIGN KEY (rateId) REFERENCES ShippingRate(id)
) TYPE=INNODB;	

CREATE TABLE CountryShipping (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					countryId INT UNSIGNED NOT NULL,
					rateId INT UNSIGNED NOT NULL,
					
					PRIMARY KEY (id),
					UNIQUE id (id),
					UNIQUE countryRate (countryId, rateId),
					UNIQUE forNowMakeCountryUnique (countryId),
					INDEX CountryShipping_countryIdx(countryId),
					INDEX CountryShipping_rateIdx(rateId),
					CONSTRAINT CountryShipping_FK_1 FOREIGN KEY (countryId) REFERENCES Country(id),
					CONSTRAINT CountryShipping_FK_2 FOREIGN KEY (rateId) REFERENCES ShippingRate(id)
) TYPE=INNODB;	

CREATE TABLE InvoiceCoupon (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					orderId INT UNSIGNED NOT NULL,
					code VARCHAR(10)  NOT NULL,
					discount INT NOT NULL,
					
					
					PRIMARY KEY (id),
					UNIQUE id (id),
					INDEX orderIdx(orderId),
					CONSTRAINT InvoiceCoupon_FK_1 FOREIGN KEY (orderId) REFERENCES AnOrder(id)
) TYPE=INNODB;

CREATE TABLE InvoiceItem (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					orderId INT UNSIGNED NOT NULL,
					name VARCHAR(255) NOT NULL,
					totalCost INT UNSIGNED NOT NULL,
					number MEDIUMINT NOT NULL,
					
					PRIMARY KEY (id),
					UNIQUE id (id),
					INDEX orderIdx(orderId),
					CONSTRAINT InvoiceItem_FK_1 FOREIGN KEY (orderId) REFERENCES AnOrder(id)
) TYPE=INNODB;	

CREATE TABLE InvoiceShipping (id INT UNSIGNED NOT NULL AUTO_INCREMENT,
					orderId INT UNSIGNED NOT NULL,
					name VARCHAR(255) NOT NULL,
					cost INT UNSIGNED NOT NULL,
					expectedDaysTaken  INT UNSIGNED NOT NULL,
					
					PRIMARY KEY (id),
					UNIQUE id (id),
					INDEX orderIdx(orderId),
					CONSTRAINT InvoiceShipping_FK_1 FOREIGN KEY (orderId) REFERENCES AnOrder(id)
) TYPE=INNODB;	


						
