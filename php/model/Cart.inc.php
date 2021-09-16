<?php
/*
copyright Brian Bannister 2004

This file is part of Open Store. http://openstore.org/

Open Store is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Open Store is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Open Store; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
?><?php

require_once 'business/Config.inc.php';
require_once 'model/Session.inc.php';
require_once 'model/ProductList.inc.php';
require_once 'persistence/Product.inc.php';



class Cart {
	
	
	/*
	 * protected static:
	 * The tag that the cart is stored against in the session
	 */
	var $CART_SESSION_TAG = 'cartTag';

	/*
	 * An array of ProductId=>numberInOrder
	 */
	var $contents = array();
	var $customer;
	var $address;
    var $config;
    var $coupon;
    
    function Cart(&$config) {
        $this->config = &$config; 
        $coupon = null;   
    }
	
	/*
	 * public static:
	 * Retreives the cart from the session
	 * return the user's cart
	 */
	function &getCart(&$config) {
		global $CART_SESSION_TAG;
		$session = &new Session($config);
		$cart = &$session->get($CART_SESSION_TAG);
		if (!$cart) {
			
	//		echo "<p>Cart: new cart: $cart</p>";
			
			$cart = &new Cart($config);
			$session->set($CART_SESSION_TAG, $cart);
		}
	//	else {
		
	//		echo "<p>Cart: existing cart: ";
	//		print_r($cart);
	//		echo "</p>";
		
	//	}
		
		return $cart;
	}
	
	/* 
	 * public:
	 * Stores the cart in to the session
	 */
	function store() {
		global $CART_SESSION_TAG;
		$session = &new Session($this->config);
		$session->set($CART_SESSION_TAG, $this);
	}
	
	/*
	 * public:
	 * Adds a product in to the cart.
	 * The cart will never store a product with a total quantity less than '1', for instance
	 * 		if the cart contains 1 apple and you add('apple', '-6') then the cart will contain no apples.
	 * You must call store() after the cart has been edited
	 */
	function add(&$product, $requestedQuantity) {		
		$result = true;
		
		$quantity = intval($requestedQuantity);
		
		if (((int)$quantity) == ((int)$requestedQuantity)) {

			$existing = $this->contents[$product->id];
			
			if ($existing) {
				$quantity += $existing;
			}
			
			if ($quantity > 0) {	
                $maxProductQuantityPerOrder = $this->config->getMaxProductQuantityPerOrder();
				if ($quantity > $maxProductQuantityPerOrder) {
					$quantity = $maxProductQuantityPerOrder;	
				}	
				$this->contents[$product->id]=$quantity;
			}	
			else {
				unset($this->contents[$product->id]);
				$this->contents = &array_values($this->contents);
			}
		}
		else {
			$result = false;
		}	
		
		return $result;
	}
	
	
	function debugContents() {
		foreach($this->contents as $key=>$value) {
			echo "<br>Cart:debugContents: $key = $value";
		}
	}
	
}



?>