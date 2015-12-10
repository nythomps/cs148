<?php

include "top.php";
/* %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
 * the purpose of this page is to display a list of poets sorted in any order
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 */
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// initialize my variables 
$orderBy = "";
$oppositeSort = "ASC";
$c = 0;

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// prepare the sql statement and link text
if (isset($_GET["sortField"]) and isset($_GET["sortDirection"])) {
    $orderBy = " ORDER BY " . htmlentities($_GET["sortField"], ENT_QUOTES) . " " . htmlentities($_GET["sortDirection"], ENT_QUOTES);
    $oppositeSort = ($_GET["sortDirection"] == 'ASC') ? 'DESC' : 'ASC';
    $c = 1;
}

$query = "SELECT pmkPoetId, fldFirstName, fldLastName from tblPoet " . $orderBy;

$poets = $thisDatabaseReader->select($query, "", 0, $c, 0, 0, false, false);

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// print out the results
print "<table>\n";
print "<tr>\n";

// -----------------------------------------------------------------------------
// set links up to do onclick for ajax, but still work if onclick does not by
// haveing the same href. I make it easy on myself by passing in the field names
print "<th><a href='?sortField=fldFirstName&amp;sortDirection=" . $oppositeSort . "'>First Name</a></th>";

print "<th><a href='?sortField=fldLastName&amp;sortDirection=" . $oppositeSort . "'>Last Name</a></th>";

print "</tr>\n";

// -----------------------------------------------------------------------------
// print out the records
foreach ($poets as $poet) {
    print "<tr>\n";
    print "<td>" . $poet['fldFirstName'] . "</td>\n";
    print "<td>" . $poet['fldLastName'] . "</td>\n";
    print "</tr>\n";
}
print "</table>\n";
?>