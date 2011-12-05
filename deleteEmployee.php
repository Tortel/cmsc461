<?php

require_once('include/include.php');

$db = dbConnect();

if($_POST['submit']){
   
   $id = $_POST['id'];
   
   if(is_numeric($id)){
      
      
      
      
      //Redirect them
      header('Location: viewEmployee.php');
   }
}

startPost('Delete User');

$countQuery = dbExec($db, 'select count(id) from Employee');

$row = dbFetchRow($countQuery);

$count = $row[0];

if($count > 1){
   $employeeQuery = dbExec($db, 'select id, firstName, lastName from employee'); 
   
   ?>
   
   <p>Select employee to delete:</p>
   <form action="deleteEmployee.php" method="post">
      <input type="hidden" name="sumbit" id="submit" value="1">
      <select id="id" name="id">
         <?php
         while( ($row = dbFetchRow($employeeQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].' '.$row[2].'</option>';
         }
         ?>
      </select>
      <input type="submit" value="Submit" />
   </form>
   <?php
} else {
?>
<p>You must have at least one user.</p>
<?php

}

endPost();

foot();

?>
