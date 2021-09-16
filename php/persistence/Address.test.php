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

/*
 * Test script for the address object
 */

require_once 'persistence/Address.inc.php';


$a = new Address;
$a->street1 = "street 1";
$a->street2 = "street 2";
$a->city = "city";
$a->country = "Belgium";

$valid = $a->validate();
echo "is valid? $valid <br>";

echo "<br>creating<br>";

$result = $a->create();

echo "<br> updating <br>";
$a->street1 = "another street 1";
$update = $a->update();
echo "<br> updated: $update <br>";

echo "<br>created: $result<br>";
echo "<br> reading: <br>";
$b = new Address;
$b->id = $a->id;

$read = $b->read();
echo "<br> read: $read <br>";
print_r(get_object_vars($b));

echo "<br>removing<br>";

$removed = $a->remove();

echo "<br>removed: $removed<br>";

echo "<br> reading again <br>";

$c = new Address;
$c->id = $a->id;
$read = $c->read();

echo "<br> read: $read <br>";
print_r(get_object_vars($c));

?>