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

require_once 'business/Config.inc.php';


// user defined error handling function straight from the PHP manual
function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars) 
{
    
    // timestamp for the error entry
     $dt = date("Y-m-d H:i:s (T)");
     
     $errortype = array (
        E_ERRORÊÊÊÊÊÊÊÊÊÊÊ=> "Error",
        E_WARNINGÊÊÊÊÊÊÊÊÊ=> "Warning",
        E_PARSEÊÊÊÊÊÊÊÊÊÊÊ=> "Parsing Error",
        E_NOTICEÊÊÊÊÊÊÊÊÊÊ=> "Notice",
        E_CORE_ERRORÊÊÊÊÊÊ=> "Core Error",
        E_CORE_WARNINGÊÊÊÊ=> "Core Warning",
        E_COMPILE_ERRORÊÊÊ=> "Compile Error",
        E_COMPILE_WARNING => "Compile Warning",
        E_USER_ERRORÊÊÊÊÊÊ=> "User Error",
        E_USER_WARNINGÊÊÊÊ=> "User Warning",
        E_USER_NOTICEÊÊÊÊÊ=> "User Notice",
        E_STRICTÊÊÊÊÊÊÊÊÊÊ=> "Runtime Notice");

    
    // don't log the following errors
//    if (!in_array($errno, array(E_NOTICE, E_USER_NOTICE))) {         
        $err = "<errorentry>\n";
        $err .= "\t<datetime>" . $dt . "</datetime>\n";
        $err .= "\t<errornum>" . $errno . "</errornum>\n";
        $err .= "\t<errortype>" . $errortype[$errno] . "</errortype>\n";
        $err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
        $err .= "\t<scriptname>" . $filename . "</scriptname>\n";
        $err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";
        
        $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
        if (in_array($errno, $user_errors)) {
            $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
        }
        $err .= "</errorentry>\n\n";
        error_log($err, 3, Config::getErrorLog());
        if (!in_array($errno, array(E_NOTICE, E_USER_NOTICE))) {
            $to = Config::getErrorsEmailAddress();
            $from = Config::getOrderManagersEmailAddress();
    		$headers = "To: $to \r\n";
    		$headers .= "From: $from \r\n";
            mail($to, "Error with deployment at " . Config::getRootUrl(), $err);
        }
//    }
}

set_error_handler("userErrorHandler");

?>