<?php

require_once('include/include.php');
check();

$db = dbConnect();

head('Branch Managers');

startPost('Branch Managers, ordered by Banch Address');

$query = dbExec($db, 'select lastName, firstName, Branch.id from manager, branch, employee where manager.id = employee.id and branch.manager = manager.id order by Branch.street desc');

echo '<ul>';

while( ($row = dbFetchRow($query)) ){
   echo '<li>'.$row[0].', '.$row[1].' - Branch '.$row[2].'</li>';
}
echo '</ul>';

endPost();

foot();

?>
