INSERT INTO SaleType (id, type) VALUES ('1','General');

INSERT INTO Country (id, country) VALUES ('1', 'Australia');
INSERT INTO Country (id, country) VALUES ('2', 'New Zealand');
INSERT INTO Country (id, country) VALUES ('3', 'USA');
INSERT INTO Country (id, country) VALUES ('4', 'United Kingdom');
INSERT INTO Country (id, country) VALUES ('5', 'Austria');
INSERT INTO Country (id, country) VALUES ('6', 'Belgium');
INSERT INTO Country (id, country) VALUES ('7', 'Canada');
INSERT INTO Country (id, country) VALUES ('8', 'China');
INSERT INTO Country (id, country) VALUES ('9', 'Denmark');
INSERT INTO Country (id, country) VALUES ('10', 'Fiji');
INSERT INTO Country (id, country) VALUES ('11', 'Finland');
INSERT INTO Country (id, country) VALUES ('12', 'France');
INSERT INTO Country (id, country) VALUES ('13', 'Germany');
INSERT INTO Country (id, country) VALUES ('14', 'Greece');
INSERT INTO Country (id, country) VALUES ('15', 'Hong Kong, China');
INSERT INTO Country (id, country) VALUES ('16', 'India');
INSERT INTO Country (id, country) VALUES ('17', 'Indonesia');
INSERT INTO Country (id, country) VALUES ('18', 'Ireland');
INSERT INTO Country (id, country) VALUES ('19', 'Israel');
INSERT INTO Country (id, country) VALUES ('20', 'Italy');
INSERT INTO Country (id, country) VALUES ('21', 'Japan');
INSERT INTO Country (id, country) VALUES ('22', 'Korea, South');
INSERT INTO Country (id, country) VALUES ('23', 'Malaysia');
INSERT INTO Country (id, country) VALUES ('24', 'Malta');
INSERT INTO Country (id, country) VALUES ('25', 'Netherlands');
INSERT INTO Country (id, country) VALUES ('26', 'New Caledonia');
INSERT INTO Country (id, country) VALUES ('27', 'Norway');
INSERT INTO Country (id, country) VALUES ('28', 'Papua New Guinea');
INSERT INTO Country (id, country) VALUES ('29', 'Philipines');
INSERT INTO Country (id, country) VALUES ('30', 'Poland');
INSERT INTO Country (id, country) VALUES ('31', 'Singapore');
INSERT INTO Country (id, country) VALUES ('32', 'Soloman Islands');
INSERT INTO Country (id, country) VALUES ('33', 'South Africa');
INSERT INTO Country (id, country) VALUES ('34', 'Spain');
INSERT INTO Country (id, country) VALUES ('35', 'Sri Lanka');
INSERT INTO Country (id, country) VALUES ('36', 'Sweden');
INSERT INTO Country (id, country) VALUES ('37', 'Switzerland');
INSERT INTO Country (id, country) VALUES ('38', 'Taiwan');
INSERT INTO Country (id, country) VALUES ('39', 'Thailand');
INSERT INTO Country (id, country) VALUES ('40', 'Vietnam');



INSERT INTO ShippingRate (id, name, expectedDaysTaken, flagfall, incrementalMeasureType, incrementalMeasure, 
							incrementalValue, maxMeasure) 
	VALUES ('1', "Australia Post International Air Mail Zone A", '7', '600', 'grams', '0', '0', '20000');
	
INSERT INTO ShippingRate (id, name, expectedDaysTaken, flagfall, incrementalMeasureType, incrementalMeasure, 
							incrementalValue, maxMeasure) 
	VALUES ('2', "Australia Post International Air Mail Zone B", '7', '700', 'grams', '0', '0', '20000');
	
INSERT INTO ShippingRate (id, name, expectedDaysTaken, flagfall, incrementalMeasureType, incrementalMeasure, 
							incrementalValue, maxMeasure) 
	VALUES ('3', "Australia Post International Air Mail Zone C", '7', '800', 'grams', '0', '0', '20000');
	
INSERT INTO ShippingRate (id, name, expectedDaysTaken, flagfall, incrementalMeasureType, incrementalMeasure, 
							incrementalValue, maxMeasure) 
	VALUES ('4', "Australia Post International Air Mail Zone D", '7', '950', 'grams', '0', '0', '20000');
	
INSERT INTO ShippingRate (id, name, expectedDaysTaken, flagfall, incrementalMeasureType, incrementalMeasure, 
							incrementalValue, maxMeasure) 
	VALUES ('5', "Australia Post - Flat Rate", '3', '1200', 'grams', '99999999', '0', '9999999999');

	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('1', '251', '900', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('1', '501', '1250', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('1', '751', '1550', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('1', '1001', '1900', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('1', '1251', '2200', '9999', '0');
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('1', '1501', '2550', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('1', '1751', '2850', '9999', '0');
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('1', '2001', '3200', '500', '350');
	
	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('2', '251', '1100', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('2', '501', '1550', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('2', '751', '1950', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('2', '1001', '2400', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('2', '1251', '2800', '9999', '0');
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('2', '1501', '3250', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('2', '1751', '3650', '9999', '0');
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('2', '2001', '4100', '500', '450');
	
	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('3', '251', '1300', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('3', '501', '1850', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('3', '751', '2350', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('3', '1001', '2900', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('3', '1251', '3400', '9999', '0');
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('3', '1501', '3950', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('3', '1751', '4450', '9999', '0');
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('3', '2001', '5100', '500', '650');
	
	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('4', '251', '1550', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('4', '501', '2200', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('4', '751', '2800', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('4', '1001', '3450', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('4', '1251', '4050', '9999', '0');
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('4', '1501', '4700', '9999', '0');	
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('4', '1751', '5300', '9999', '0');
	
INSERT INTO ShippingCalc (rateId, measureFrom, flagfall, incrementalMeasure, incrementalValue)
	VALUES ('4', '2001', '6150', '500', '850');
	
	
	
	
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('1', '5');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('2', '1');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('3', '3');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('4', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('5', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('6', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('7', '3');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('8', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('9', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('10', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('11', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('12', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('13', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('14', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('15', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('16', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('17', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('18', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('19', '3');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('20', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('21', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('22', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('23', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('24', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('25', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('26', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('27', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('28', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('29', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('30', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('31', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('32', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('33', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('34', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('35', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('36', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('37', '4');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('38', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('39', '2');
INSERT INTO CountryShipping (countryId, rateId)
	VALUES ('40', '2');
	
ANALYZE TABLE InvoiceItem;
ANALYZE TABLE InvoiceShipping;
ANALYZE TABLE Note;	
ANALYZE TABLE OrderHistory;					
ANALYZE TABLE OrderProducts;					
ANALYZE TABLE AnOrder;				 
ANALYZE TABLE Product;			 
ANALYZE TABLE MenuItem;
ANALYZE TABLE Customer;
ANALYZE TABLE SaleType;
ANALYZE TABLE Address;
ANALYZE TABLE CountryShipping;
ANALYZE TABLE ShippingCalc;
ANALYZE TABLE ShippingRate;
ANALYZE TABLE Country;	