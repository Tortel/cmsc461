<?php

require_once('include/include.php');

head('Employee Details');

$id = $_GET['id'];

$db = dbConnect();

if( (!$id && $id != 0) || !is_numeric($id)){
   //Employee not selected, show option to select one
   
   $employeeQuery = dbExec($db, 'select id, firstname, lastname from Employee');
   
   startPost('Select Employee');
   ?>
   <form action="viewEmployee.php" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($employeeQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].' '.$row[2].'</option>';
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
   //Get the employee details
   $employeeQuery = dbExec($db, "select firstname, lastname, sex, birthday, street, city, state, zip, salary, branch from Employee where id = $id");
   
   $row = dbFetchRow($employeeQuery);
   
   startPost('Employee Details');
   ?>
   
   <table border="0">
      <tr>
         <td colspan="2" align="center"><?php echo $row[0].' '.$row[1]; ?></td>
      </tr>
      <tr>
         <td>Sex:</td>
         <td><?php echo $row[2]; ?></td>
      </tr>
      <tr>
         <td>Birthday:</td>
         <td><?php echo $row[3]; ?></td>
      </tr>
      <tr>
         <td align="top">Address:</td>
         <td>
            <?php
               echo $row[4].'<br>';
               echo $row[5].', '.$row[6].'<br>';
               echo $row[7];
            ?>
         </td>
      </tr>
      <tr>
         <td>Salary:</td>
         <td><?php echo $row[8]; ?></td>
      </tr>
      <tr>
         <td>Branch:</td>
         <td><a href="viewBranch.php?id=<?php echo $row[9];?>">Branch <?php echo $row[9]; ?></a></td>
      </tr>
      <tr>
         <td>Status:</td>
         <?php
         $statusQuery = dbExec($db, "select count(id) from manager where id = $id");
         $manager = dbFetchRow($statusQuery);
         $statusQuery = dbExec($db, "select count(id) from supervisor where id = $id");
         $supervisor = dbFetchRow($statusQuery);
         if($manager[0]){
            echo '<td>Branch Manager</td>';
         } else if($supervisor[0]){
            echo '<td>Supervisor</td>';
         } else {
            echo '<td>Associate</td>';
         }
         ?>
      </tr>
   </table>
   <?php

   endPost();

   foot();

}
?>
