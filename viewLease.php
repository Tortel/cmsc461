<?php

require_once('include/include.php');

$db = dbConnect();

head('View Lease');

$id = $_GET['id'];

if((!$id && $id != 0) || !is_numeric($id)){
   $leaseQuery = dbExec($db, 'select id, TO_CHAR(startDate, \'MM.DD.YYYY\'), TO_CHAR(endDate, \'MM.DD.YYYY\'), property from lease');
   
   startPost('Select Lease');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($leaseQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].' through '.$row[2].' for Property '.$row[3].'</option>';
         }
      ?>
      </select>
      
      <br>
      <input type="submit" value="Submit">
   </form>
   <?php
   
   endPost();
   
   foot();
   
   exit();
} else {
   
   startPost("Lease $id Details");
   
   $query = dbExec($db, "select rent, deposit, TO_CHAR(startDate, 'MM.DD.YYYY'), TO_CHAR(endDate, 'MM.DD.YYYY'), client, property, associate, MONTHS_BETWEEN(endDate, startDate) from Lease where id = $id");
   
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
         <td>Duration:</td>
         <td><?php echo $row[7] ?> Months</td>
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
}
?>
