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
//copyright Brian Bannister 2004

class DisplayUtil {

	/*
	 * public static:
	 * returns a display string in dollars. 
	 * For example displayDollars(-120) will return '-1.20' 
	 */
	function displayDollars($cents=0) {
		return number_format($cents / 100, 2);	
	}
	
	/*
	 * public static:
	 * returns a display string in kg. 
	 * For example displayKg(-120) will return '-1.20' 
	 */
	function displayKg($grams=0) {
		return number_format($grams / 1000, 3);	
	}
	
	function displayBoolean($bool=false) {
		return $bool ? 'yes' : 'no';	
	}
	
	function displayDate($date) {
		return date('D j M Y G:i:s', $date);	
	}
}

?>