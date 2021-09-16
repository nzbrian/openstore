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

require_once 'model/MenuItemList.inc.php';

require_once 'persistence/Coupon.inc.php';
require_once 'persistence/MenuItem.inc.php';
require_once 'persistence/Product.inc.php';
require_once 'persistence/SaleType.inc.php';

/*
 * The facade to all logic relating to stock and products.
 */
class StockProxy {

    var $config;
    
    function StockProxy(&$config) {
        $this->config = &$config;   
    }

	function &getAllMenuItems(&$saleType, $parentMenuId='') {
		$list = &new MenuItemList($this->config);
		$list->extendedRead('saleTypeId', $saleType->id, 'display', 1, 'parentMenuId', $parentMenuId);
		return $list->list;
	}

	function &getAProduct($id, $saleType) {
		$result = NULL;		
		$product = &new Product($this->config, $id);
		$product->read();
		if (($product->menuItem->saleTypeId == $saleType->id) && $product->menuItem->display) {
			$result = &$product;	
		}
		return $result;
	}
	
	function &getMenuItem($id, $saleType) {
		$result = NULL;		
		$menuItem = &new MenuItem($this->config, $id);
		$menuItem->read();
		if (($menuItem->saleTypeId == $saleType->id) && $menuItem->display) {
			$result = &$menuItem;	
		}
		return $result;
	}
	
	function getAProductFromMenuId($menuId, $saleType) {
	    $result = NULL;		
		$product = &new Product($this->config);
		$product->readForMenuItem($menuId);
		if (($product->menuItem->saleTypeId == $saleType->id) && $product->menuItem->display) {
			$result = &$product;	
		}
		return $result;     
	}
	
	
	
	/*
	 * public static:
	 * return an instance of SaleType with the type 'General' 
	 * This is used for regular customers
	 */
	function &getSaleTypeGeneral() {
		$result = &new SaleType($this->config);
		$result->type = 'General';
		$result->readFromType();
		return $result;
	}
	
	function &getCoupon($couponName) {
	    $result = null;
	    $coupon = &new Coupon($this->config); 
	    $coupon->code = $couponName;
	    $coupon->readFromCode();
	    $now = time();
	    $start = $coupon->start;
	    $end = $coupon->end;
//	    echo "now=$now, start=$start, end=$end";
	    if ($now > $start && $now < $end && (null == $coupon->validate())) {
	       $result = &$coupon; 
	    }  
	    return $result; 
	}


}





?>