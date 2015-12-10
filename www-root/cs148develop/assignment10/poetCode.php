<?php
/* %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
 * the purpose of this page is to display a list of poets, admin can edit
 * 
 * Written By: Robert Erickson robert.erickson@uvm.edu
 */
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
$admin = true;
include "top.php";

print "<article>";
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// prepare the sql statement
$orderBy = "ORDER BY fldLastName";

$query  = "SELECT pmkPeopleId, fldFirstName, fldLastName ";
$query .= "FROM tblPeople " . $orderBy;

if ($debug)
    print "<p>sql " . $query;

$poets = $thisDatabaseReader->select($query, "", 0, 1, 0, 0, false, false);

if ($debug) {
    print "<pre>";
    print_r($poets);
    print "</pre>";
}

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// print out the results
print "<ol>\n";

foreach ($poets as $poet) {

    print "<li>";
    if ($admin) {
        print '<a href="poetAddCode.php?id=' . $poet["pmkPoetId"] . '">[Edit]</a> ';
    }
    print $poet['fldFirstName'] . " " . $poet['fldLastName'] . "</li>\n";
}
print "</ol>\n";
print "</article>";
include "footer.php";
?>