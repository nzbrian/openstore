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
 */

class ConfigImp { 
    
    function getCommercialPrefix() {
        return 'commercial';
    }

	/*
	 * returns the user name for the payment gateway
	 */
	function getGatewayUserName() {
		 return '';
	}
	
	/*
	 * returns the password for the payment gateway
	 */
	function getGatewayPassword() {
		return '';
	}
	
	/*
	 * returns the URL for the payment gateway
	 */
	function getGatewayUrl() {
		return '';	
	}
	
	
	/* The machine that the database is on */
	function getDbHost() {
		return 'localhost';
	}
	
	/* The database user name */
	function getDbUser() {
		return 'commerial';
	}
	
	/* The database password */
	function getDbPassword() {
		return '';
	}
	
	/* The database to use, eg mydb */
	function getDbUse() {
		return 'commercial';
	}
	
	/* The base HTTP URL of the site */
	function getRootUrl() {
		return '..';	
	}
	
	/* The secure HTTPS URL of the site. If you don't have one then just put the root URL here */
	function getSecureUrl() {
		return '..';	
	}
	
	/* The reply to email address of any emails sent to customers by the ordering process */
	function getOrderManagersEmailAddress() {
		return '';	
	}
	
	/* The company name that will be used in emails */
	function getCompanyName() {
		return 'OpenStore';	
	}
	
	function getMaxProductQuantityPerOrder() {
		return 200;	
	}
	
	function getSessionSavePath() {
	    return '/tmp';    
	}
	
	function getSessionName() {
	    return 'PHP_SESSION';    
	}
	
	function getErrorLog() { 
	    return '/tmp/phpErrors.log';
	}
	
	function getErrorsEmailAddress() {
		return '';	
	}
	
	function getTextForConfirmationEmail() {
	   return '';   
	}
	
	function getTextForShippedEmail($daysInTransit) {
	   return '';   
	}
	
	function getCurrency() {
		 return 'AU$';
	}
	
}


?>