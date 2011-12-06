<?php

require_once('include/include.php');

head('Edit Employee');

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
   
   startPost('Edit Employee');
   
   if($error){
      echo '<b>There were errors submitting your request</b>';
   }

?>

<form action="createEmployee.php" method="post">
   <input type="hidden" value="1" id="submit" name="submit" />
   <input type="hidden" value="<?php echo $id; ?>" id="id" name="id" />
   <table border="0">
      <tr>
         <td>First Name:</td>
         <td><input type="text" size="30" id="firstName" name="firstName" value="<?php echo $row[0]; ?>" /></td>
      </tr>
      <tr>
         <td>Last Name:</td>
         <td><input type="text" size="30" id="lastName" name="lastName" value="<?php echo $row[1]; ?>" /></td>
      </tr>
      <tr>
         <td>Sex:</td>
         <td>
            <select name="sex" id="sex">
               <?php
                  if($row[2] == "F"){
                     echo '<option value="F" selected>Female</option>';
                     echo '<option value="M">Male</option>';
                  } else {
                     echo '<option value="M" selected>Male</option>';
                     echo '<option value="F">Female</option>';
                  }
               ?>
            </select>
         </td>
      </tr>
      <tr>
         <td>Birthday (Ex: 12.10.1990):</td>
         <td><input type="text" size="30" id="birthday" name="birthday" value="<?php echo $row[3]; ?>" /></td>
      </tr>
      <tr>
         <td>Street Address (Ex: 123 Main St)</td>
         <td><input type="text" size="30" id="street" name="street" value="<?php echo $row[4]; ?>" /></td>
      </tr>
      <tr>
         <td>City:</td>
         <td><input type="text" size="30" id="city" name="city" value="<?php echo $row[5]; ?>" /></td>
      </tr>
      <tr>
         <td>State (Ex: MD):</td>
         <td><input type="text" size="30" id="state" name="state" value="<?php echo $row[6]; ?>" /></td>
      </tr>
      <tr>
         <td>Zip:</td>
         <td><input type="text" size="30" id="zip" name="zip" value="<?php echo $row[7]; ?>" /></td>
      </tr>
      <tr>
         <td>Salary (No $ sign):</td>
         <td><input type="text" size="30" id="salary" name="salary" value="<?php echo $row[8]; ?>" /></td>
      </tr>
         <td>Branch:</td>
         <td>
            <select name="branch" id="branch">
            <?php
               $branchesQuery = dbExec($db, 'select id, city, state from Branch');
               while( ($branchRow = dbFetchRow($branchesQuery)) ){
                  if($branchRow[0] == $row[9]){
                     echo '<option value="'.$branchRow[0].'" selected>'.$branchRow[0].' - '.$branchRow[1].', '.$branchRow[2].'</option>';
                  } else{
                     echo '<option value="'.$branchRow[0].'">'.$branchRow[0].' - '.$branchRow[1].', '.$branchRow[2].'</option>';
                  }
               }
            ?>
            </select>
         </td>
      </tr>
      <tr>
         <td colspan="2" align="center"><input type="submit" value="Submit" /></td>
      </tr>
   </table>
</form>

<?php

endPost();

foot();

}

?>
