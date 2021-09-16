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
    
require_once 'business/AdminProxy.inc.php';
require_once 'business/EmailProxy.inc.php';
require_once 'business/OrderProxy.inc.php';
require_once 'business/ShippingProxy.inc.php';
require_once 'business/StockProxy.inc.php';

require_once 'util/DisplayUtil.inc.php';

// I will move this out of commercial and in to the OpenStore build as soon as I have a payment provider's permission
require_once Config::getCommercialPrefix() . '/PaymentProxyDPS.inc.php';


/*
 * This class creates all of the proxy objects for you.
 * We're using the constructor injection pattern here for easy testing.
 */
class ProxyMother {   
    
    function &getStockProxy(&$config) {
        return new StockProxy($config);   
    }
    
    function &getShippingProxy(&$config) {
        return new ShippingProxy($config);   
    }
      
    function &getPaymentProxy(&$config) {
        return new PaymentProxyDPS($config);   
    }
      
    function &getEmailProxy(&$config) {
        return new EmailProxy($config);   
    }
      
    function &getOrderProxy(&$config) {
        $displayUtil = &new DisplayUtil();
        return new OrderProxy(
                $config, 
                ProxyMother::getShippingProxy($config), 
                ProxyMother::getPaymentProxy($config),
                ProxyMother::getEmailProxy($config),                
                $displayUtil
        );  
    }
    
    function &getAdminProxy(&$config) {
        return new AdminProxy(
                $config, 
                ProxyMother::getEmailProxy($config), 
                ProxyMother::getOrderProxy($config)
        );   
    } 
    
        
}
?>