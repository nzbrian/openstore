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


/*
 * This is the class where you configure each deployment.
 * See /openstore/commercial/ConfigImp.inc.php for example values.
 */
 
ini_set('safe_mode', '1');
// set "display_errors" to "0" before going live
ini_set('display_errors', '1');
ini_set('display_startup_errors', '0');
ini_set('log_errors', '1');

// we will do our own error handling
error_reporting(1);
require_once 'business/ErrorLog.inc.php'; 

// you can either choose to have your own implementation somewhere else to minimise changes when updating from
// the source or you can just return the configuration values directly from this class.
// I'm just trying to avoid checking in any proprietary code to sf.net, so I keep all of that in a different tree. 
require_once 'commercial/ConfigImp.inc.php';

class Config {  
    
    /*
     * Returns the location inside /openstore/webroot where your own includes live.
     * Currently this value is also used to find the correct payment proxy.
     * In the included demonstration store this location is 'commercial'
     */
    function getCommercialPrefix() {
        return ConfigImp::getCommercialPrefix();
    } 

	/*
	 * returns the user name for the payment gateway
	 */
	function getGatewayUserName() {
		 return ConfigImp::getGatewayUserName();
	}
	
	/*
	 * returns the password for the payment gateway
	 */
	function getGatewayPassword() {
		 return ConfigImp::getGatewayPassword();
	}
	
	/*
	 * returns the URL for the payment gateway
	 */
	function getGatewayUrl() {
		 return ConfigImp::getGatewayUrl();
	}
	
	
	/* The machine that the database is on */
	function getDbHost() {
		 return ConfigImp::getDbHost();
	}
	
	/* The database user name */
	function getDbUser() {
		 return ConfigImp::getDbUser();
	}
	
	/* The database password */
	function getDbPassword() {
		 return ConfigImp::getDbPassword();
	}
	
	/* The database to use, eg mydb */
	function getDbUse() {
		 return ConfigImp::getDbUse();
	}
	
	/* The base HTTP URL of the site */
	function getRootUrl() {
		 return ConfigImp::getRootUrl();
	}
	
	/* The secure HTTPS URL of the site. If you don't have one then just put the root URL here */
	function getSecureUrl() {
		 return ConfigImp::getSecureUrl();
	}
	
	/* The reply to email address of any emails sent to customers by the ordering process */
	function getOrderManagersEmailAddress() {
		 return ConfigImp::getOrderManagersEmailAddress();
	}
	
	/* The company name that will be used in emails */
	function getCompanyName() {
		 return ConfigImp::getCompanyName();
	}
	
	/*
	 * Every order can only contain a certain amount of each product in your catalogue.
	 * I put this restriction here as having orders that weigh a million kg can break the postage calculations.
	 * Put the number that you would like as a maximum here. 
	 */
	function getMaxProductQuantityPerOrder() {
		 return ConfigImp::getMaxProductQuantityPerOrder();
	}
	
	/*
	 * This setting tells PHP where to save its session information to. 
	 * You can either choose to leave it in '/tmp' or to put it somewhere that only the PHP user can read.
	 */
	function getSessionSavePath() {
		 return ConfigImp::getSessionSavePath();
	}
	
	/*
	 * This is the name of the cookie that will be sent out to browsers. 
	 * The cookie is needed to tell the server which session to use for each browser.
	 * You can change the cookie name to anything you like here.
	 */
	function getSessionName() {
		 return ConfigImp::getSessionName();
	}
	
	/*
	 * The location of the custom error log.
	 */
	function getErrorLog() { 
		 return ConfigImp::getErrorLog();
	}
	
	/*
	 * The email address to send errors to.
	 */
	function getErrorsEmailAddress() {
		 return ConfigImp::getErrorsEmailAddress();
	}
	
	/*
	 * Any extra text that you would like sent out in the first email that is sent to the customer.
	 */
	function getTextForConfirmationEmail() {
		 return ConfigImp::getTextForConfirmationEmail();
	}
	
	/*
	 * Any extra text that you would like sent out in the second email that is sent to the customer.
	 */
	function getTextForShippedEmail($daysInTransit) {
		 return ConfigImp::getTextForShippedEmail($daysInTransit);
	}
	
	/*
	 * The currency that is used thougout the site. In the default set-up this is "AU$"
	 */
	function getCurrency() {
		 return ConfigImp::getCurrency();
	}
	
}


?>