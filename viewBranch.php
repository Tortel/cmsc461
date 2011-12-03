<?php

require_once('include/include.php');

head('Branch Details');

$branch = $_GET['id'];

$db = dbConnect();

if(!$branch || !is_nueric($branch)){
   //Branch not selected, show option to select one
   
   $branchesQuery = dbExec($db, 'select id, city, state from Branch');
   
   startPost('Select Branch');
   ?>
   <form action="viewBranch.php" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($branchesQuery)) ){
            echo '<option value="'.$row['id'].'">'.$row['id'].' - '.$row['city'].', '.$row['state'].'</option>';
         }
      ?>
      </select>
      
      <br>
      <input type="submit" value="submit">
   </form>
   <?php
   
   endPost();
   
   foot();
   
   exit();
} else {
   //Get the branch details
   $branchQuery = dbExec($db, "select street, city, state, zip, phone, fax, begin, bonus, firstName, lastName".
      " from Branch, Manager, Employee where Branch.id = $branch and Manager.id = manager amd Employee.id = manager");
   
   $row = dbFetchRow($branchQuery);
   
   startPost('Branch Details');
   ?>
   
   Details here
   
   
   
   <?php

   endPost();

   foot();

}
?>

