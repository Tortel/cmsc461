<?

require_once('include/include.php');

$db = dbConnect();

head('Property Totals');

startPost('Total Number of Properties, by Type');

$query = dbExec($db, 'Select type, count(id) from Property group by type');

?>
<table border="0">
   <tr>
      <td><b>Type</b></td>
      <td>Count</td>
   </tr>

<?php
while( ($row = dbFetchRow($query)) ){
   echo '<tr>';
   echo '<td>'.propertyType($row[0]).'</td>';
   echo '<td>'.$row[1].'</td>';
   echo '</tr>';
}

echo '</table>';

endPost();

foot();

?>
