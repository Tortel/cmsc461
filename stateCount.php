<?php

require_once('include/include.php');

$db = dbConnect();

head('Counts per State');

startPost('Number of Leases Shorter than 12 Months, by State');

$query = dbExec($db, 'select state, count(Lease.id) from Lease, Employee where Lease.id in (select id from lease where MONTHS_BETWEEN(endDate, startDate) < 12) group by state');

echo '<table border="1">';
while( ($row = dbFetchRow($query)) ){
   echo '<td>'.$row[0].'</td>';
   echo '<td>'.$row[1].'</td>';
}
echo '</table>';

endPost();

foot();

?>
