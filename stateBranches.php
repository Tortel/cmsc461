<?php

require_once('include/include.php');
check();

head('State Branch Count');

$city = $_GET['city'];

$db = dbConnect();

$query = dbExec($db, 'select state, count(id) from branch group by state order by state desc');

$array = dbFetchAll($query);

startPost('Number of Branches per State');
?>

<table border="1">
   <tr>
      <td><b>State</b></td>
      <td><b>Count</b></td>
   </tr>
<?php
for($i = 0; $i < count($array); $i++){
   echo '<tr>';
   echo '<td>'.$array[$i][0].'</td>';
   echo '<td>'.$array[$i][1].'</td>';
   echo '</tr>';
}
echo '</table>';

endPost();

foot();

?>

