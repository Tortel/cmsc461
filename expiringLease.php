<?php

require_once('include/include.php');

$db = dbConnect();

$query = dbExec($db, "select rent, deposit, TO_CHAR(startDate, 'MM.DD.YYYY'), TO_CHAR(endDate, 'MM.DD.YYYY'), client, property, associate from Lease where id = in (");



$row = dbFetchRow($query);
?>
<table>
   <tr>
      <td>Monthly Rent:</td>
      <td>$<?php echo $row[0]; ?></td>
   </tr>
   <tr>
      <td>Deposit Paid:</td>
      <td>$<?php echo $row[1] ?></td>
   </tr>
   <tr>
      <td>Start Date:</td>
      <td><?php echo $row[2] ?></td>
   </tr>
   <tr>
      <td>End Date:</td>
      <td><?php echo $row[3] ?></td>
   </tr>
   <tr>
      <td>Client:</td>
      <td><a href="viewClient.php?id=<?php echo $row[4] ?>">Client <?php echo $row[4] ?></a></td>
   </tr>
   <tr>
      <td>Property:</td>
      <td><a href="viewProperty.php?id=<?php echo $row[5] ?>">Property <?php echo $row[5] ?></a></td>
   </tr>
   <tr>
      <td>Associate:</td>
      <td><a href="viewEmployee.php?id=<?php echo $row[6] ?>">Employee <?php echo $row[6] ?></a></td>
   </tr>
</table>
<?php
endPost();

foot();

?>
