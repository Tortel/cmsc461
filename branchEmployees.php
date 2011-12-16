<?php

require_once('include/include.php');
check();

head('View Branch Employees');

$branch = $_GET['id'];

$db = dbConnect();

if((!$branch && $branch != 0) || !is_numeric($branch)){
   //Branch not selected, show option to select one
   
   $branchesQuery = dbExec($db, 'select id, city, state from Branch');
   
   startPost('Select Branch');
   ?>
   <form action="branchEmployees.php" method="get">
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
   
   startPost("Branch $branch Employees");
   
   //Name, position, salary ordered by name
   
   $employees = dbExec($db, "select id, lastName, firstName, salary from employee where branch = $branch order by lastName asc");
   
   ?>
   <table>
   <tr>
      <td><b>Name</b></td>
      <td><b>Position</b></td>
      <td><b>Salary</b></td>
   </tr>
   <?php
   
   while( ($row = dbFetchRow($employees)) ){
      echo '<tr>';
      echo "<td>$row[1], $row[2]</td>";
      $statusQuery = dbExec($db, "select count(id) from manager where id = $row[0]");
      $manager = dbFetchRow($statusQuery);
      $statusQuery = dbExec($db, "select count(id) from supervisor where id = $row[0]");
      $supervisor = dbFetchRow($statusQuery);
      if($manager[0]){
         echo '<td>Branch Manager</td>';
      } else if($supervisor[0]){
         echo '<td>Supervisor</td>';
      } else {
         echo '<td>Associate</td>';
      }
      echo "<td>\$$row[3]</td>";
      echo '</tr>';
   }
   
   echo '</table>';
   
   endPost();
   
   foot();
}
?>
