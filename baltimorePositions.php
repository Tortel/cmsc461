<?php

require_once('include/include.php');

$db = dbConnect();

head('Employees in Baltimore, MD');

startPost('Employees in Baltimore, MD');

echo '<table border="0">';

$managersQuery = dbExec($db, 'select count(manager) from Branch where Branch.city = \'Baltimore\'');
$row = dbFetchRow($managersQuery);
?>
<tr>
   <td><b>Managers:</b></td>
   <td><?php echo $row[0]; ?></td>
</tr>
<?php

$supervisorQuery = dbExec($db, 'select count(Supervisor.id) from supervisor, employee, branch where supervisor.id = employee.id and employee.branch = branch.id and branch.city = \'Baltimore\'');
$row = dbFetchRow($supervisorQuery);
?>
<tr>
   <td><b>Supervisors:</b></td>
   <td><?php echo $row[0]; ?></td>
</tr>
<?php

$associateQuery = dbExec($db, 'select count(Associate.id) from Associate, employee, branch where Associate.id = employee.id and branch.city = \'Baltimore\'');
$row = dbFetchRow($associateQuery);
?>
<tr>
   <td><b>Associates:</b></td>
   <td><?php echo $row[0]; ?></td>
</tr>
<?php

$otherQuery = dbExec($db, 'select count(Employee.id) from employee, branch where employee.branch = branch.id and branch.city = \'Baltimore\' where id not in ((select id from associate) union (select id from manager) union (select id from supervisor))');
$row = dbFetchRow($otherQuery);
?>
<tr>
   <td><b>Other:</b></td>
   <td><?php echo $row[0]; ?></td>
</tr>
<?php


echo '</table>';

endPost();

foot();

?>
