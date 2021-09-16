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
//copyright Brian Bannister 2004


class DisplayDate {
    var $minute;
    var $hour;
    var $day;
    var $month;
    var $year;
    
    function time() {
        return mktime($this->hour, $this->minute, 0, $this->month, $this->day, $this->year);
           
    }
}

class HTTPUtil {
    
	function readPost(&$object) {
		foreach ($object->fields as $field) {
			$object->$field = htmlspecialchars($_POST[$field]);
		}
	}
	
	function readMarkupPost(&$object) {
		foreach ($object->fields as $field) {
			$object->$field = $_POST[$field];
		}
	}
	
	function readDatePost($field, &$object) {
	    $date = new DisplayDate();
	    $date->day = $_POST[$field . '_day'];   
	    $date->month = $_POST[$field . '_month'];   
	    $date->year = $_POST[$field . '_year'];   
	    $date->minute = $_POST[$field . '_minute'];   
	    $date->hour = $_POST[$field . '_hour']; 
//	    print_r($_POST);
//	    print_r($date);
	    $object->$field = $date->time(); 
	}
	
	
	function getInput($field, &$object, $size=30, $tabIndex=NULL) {
		$value = $object->$field;
		$result = '<input type="text" name="' . $field . '" value="' . $value . '" size="' . $size . '" ';
		if ($tabIndex) {
			$result .= 'tabIndex="' . $tabIndex . '" ';	
		}
		return $result . '/>';
		
	}
	
	function getInputArea($field, &$object, $cols=30, $rows=5, $tabIndex=NULL) {
		$value = $object->$field;
		$result = '<textarea name="' . $field . '" cols="' . $cols . '" rows="' . $rows . '" ';
		if ($tabIndex) {
			$result .= 'tabIndex="' . $tabIndex . '" ';	
		}
		$result .= '>' . $value . '</textarea>';
		return $result;
	}
	
	/*
	 * public:
	 * returns a select statement showing all of the objects in the $choices array
	 * param $field the name of the select statement
	 * param $object the object to use to find the value that should be pre-selected in the option list
	 * param $choices the options to display. for each $choices as $value=>$display the option will have value == $value and will show $display to the user
	 * param $tabIndex an optional field that will supply a tab index to the select statement
	 */
	function getInputChoice($field, &$object, $choices, $tabIndex=NULL, $prependName='') {
		$value = $object->$field;
		$result = '<select name="' . $prependName . $field .'" ';
		if ($tabIndex) {
			$result .= 'tabIndex="' . $tabIndex . '" ';	
		}
		$result .= '>';
		foreach($choices as $option=>$display) {
			$result .= '<option ';
			if ($option == $value) {
				$result .= 'selected ';	
			}	
			$result .= 'value="' . $option . '">' . $display . '</option>';
		}
		$result .= '</select>';
		return $result;
	}
	
	/*
	 * public:
	 * returns an HTML select showing all of the objects in the $choices array
	 * param $field the name of the select statement
	 * param $object the object to use to find the value that should be pre-selected in the option list
	 * param $arrayOfObjects the options to display. for each $arrayOfObjects as $option=>$anObject the option will have value == $option and will show $anObject->$displayField to the user
	 * param $tabIndex an optional field that will supply a tab index to the select statement
	 */
	function getObjectChoice($field, &$object, $arrayOfObjects, $displayField, $tabIndex=NULL) {
		$value = $object->$field;
		$result = '<select name="' . $field .'" ';
		if ($tabIndex) {
			$result .= 'tabIndex="' . $tabIndex . '" ';	
		}
		$result .= '>';
		foreach($arrayOfObjects as $option=>$anObject) {
			$display = $anObject->$displayField;
			$result .= '<option ';
			if ($option == $value) {
				$result .= 'selected ';	
			}	
			$result .= 'value="' . $option . '">' . $display . '</option>';
		}
		$result .= '</select>';
		return $result;
	}
	
	function getDateInput($field, &$object) {
        $value = $object->$field;
        
        $date = &new DisplayDate();
        $date->minute = date('i', $value);   
        $date->hour = date('G', $value);
        $date->day = date('j', $value);
        $date->month = date('n', $value);
        $date->year = date('Y', $value);
	   
//        $result = '<input type="text" name="' . $field . '_bhour" value="' . $date->hour . '" size="2" />';
//        $result .= ':<input type="text" name="' . $field . '_bminute" value="' .$date->minute . '" size="2" />';
//        $result .= ', <input type="text" name="' . $field . '_bday" value="' . $date->day . '" size="2" />';
//        $result .= '/<input type="text" name="' . $field . '_bmonth" value="' . $date->month . '" size="2" />';
//        $result .= '/<input type="text" name="' . $field . '_byear" value="' . $date->year . '" size="4" />';

//        echo "minutes are: array(";
//        
//        $minutes = array();
//        for ($i = 0; $i < 60; $i += 5) {
//            $minutes[$i] = $i;   
//            echo "$i=>'";
//            if ($i < 10) {
//                echo "0";   
//            }
//            echo "$i', ";
//        }
//        
//        echo ") \nhours are: array(";
//        
//        $hours = array();
//        for ($i = 0; $i < 24; $i++) {
//            $hours[$i] = $i;    
//            echo "$i=>$i, ";
//        }
//        
//        echo ") \ndays are: array(";
//        $days = array();
//        for ($i = 1; $i < 32; $i++) {
//            $days[$i] = $i;    
//            echo "$i=>$i, ";
//        }
//        
//        echo ") \nmonths are: array(";
//        $months = array();
//        for ($i = 1; $i < 13; $i++) {
//            $months[$i] = $i;    
//            echo "$i=>$i, ";
//        }
//        
//        echo ") \nyears are: array(";
//        $years = array();
//        for ($i = 1970; $i < 2039; $i++) {
//            $years[$i] = $i;   
//            echo "$i=>$i, "; 
//        }
        
        $minutes = array(0=>'00', 5=>'05', 10=>'10', 15=>'15', 20=>'20', 25=>'25', 30=>'30', 35=>'35', 40=>'40', 45=>'45', 50=>'50', 55=>'55');
        $hours = array(0=>0, 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15, 16=>16, 17=>17, 18=>18, 19=>19, 20=>20, 21=>21, 22=>22, 23=>23);
        $days = array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12, 13=>13, 14=>14, 15=>15, 16=>16, 17=>17, 18=>18, 19=>19, 20=>20, 21=>21, 22=>22, 23=>23, 24=>24, 25=>25, 26=>26, 27=>27, 28=>28, 29=>29, 30=>30, 31=>31);
        $months = array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 11=>11, 12=>12);
        $years = array(1970=>1970, 1971=>1971, 1972=>1972, 1973=>1973, 1974=>1974, 1975=>1975, 1976=>1976, 1977=>1977, 1978=>1978, 1979=>1979, 1980=>1980, 1981=>1981, 1982=>1982, 1983=>1983, 1984=>1984, 1985=>1985, 1986=>1986, 1987=>1987, 1988=>1988, 1989=>1989, 1990=>1990, 1991=>1991, 1992=>1992, 1993=>1993, 1994=>1994, 1995=>1995, 1996=>1996, 1997=>1997, 1998=>1998, 1999=>1999, 2000=>2000, 2001=>2001, 2002=>2002, 2003=>2003, 2004=>2004, 2005=>2005, 2006=>2006, 2007=>2007, 2008=>2008, 2009=>2009, 2010=>2010, 2011=>2011, 2012=>2012, 2013=>2013, 2014=>2014, 2015=>2015, 2016=>2016, 2017=>2017, 2018=>2018, 2019=>2019, 2020=>2020, 2021=>2021, 2022=>2022, 2023=>2023, 2024=>2024, 2025=>2025, 2026=>2026, 2027=>2027, 2028=>2028, 2029=>2029, 2030=>2030, 2031=>2031, 2032=>2032, 2033=>2033, 2034=>2034, 2035=>2035, 2036=>2036, 2037=>2037, 2038=>2038);
        
        

        $result .= $this->getInputChoice('hour', $date, $hours, NULL, $field.'_');
        $result .= ':';
        $result .= $this->getInputChoice('minute', $date, $minutes, NULL, $field.'_');
        $result .= ', ';
        $result .= $this->getInputChoice('day', $date, $days, NULL, $field.'_');
        $result .= '/';
        $result .= $this->getInputChoice('month', $date, $months, NULL, $field.'_');
        $result .= '/';
        $result .= $this->getInputChoice('year', $date, $years, NULL, $field.'_');  

	   return $result;
	}
	
	
}


?>