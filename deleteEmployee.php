<?php

require_once('include/include.php');

$db = dbConnect();

if($_POST['submit']){
   
   $id = $_POST['id'];
   
   $transfer = $_POST['transfer'];
   
   //If they are both numbers, and different, delete
   if(is_numeric($id) && is_numeric($transfer) && !($id == $transfer) ){
      
      //Set all foreign keys to $transfer, and delete $id
      
      
      //Redirect them
      header('Location: viewEmployee.php');
   }
}

head('Delete User');

startPost('Delete User');

$countQuery = dbExec($db, 'select count(id) from Employee');

$row = dbFetchRow($countQuery);

$count = $row[0];

if($count > 1){
   $employeeQuery = dbExec($db, 'select id, firstName, lastName from employee'); 
   
   $employees = dbFetchAll($employeeQuery);
   
   
   ?>
   <form action="deleteEmployee.php" method="post">
      <input type="hidden" name="sumbit" id="submit" value="1">
      <table border="0">
      <tr>
         <td>Delete Employee:</td>
         <td>
            <select id="id" name="id">
               <?php
               echo count($employees);
               for($i = 0; $i <= (count($employees) / 3); $i++){
                  echo '<option value="'.$employees[$i][0].'">'.$employees[$i][0].' - '.$employees[$i][1].' '.$employees[$i][2].'</option>';
               }
               ?>
            </select>
         </td>
      </tr>
      <tr>
         <td>Transfer records to:</td>
         <td>
            <select id="tansfer" name="fransfer">
               <?php
               for($i = 0; $i <= (count($employees) / 3); $i++){
                  echo '<option value="'.$employees[$i][0].'">'.$employees[$i][0].' - '.$employees[$i][1].' '.$employees[$i][2].'</option>';
               }
               ?>
            </select>
         </td>
      </tr>
      <tr>
      <td colsan="2" align="center">
         <input type="submit" value="Submit" />
      </td>
      </tr>
      </table>
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
