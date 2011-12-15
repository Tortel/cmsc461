<?php

require_once('include/include.php');

$db = dbConnect();

head('Expiring Leases');

$id = $_GET['id'];


if((!$id && $id != 0) || !is_numeric($id)){
   //Branch not selected, show option to select one
   
   $branchesQuery = dbExec($db, 'select id, city, state from Branch');
   
   startPost('Select Branch');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($branchesQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].'</option>';
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
}

startPost('Leases Expiring within One Month');

$query = dbExec($db, "select rent, deposit, TO_CHAR(startDate, 'MM.DD.YYYY'), TO_CHAR(endDate, 'MM.DD.YYYY'), client, property, associate, Lease.id from Lease, Employee where Lease.id in (select id from lease where MONTHS_BETWEEN(endDate, CURRENT_DATE) < 1 and MONTHS_BETWEEN(endDate, CURRENT_DATE) >= 0) and Employee.id = associate and Employee.branch = $id");


while( ($row = dbFetchRow($query)) ){
   echo '<b>Lease '.$row[7].'</b>';
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
   <br />
   <?php
}

endPost();

foot();

?>
