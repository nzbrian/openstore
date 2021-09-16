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
require_once('business/OrderProxy.inc.php');

require_once('persistence/Customer.inc.php');
require_once('persistence/InvoiceShipping.inc.php');
require_once('persistence/Order.inc.php');

/*
 * This is the class that encapsulates all emails sent out to customers.
 */
class EmailProxy {
    
    var $config;
    
    function EmailProxy(&$config) {
        $this->config = &$config;
    }

	/*
	 * public static:
	 * sends out a confirmation of an order to the customer, and BCCs the local orders email address.
	 */
	function sendConfirmation(&$order, &$customer) {
				
		$adminEmailAddress = $this->config->getOrderManagersEmailAddress();
		$companyName = $this->config->getCompanyName();
		$subject = "Your order from $companyName";
		$confirmationText = $this->config->getTextForConfirmationEmail();		
		$message = '
		<html>
		<head>
		<title>Your order from '. $companyName . '</title>
		</head>
		<body>
		' . $confirmationText . '
		<p>Your order is currently being processed. We will email you again as soon as your order is posted out to you.</p>
		<p>
			You can track the progress of your order by clicking the following link: 
			<a href="' . $this->config->getSecureUrl() . '/presentation/trackOrder.php?id1=' . $order->id .'&id2=' . $order->password .'">Track Order</a>
		</p>
		</body>
		</html>
		';
		
		$headersÊÊ= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "To: $customer->salutation $customer->first $customer->last <$customer->email>\r\n";
		$headers .= "From: $companyName <$adminEmailAddress>\r\n";
		$headers .= "Bcc: $adminEmailAddress\r\n";
		
		return mail($customer->email, $subject, $message, $headers);	
	}
	
	/*
	 * public static:
	 * sends out a confirmation of that an order has been shipped to the customer, 
	 * and BCCs the local orders email address.
	 */
	function sendShipmentNotice(&$order, &$customer, &$invoiceShipping) {
		
				
		$adminEmailAddress = $this->config->getOrderManagersEmailAddress();
		$companyName = $this->config->getCompanyName();
		
		$daysInTransit = $invoiceShipping->expectedDaysTaken;
		
		$subject = "Your order from $companyName has been shipped";
				
		$message = '
		<html>
		<head>
		<title>Your order from '. $companyName . ' has been shipped</title>
		</head>
		<body>
		' . $this->config->getTextForShippedEmail($daysInTransit) . '
		<p>
			You can track any further progress of your order by clicking the following link: 
			<a href="' . $this->config->getSecureUrl() . '/presentation/trackOrder.php?id1=' . $order->id .'&id2=' . $order->password .'">Track Order</a>
		</p>
		</body>
		</html>
		';
		$headersÊÊ= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "To: $customer->salutation $customer->first $customer->last <$customer->email>\r\n";
		$headers .= "From: $companyName <$adminEmailAddress>\r\n";
		$headers .= "Bcc: $adminEmailAddress\r\n";
		
		return mail($customer->email, $subject, $message, $headers);	
	}
}


?>