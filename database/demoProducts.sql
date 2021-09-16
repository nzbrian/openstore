INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '1', 
	    '', 
	    'Tools',  
		'/commercial/tools_small.gif',
		'/commercial/tools_large.jpg', 
		'1', 
		'1');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '2', 
	    '', 
	    'Bikes',  
		'/commercial/bikes_small.gif',
		'/commercial/bikes_large.jpg', 
		'1', 
		'1');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '3', 
	    '', 
	    'Houses',  
		'/commercial/houses_small.gif',
		'/commercial/houses_large.jpg', 
		'1', 
		'1');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '4', 
	    '2', 
	    'Mountain Bikes',  
		'/commercial/mtb_small.gif',
		'/commercial/mtb_large.jpg', 
		'1', 
		'1');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '5', 
	    '2', 
	    'Road Bikes',  
		'/commercial/roadBikes_small.gif',
		'/commercial/roadBikes_large.jpg', 
		'1', 
		'1');
		
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '6', 
	    '', 
	    'seesaw',  
		'/commercial/seesaw_small.gif',
		'/commercial/seesaw_large.jpg', 
		'1', 
		'1');
INSERT INTO Product (menuId, name, description1, description2, type, cost, weight, productImage, graphicImage, color1, color2) 
	VALUES (
	    '6',
		'seesaw', 
		'it\'s a seesaw', 
		'Here\'s some blurb about a seesaw', 
		'it\'s a bit of wood on a log', 
		'200', 
		'3000', 
		'/commercial/seesaw_product.jpg', 
		'/commercial/seesaw_graphic.jpg',
		'00FF35', 
		'000000');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '7', 
	    '', 
	    'a book',  
		'/commercial/book_small.gif',
		'/commercial/book_large.jpg', 
		'1', 
		'1');
INSERT INTO Product (menuId, name, description1, description2, type, cost, weight, productImage, graphicImage, color1, color2) 
	VALUES (
	    '7',
		'a book', 
		'it\'s made of paper', 
		'Here\'s some blurb about a book', 
		'it\'s good to read', 
		'2500', 
		'300', 
		'/commercial/book_product.jpg', 
		'/commercial/book_graphic.jpg',
		'00FF35', 
		'000000');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '8', 
	    '', 
	    'a shoe',  
		'/commercial/shoe_small.gif',
		'/commercial/shoe_large.jpg', 
		'1', 
		'1');
INSERT INTO Product (menuId, name, description1, description2, type, cost, weight, productImage, graphicImage, color1, color2) 
	VALUES (
	    '8',
		'a shoe', 
		'it\'s a nice shoe', 
		'Here\'s some blurb about a shoe', 
		'it\'s comfy', 
		'10000', 
		'1000', 
		'/commercial/shoe_product.jpg', 
		'/commercial/shoe_graphic.jpg',
		'00FF35', 
		'000000');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '9', 
	    '1', 
	    'a spade',  
		'/commercial/shovel_small.gif',
		'/commercial/shovel_graphic.jpg', 
		'1', 
		'1');
INSERT INTO Product (menuId, name, description1, description2, type, cost, weight, productImage, graphicImage, color1, color2) 
	VALUES (
	    '9', 
		'a spade', 
		'it\'s good for digging', 
		'Here\'s some blurb about a spade', 
		'it\'s got a wooden handle', 
		'800', 
		'300', 
		'/commercial/shovel_product.jpg', 
		'/commercial/shovel_graphic.jpg',
		'00FF35', 
		'000000');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '10', 
	    '1', 
	    'a garden fork',  
		'/commercial/fork_small.gif',
		'/commercial/fork_graphic.jpg', 
		'1', 
		'1');
INSERT INTO Product (menuId, name, description1, description2, type, cost, weight, productImage, graphicImage, color1, color2) 
	VALUES (
	    '10', 
		'a garden fork', 
		'it\'s good for loosening soil', 
		'Here\'s some blurb about a fork', 
		'it\'s for garden use only', 
		'800', 
		'300', 
		'/commercial/fork_product.jpg', 
		'/commercial/fork_graphic.jpg',
		'00FF35', 
		'000000');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '11', 
	    '3', 
	    'a nice house',  
		'/commercial/houses_small.gif',
		'/commercial/house_product.jpg', 
		'1', 
		'1');
INSERT INTO Product (menuId, name, description1, description2, type, cost, weight, productImage, graphicImage, color1, color2) 
	VALUES (
	    '11', 
		'a nice house', 
		'it\'s a very nice house', 
		'Here\'s some blurb about the house', 
		'made from bricks', 
		'19000000', 
		'900000', 
		'/commercial/house_product.jpg', 
		'/commercial/house_graphic.jpg',
		'00FF35', 
		'000000');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '12', 
	    '3', 
	    'a castle',  
		'/commercial/houses_small.gif',
		'/commercial/castle_product.jpg', 
		'1', 
		'1');
INSERT INTO Product (menuId, name, description1, description2, type, cost, weight, productImage, graphicImage, color1, color2) 
	VALUES (
	    '12', 
		'a castle', 
		'it\'s a very nice castle', 
		'Here\'s some blurb about the castle', 
		'made from granite', 
		'600000000', 
		'90000000', 
		'/commercial/castle_product.jpg', 
		'/commercial/castle_graphic.jpg',
		'00FF35', 
		'000000');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '13', 
	    '4', 
	    'Cannonblast V900',  
		'/commercial/mtb_small.gif',
		'/commercial/cannonblastV900_product.jpg', 
		'1', 
		'1');
INSERT INTO Product (menuId, name, description1, description2, type, cost, weight, productImage, graphicImage, color1, color2) 
	VALUES (
	    '13', 
		'Cannonblast V900', 
		'it\'s a bike', 
		'Here\'s some blurb about the bike', 
		'made from 6061 alloy', 
		'149900', 
		'15000', 
		'/commercial/cannonblastV900_product.jpg', 
		'/commercial/cannonblastV900_graphic.jpg',
		'00FF35', 
		'000000');
		
INSERT INTO MenuItem (id, parentMenuId, name, smallImage, largeImage, saleTypeId, display) 
	VALUES (
	    '14', 
	    '4', 
	    'Martin EzyPeak',  
		'/commercial/mtb_small.gif',
		'/commercial/martinEzyPeak_product.jpg', 
		'1', 
		'1');
INSERT INTO Product (menuId, name, description1, description2, type, cost, weight, productImage, graphicImage, color1, color2) 
	VALUES (
	    '14', 
		'Martin EzyPeak', 
		'it\'s a bike', 
		'Here\'s some blurb about the bike', 
		'made from 6061 alloy', 
		'99900', 
		'17000', 
		'/commercial/martinEzyPeak_product.jpg', 
		'/commercial/martinEzyPeak_graphic.jpg',
		'00FF35', 
		'000000');
	

	
INSERT INTO Coupon (code, discount, start, end)
    VALUES (
        'discount',
        '10',
        '1',
        '999999999999');
	
				 
ANALYZE TABLE Product;
ANALYZE TABLE Coupon;