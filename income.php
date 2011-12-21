<?php

require_once('include/include.php');
check();

$db = dbConnect();

head('Total Monthly Income');

startPost('Total Monthly Income');
?>
<table>
<tr>
   <td>Total Rental Income:</td>
   <td>$
   <?php
      $query = dbExec($db, 'select sum(rent) from lease');
      $row = dbFetchRow($query);
      echo $row[0];
   ?>
   </td>
</tr>
<tr>
   <td>Total Management Fees:</td>
   <td>$
   <?php
      $query = dbExec($db, 'select sum(fee/100 * Lease.rent) from lease, property where lease.property = property.id');
      $row = dbFetchRow($query);
      echo $row[0];
   ?>
   </td>
</tr>
<tr>
   <td>Total Salaries:</td>
   <td>$
   <?php
      $query = dbExec($db, 'select sum(salary), sum(bonus) from employee, manager');
      $row = dbFetchRow($query);
      echo $row[0] + $row[1];
   ?>
   </td>
</tr>
<tr>
   <td>Maximum Possible Rental Income:</td>
   <td>$
   <?php
      $query = dbExec($db, 'select sum(rent) from property');
      $row = dbFetchRow($query);
      echo $row[0];
   ?>
   </td>
</tr>
<tr>
   <td>Maximum Possible Management Fees:</td>
   <td>$
   <?php
      $query = dbExec($db, 'select sum(fee/100 * rent) from property');
      $row = dbFetchRow($query);
      echo $row[0];
   ?>
   </td>
</tr>
</table>
<?php

endPost();

foot();

?>
