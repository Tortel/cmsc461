<?php

require_once('include/include.php');
check();

$db = dbConnect();

if($_POST['submit']){
   
   $id = $_POST['id'];
   
   if( is_numeric($id) ){
      
      //Should auto-fail if there is any foreign keys dependent on that employee
      dbExec($db, "delete from Employee where id = $id");
      
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
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="submit" id="submit" value="1">
      <table border="0">
      <tr>
         <td>Delete Employee:</td>
         <td>
            <select id="id" name="id">
               <?php
               for($i = 0; $i < count($employees); $i++){
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
