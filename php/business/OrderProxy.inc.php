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

require_once  'model/Cart.inc.php';
require_once  'model/InvoiceItemList.inc.php';
require_once  'model/OrderHistoryList.inc.php';

require_once  'persistence/Address.inc.php';
require_once  'persistence/CountryShipping.inc.php';
require_once  'persistence/Coupon.inc.php';
require_once  'persistence/Customer.inc.php';
require_once  'persistence/InvoiceCoupon.inc.php';
require_once  'persistence/InvoiceItem.inc.php';
require_once  'persistence/InvoiceShipping.inc.php';
require_once  'persistence/Note.inc.php';
require_once  'persistence/Order.inc.php';
require_once  'persistence/OrderHistory.inc.php';
require_once  'persistence/OrderProducts.inc.php';
require_once  'persistence/Product.inc.php';
require_once  'persistence/ShippingRate.inc.php';

require_once 'util/DisplayUtil.inc.php';

/*
 * The facade for all ordering functionality.
 */
class OrderProxy {

    var $config;
    var $shippingProxy;
    var $paymentProxy;
    var $emailProxy;
    var $displayUtil;

    function OrderProxy(&$config, &$shippingProxy, &$paymentProxy, &$emailProxy, &$displayUtil) {
        $this->config = &$config;   
        $this->shippingProxy = &$shippingProxy;
        $this->paymentProxy = &$paymentProxy;
        $this->emailProxy = &$emailProxy;
        $this->displayUtil = &$displayUtil;
    }

	/*
	 * public static:
	 * create the order in the database and send the credit card details through to the payment gateway
	 */
	function createOrder(&$cart, $creditName, $creditNumber, $creditMonth, $creditYear, $shippingRateId) {
		//trigger_error("About to create order", E_USER_ERROR);
		//echo ("About to create order");
	    
	    $order = NULL;
		// sanity check credit card 
		if ($this->sanityCheckCreditCard($creditName, $creditNumber, $creditMonth . '/' . $creditYear, NULL)) { 
		
			// create order in database with status 'ordered'
			
			$countryId = $cart->address->countryId;
			
			$shippingRate = &new ShippingRate($this->config, $shippingRateId);
			$shippingRate->read();
			
			if ($this->shippingProxy->checkShippingForCountry($shippingRate, $countryId)) {
			
//			    echo '!!!!! shipping rate is correct !!!!!';
			    
    			$order = &$this->storeOrder($cart, $shippingRate);	
    			if ($order) {
    //    			print_r($order);
        			
        			// make payment to bank - with DPS this will give immediate results. 
        			$amount = ($order->cost / 100);
        			$response = &$this->paymentProxy->makePayment($creditName, $amount, $creditNumber, $creditMonth, $creditYear, $order->id);
        			
        			//$note = 
        			$this->storeResponse($order, $response);
        			//print_r($note);
        			
        			if ($response->success) {
        				// change order status to 'accepted', 
        				$order->setAccepted();
        				$order->update();
        				$history = &new OrderHistory($this->config);
        				$history->markOrder($order);
        				$history->create(); 
        				
        				// send email to customer with order link and password to track order, Bcc Bix
        				$customer = &new Customer($this->config, $order->customerId);
        				$customer->read();
        				$this->emailProxy->sendConfirmation($order, $customer);
        				
        				// empty the cart;
        				$cart = new Cart($this->config);
        				$cart->store();
        			}
        			else {
        				$order->setRejected();
        				$order->update();
        				$history = &new OrderHistory($this->config);
        				$history->markOrder($order);
        				$history->create(); 
        				trigger_error("Order was rejected: ". $order->id);	
        			}
    			}
    			else {
    			     trigger_error("There was a problem tryhing to store the order");   
    			}
			}
			else {
			     trigger_error("ShippingRate was invalid");   
			}
		}
		else {
		    trigger_error("CreditCard was invalid");   
		}
		return $order;
	}
	
	/**
	 * private static:
	 * Stores the result in a note for now
	 */
	function &storeResponse(&$order, &$gatewayResponse) {
		$note = &new Note($this->config);
		$note->date = time();
		$note->orderId = $order->id;
		
		$text = 'Success: ' . $gatewayResponse->success . "\n";
		$text .= 'Merchant Reference: ' . $gatewayResponse->MerchantReference . "\n";
		$text .= 'Card Holder Name: ' . $gatewayResponse->CardHolderName . "\n";
		$text .= 'Auth Code: ' . $gatewayResponse->AuthCode . "\n";
		$text .= 'Amount: ' . $gatewayResponse->Amount . "\n";
		$text .= 'Currency Name: ' . $gatewayResponse->CurrencyName . "\n";
		$text .= 'Txn Type: ' . $gatewayResponse->TxnType . "\n";
		$text .= 'Card Holder Response Text: ' . $gatewayResponse->CardHolderResponseText . "\n";
		$text .= 'Card Holder Response Description: ' . $gatewayResponse->CardHolderResponseDescription . "\n";
		$text .= 'Merchant Response Text: ' . $gatewayResponse->MerchantResponseText . "\n";
		$text .= 'Gateway Txn Ref: ' . $gatewayResponse->$GatewayTxnRef . "\n";
		
		$note->note = &$text;
		$note->create();
		return $note;
	}
	
	/*
	 * private static:
	 * Creates the actual order objects in the database;
	 */
	function &storeOrder(&$cart, &$shippingRate) {
		$cart->customer->create();
		$cart->address->create();	
		
		$cost = 0;
		$weight = 0;
		$noteText = '';
		
		$coupon = $cart->coupon;
		
		$productNames = array();
		$productCosts = array();
		foreach ($cart->contents as $productId=>$number) {
			$product = new Product($this->config);
			$product->id = $productId;
			$product->read();
		    $productCost = $product->cost;
		    if (null != $coupon) {
		        $productCost = $coupon->discountProduct($product);
		    }
			$cost += $number * $productCost;
			$weight += $number * $product->weight;
			$noteText .= $number . ' * ' . $product->name . ' at ' . $this->config->getCurrency() . DisplayUtil::displayDollars($productCost) . " each\n";
		    $productNames[$productId] = $product->name;
		    $productCosts[$productId] = $productCost;
		}
		
		$shippingCost = $this->shippingProxy->calculateShipping($shippingRate, $weight, $cost);
		$cost += $shippingCost;
		
		$order = &new Order($this->config);
		$order->customerId = $cart->customer->id;
		$order->addressId = $cart->address->id;
		$order->cost = $cost;
		if (null != $coupon) {
		      $order->couponId = $coupon->id; 
		}
		$order->setOrdered();
		$order->setNow();
		$order->create();
		if ($order->id) {
		
    		foreach ($cart->contents as $productId=>$number) {
    			$orderProduct = new OrderProducts($this->config);
    			$orderProduct->orderId = $order->id;
    			$orderProduct->productId = $productId;
    			$orderProduct->number = $number;
    			$orderProduct->create();
    			
    			$invoiceItem = new InvoiceItem($this->config);
    			$invoiceItem->orderId = $order->id;
    			$invoiceItem->name = $productNames[$productId];
    			$invoiceItem->totalCost = $number * $productCosts[$productId];
    			$invoiceItem->number = $number;
    			$invoiceItem->create();
    		}
    		
    		
    		$invoiceShipping = &new InvoiceShipping($this->config);
    		$invoiceShipping->orderId = $order->id;
    		$invoiceShipping->name = $shippingRate->name;
    		$invoiceShipping->cost = $shippingCost;
    		$invoiceShipping->expectedDaysTaken = $shippingRate->expectedDaysTaken;
    		$invoiceShipping->create();
    		
    		if (null != $coupon) {
        		$invoiceCoupon = &new InvoiceCoupon($this->config);
        		$invoiceCoupon->orderId = $order->id;
        		$invoiceCoupon->code = $coupon->code;
        		$invoiceCoupon->discount = $coupon->discount;
        		$invoiceCoupon->create();
    		}
    		
    		
    		$history = &new OrderHistory($this->config);
    		$history->markOrder($order);
    		$history->create(); 
    		
    		// for now put complete order details in as a note
    		$note = &new Note($this->config);
    		$note->date = time();
    		$note->orderId = $order->id;
    		
    		$text = 'Shipping Method: ' . $shippingRate->name . "\n";
    		
    		$text .= 'Shipping Cost: ' . $this->config->getCurrency() . $this->displayUtil->displayDollars($shippingCost) . "\n";
    		$text .= 'Shipping Time: ' . $shippingRate->expectedDaysTaken . " days\n";
    		if (null != $coupon) {
    		      $text .= 'Coupon: ' . $coupon->code . ', ' . $coupon->discount . "%\n";   
    		}
    		$text .= $noteText;
    		
    		$note->note = &$text;
    		$note->create();
		}
		else {
		    $order = null;   
		}
		
		return $order;
	}
	
	/*
	 * public static:
	 * gets the Order with id=$id, only if the password is correct
	 * $id is a number
	 * $password is a string
	 * returns an instance of Order, or NULL if the password is incorrect
	 */
	function &getOrder($id, $password) {
		$result = NULL;
		$order = &new Order($this->config, $id);
		$order->read();
		$realPassword = $order->password;
		if (0 == strcmp($realPassword, $password)) {
			$result = &$order;	
		}
		return $result;
	}
	
	/*
	 * public static:
	 * gets the history for an order
	 * $order is an instance of Order
	 * returns an array of OrderHistory
	 */
	function &getOrderHistory($order) {
		$result = NULL;
		if ($order)	{
			$history = &new OrderHistoryList($this->config);
			$history->read('orderId', $order->id, FALSE, FALSE, 'date');
			$result = &$history->list;
		}
		return $result;
	}

	/*
	 * public static:
	 * returns the InvoiceShipping instance for an Order
	 * $order is an instance of Order
	 */
    function &getInvoiceShipping($order) {
        $result = &new InvoiceShipping($this->config);
		$orderId = mysql_escape_string($order->id);
		$sql = "SELECT * FROM InvoiceShipping WHERE orderId='$orderId'";
		$result->readFromSQL($sql);
		return $result;
    } 
	
    /*
     * public static:
     * returns an array of InvoiceItem for an order
	 * $order is an instance of Order
     */
	function &getInvoiceItems($order) {
	   $result = &new InvoiceItemList($this->config);
	   $result->read('orderId', $order->id);
	   return $result->list;   
	}
    
	/*
	 * private static:
	 * returns true iff the credit card details could represent a valid credit card
	 * TODO: implement this method. Needs Luhn check and date check
	 */
	function sanityCheckCreditCard($creditName, $creditNumber, $creditExpiry, $creditSecret) {
		return true;
	}
	
}
?>