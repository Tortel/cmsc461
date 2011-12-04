<?php

require_once('include/include.php');

head('Branch Details');

$branch = $_GET['id'];

$db = dbConnect();

if(!$branch || !is_numeric($branch)){
   //Branch not selected, show option to select one
   
   $branchesQuery = dbExec($db, 'select id, city, state from Branch');
   
   startPost('Select Branch');
   ?>
   <form action="viewBranch.php" method="get">
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
} else {
   //Get the branch details
   $branchQuery = dbExec($db, "select street, city, state, zip, phone, fax, firstName, lastName, begin, bonus, Manager.id".
      " from Branch, Manager, Employee where Branch.id = $branch and Manager.id = manager and Employee.id = manager");
   
   $row = dbFetchRow($branchQuery);
   
   startPost('Branch '.$branch.' Details');
   ?>
   
   <table border="0">
      <tr>
         <td align="top">Address:</td>
         <td>
            <?php
               echo $row[0].'<br>';
               echo $row[1].', '.$row[2].'<br>';
               echo $row[3];
            ?>
         </td>
      </tr>
      <tr>
         <td>Phone Number:</td>
         <td><?php echo $row[4]; ?></td>
      </tr>
      <tr>
         <td>Fax Number:</td>
         <td><?php echo $row[5]; ?></td>
      </tr>
      <tr>
         <td>Manager Name:</td>
         <td><a href="#"><?php echo $row[6].' '.$row[7]; ?></a></td>
      </tr>
      <tr>
         <td>Start Date:</td>
         <td><?php echo $row[8]; ?></td>
      </tr>
      <tr>
         <td>Manager's Bonus:</td>
         <td>$<?php echo $row[9]; ?></td>
      </tr>
   </table>
   <?php

   endPost();

   foot();

}
?>

