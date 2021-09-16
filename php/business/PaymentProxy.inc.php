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

require_once('business/Config.inc.php');

/*
 * This class provides a facade to all functionality provided by the payment gateway.
 * This is an empty implementation. I plan to talk to different payment gateways and
 * with their permission start to integrate their payment solutions here.
 * The actual PaymentGateway implementation to use is currently decided by which 
 * commercial prefix you put in the Config object. Later it will be decided by the ProxyMother.
 */
class GatewayResponse {
	var $success;
	var $MerchantReference;
	var $CardHolderName;
	var $AuthCode;
	var $Amount;
	var $CurrencyName;
	var $TxnType;
	var $CardHolderResponseText;
	var $CardHolderResponseDescription;
	var $MerchantResponseText;
	var $GatewayTxnRef;
}


/*
 * The payment proxy interface. Implementations of this must be created by the ProxyMother
 */
class PaymentProxy {
	
	var $config;
    
    function PaymentProxy(&$config) {
        $this->config = &$config;   
    }
    
    
	/**
	 * public abstract:
	 * Makes a payment to our comapany through the payment gateway
	 * $name the name on the card
	 * $amount in dollars, eg '12', '18.50'
	 * $ccnum the bare number eg 4111111111111111
	 * $ccmm expiry month of card 01 .. 12
	 * $ccyy expiry year of card 04 .. 99
	 * $orderId the unique reference number that will be used to identify this order
	 * returns a GatewayResponse object.
	 */	
	function &makePayment($name, $amount, $ccnum, $ccmm, $ccyy, $orderId) {
		return NULL;
	}

}
?>
