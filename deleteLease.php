<?php

require_once('include/include.php');

$db = dbConnect();

$id = $_GET['id'];

if((!$id && $id != 0) || !is_numeric($id)){
   
   head('Delete Lease');
   
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
   
   dbExec($db, "delete from lease where id = $id");
   
   header("Location: viewLease.php");
}
