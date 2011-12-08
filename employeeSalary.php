<?php

require_once('include/include.php');

$db = dbConnect();

head('Total Employees and Total Salary');


startPost('Total Employees and Total Salary');

$query = dbExec($db, 'select count(id), sum(salary) from Employee');

$row = dbFetchRow($query);
?>
<table border="0">
   <tr>
      <td><b>Total Number of Employees:</b></td>
      <td><?php echo $row[0]; ?></td>
   </tr>
   <tr>
      <td><b>Sum of all Salaries</b></td>
      <td>$<?php echo $row[1]; ?></td>
   </tr>
</table>
<?php

endPost();

foot();

?>
