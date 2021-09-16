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
?><?PHP

require_once 'adminmodel/EditOrderView.inc.php';
require_once 'adminmodel/NoteList.inc.php';
require_once 'adminmodel/OrderProductsList.inc.php';
require_once 'adminmodel/OrderViewList.inc.php';

require_once 'business/EmailProxy.inc.php';

require_once 'model/CouponList.inc.php';
require_once 'model/OrderHistoryList.inc.php';
require_once 'model/ProductList.inc.php';
require_once 'model/SaleTypeList.inc.php';

require_once 'persistence/Address.inc.php';
require_once 'persistence/Customer.inc.php';
require_once 'persistence/InvoiceCoupon.inc.php';
require_once 'persistence/MenuItem.inc.php';
require_once 'persistence/Note.inc.php';
require_once 'persistence/Order.inc.php';
require_once 'persistence/Product.inc.php';
require_once 'persistence/SaleType.inc.php';

/*
 * Contains the business logic that allows administration operations to occur. 
 * All pages in /openstore/webroot/admin use this proxy.
 */
class AdminProxy {

    var $config;
    var $emailProxy;
    var $orderProxy;

    function AdminProxy(&$config, &$emailProxy, &$orderProxy) {
        $this->config = &$config;       
        $this->emailProxy = &$emailProxy;
        $this->orderProxy = &$orderProxy;
    }

	/*
	 * public static:
	 * Return all products in the database
	 */
	function &getAllProducts() {
		$list = &new ProductList($this->config);
		$list->read();
		return $list->list;
	}
	
	function &getAllCoupons() {
		$list = &new CouponList($this->config);
		$list->read();
		return $list->list;
	}
	
	function &getAllOrders() {
		$list = &new OrderList($this->config);
		$list->read();
		return $list->list;	
	}
	
	/*
	 * returns a list of all menu items that are not products.
	 */
	function &getAllMenus() {
		$list = &new MenuItemList($this->config);
		$sql = 'SELECT MenuItem.* FROM MenuItem LEFT JOIN Product ON MenuItem.id=Product.menuId WHERE Product.menuId IS NULL ORDER BY MenuItem.id';
		$list->readFromSQL($sql);
		return $list->list;	
	}
	
	function &getProduct($id) {
		$product = &new Product($this->config, $id);
		$product->read();
		return $product;	
	}
	
	function &getCoupon($id) {
		$result = &new Coupon($this->config, $id);
		$result->read();
		return $result;	
	}
	
	function &getMenuItem($id) {
		$result = &new MenuItem($this->config, $id);
		$result->read();
		return $result;	
	}
	
	function createProduct(&$product) {
		$product->create();	
	}
	
	function createMenuItem(&$menuItem) {
		$menuItem->create();	
	}
	
	function createCoupon(&$coupon) {
		$coupon->create();	
	}
	
	/*
	 * public static:
	 * return all sale types in the database
	 */
	function &getAllSaleTypes() {
		$list = &new SaleTypeList($this->config);
		$list->read();
		return $list->list;	
	}
	
	function &getAllOpenOrderViews() {
		$list = &new OrderViewList($this->config);
		$list->readOrderView('status', array('ordered', 'processing', 'accepted', 'rejected', 'lost', 'returned'));
		return $list->list;	
	}
	
	function &getOrderViews($status) {
		$list = &new OrderViewList($this->config);
		$list->readOrderView('status', array($status));
		return $list->list;	
	}
	
	/*
	 * creates an OrderView showing all information needed to display an order and its history.
	 */
	function &getOrder($id) {
		$view = &new EditOrderView($this->config);
		$order = &new Order($this->config, $id);
		$order->read();
		$view->order = &$order;
		
		$customer = &new Customer($this->config, $order->customerId);
		$customer->read();
		$view->customer = &$customer;
		
		$address = &new Address($this->config, $order->addressId);
		$address->read();
		$view->address = &$address;
		
		$notes = &new NoteList($this->config);
		$notes->read('orderId', $order->id, FALSE, FALSE, 'date');	
		$view ->notes = &$notes->list;
		
		$history = &new OrderHistoryList($this->config);
		$history->read('orderId', $order->id, FALSE, FALSE, 'date');
		$view->history = &$history->list;
		
		$orderProducts = &new OrderProductsList($this->config);
		$orderProducts->read('orderId', $order->id);
		foreach ($orderProducts->list as $op) {
			$view->quantities[$op->productId] = $op->number;	
			
			$product = &new Product($this->config, $op->productId);
			$product->read();
			$view->products[$op->productId] = $product;
		}
		
		$view->possibleStatus = &$this->getPossibleStatus();
		
		$saleType = &new SaleType($this->config, $customer->saleTypeId);
		$saleType->read();
		$view->saleType = &$saleType;
		
		$coupon = new InvoiceCoupon($this->config);
        $coupon->orderId = $order->id;
        $coupon->readFromOrderId();
        if (null != $coupon->code) {
            $view->coupon = &$coupon;   
        }
		return $view;
	}
	
	/*
	 * updates the status, order history and / or adds a note to an order.
	 */
	function updateOrder($id, $status, $note) {
		$order = &new Order($this->config, $id);
		$order->read();
		
		$oldStatus = $order->status;
		
		//echo "status='", $status,"' and oldStatus='", $oldStatus, "'";
		
		if (0 != strcmp($status, $oldStatus)) {
			$order->status = $status;
			$order->update();
			$orderHistory = &new OrderHistory($this->config);
			$orderHistory->markOrder($order);	
			$orderHistory->create();
			
			if (0 == strcmp($status, 'shipped')) {
				// email the customer to let them know
				$customer = &new Customer($this->config, $order->customerId);
				$customer->read();
                $invoiceShipping = $this->orderProxy->getInvoiceShipping($order);
                
				$this->emailProxy->sendShipmentNotice($order, $customer, $invoiceShipping);	
			}
		}	
		
		if ($note) {
			$dbNote = &new Note($this->config);
			$dbNote->note = &$note;
			$dbNote->orderId = $order->id;
			$dbNote->date = time();
			$dbNote->create();	
		}		
	}
	
	function &getPossibleStatus() {
		return array('ordered', 'processing', 'accepted', 'shipped', 'rejected', 'lost', 'returned', 'closed');	
	}
	
}

?>