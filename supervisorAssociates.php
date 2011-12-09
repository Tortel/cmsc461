<?php

require_once('include/include.php');

head('View Supervisor Details');

$id = $_GET['id'];

$db = dbConnect();

if( (!$id && $id != 0) || !is_numeric($id)){
   //Employee not selected, show option to select one
   
   $employeeQuery = dbExec($db, 'select id, firstname, lastname from Supervisor');
   
   startPost('Select Supervisor');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
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
   startPost("Associates under Supervisor $id");
   
   $query = dbExec($db, "select lastName, firstName from Employee, associate where Employee.id = associate.id and supervisor = $id");
   
   echo '<ul>';
   while( ($row = dbFetchRow($query)) ){
      echo '<li>'.$row[0].', '.$row[1].'</li>';
   }
   echo '</ul>';
   
   
   endPost();
   
   foot();
}
?>
