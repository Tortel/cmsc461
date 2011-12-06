<?php

require_once('include/include.php');

head('City Branch Details');

$city = $_GET['city'];

$db = dbConnect();

if(!$city){
   //Branch not selected, show option to select one
   
   $cityQuery = dbExec($db, 'select unique(city) from Branch');
   
   startPost('Select City');
   ?>
   <form action="cityBranches.php" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($cityQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].'</option>';
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
   $branchQuery = dbExec($db, "select Branch.street, Branch.city, Branch.state, Branch.zip, phone, fax, firstName, lastName, begin, bonus, Manager.id, Branch.id".
      " from Branch, Manager, Employee where Branch.city = '$city' and Manager.id = manager and Employee.id = manager");
   
   $array = dbFetchAll($branchQuery);
   
   startPost('Branches in '.$city);
   
   for($i = 0; $i < count($array); $i++){
      ?>
      <p>Branch <?php echo $array[$i][11]; ?>
      <table border="0">
         <tr>
            <td align="top">Address:</td>
            <td>
               <?php
                  echo $array[$i][0].'<br>';
                  echo $array[$i][1].', '.$array[$i][2].'<br>';
                  echo $array[$i][3];
               ?>
            </td>
         </tr>
         <tr>
            <td>Phone Number:</td>
            <td><?php echo $array[$i][4]; ?></td>
         </tr>
         <tr>
            <td>Fax Number:</td>
            <td><?php echo $array[$i][5]; ?></td>
         </tr>
         <tr>
            <td>Manager Name:</td>
            <td><a href="viewEmployee.php?id=<?php echo $array[$i][10]; ?>"><?php echo $array[$i][6].' '.$array[$i][7]; ?></a></td>
         </tr>
         <tr>
            <td>Manager Start Date:</td>
            <td><?php echo $array[$i][8]; ?></td>
         </tr>
         <tr>
            <td>Manager's Bonus:</td>
            <td>$<?php echo $array[$i][9]; ?></td>
         </tr>
      </table>
      <?php
   }
   
   endPost();

   foot();

}
?>

