<?php

require_once('include/include.php');
check();

$db = dbConnect();

//If they submitted the form
if($_POST['submit']){
   
   //Prep the vars
   $street = dbEscape($_POST['street']);
   $city = dbEscape($_POST['city']);
   $firstName = dbEscape($_POST['firstName']);
   $lastName = dbEscape($_POST['lastName']);
   $sex = $_POST['sex'];
   $birthday = dbDate($_POST['birthday']);
   $state = strtoupper($_POST['state']);
   $zip = $_POST['zip'];
   $salary = $_POST['salary'];
   $branch = $_POST['branch'];
   $id = $_POST['id'];
   
   if(!$street || !$city || !$state || !$zip || !$salary || !$birthday || !$firstName || !$lastName){
      $error = true;
   }
   
   if(!is_numeric($salary) || !is_numeric($zip) || !(strlen($zip) == 5) || !(strlen($state) == 2) ){
      $error = true;
   }
   
   if(!$error){
      //Run the query
      $query = dbExec($db, "update Employee set street = '$street', city = '$city', state = '$state', zip = '$zip', firstname = '$firstName',".
      " lastName = '$lastName', birthday = $birthday, sex = '$sex', salary = $salary, branch = $branch where id = $id");
      
      
      if($_POST['position'] == "associate"){
         $query = dbExec($db, "select count(id) from associate where id = $id");
         $row = dbFetchRow($query);
         if(!$row[0]){
            dbExec($db, "delete from supervisor where id = $id");
            if($_POST['supervisor'] != -1){
               dbExec($db, "insert into associate (id, supervisor) values ($id, ".$_POST['supervisor'].")");
            } else {
               dbExec($db, "insert into associate (id, supervisor) values ($id, null)");
            }
         } else {
            dbExec($db, "update associate set supervisor = ".$_POST['supervisor']." where id = $id");
         }
      } else {
         $query = dbExec($db, "select count(id) from supervisor where id = $id");
         $row = dbFetchRow($query);
         if(!$row[0]){
            dbExec($db, "delete from associate where id = $id");
            dbExec($db, "insert into supervisor (id) values ($id)");
         }
      }
      
      header("Location: viewEmployee.php?id=$id");
   }
   
}



head('Edit Employee');

$id = $_GET['id'];

if( (!$id && $id != 0) || !is_numeric($id)){
   //Employee not selected, show option to select one
   
   $employeeQuery = dbExec($db, 'select id, firstname, lastname from Employee');
   
   startPost('Select Employee');
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
   //Get the employee details
   $employeeQuery = dbExec($db, "select firstname, lastname, sex, TO_CHAR(birthday, 'MM.DD.YYYY'), street, city, state, zip, salary, branch from Employee where id = $id");
   
   $row = dbFetchRow($employeeQuery);
   
   startPost('Edit Employee');
   
   if($error){
      echo '<b>There were errors submitting your request</b>';
   }

?>

<form action="editEmployee.php" method="post">
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
         <td>Position:</td>
         <td>
         <?php
            $query = dbExec($db, "select count(id) from manager where id = $id");
            $row = dbFetchRow($query);
            
            if(!$row[0]){
         ?>
            <select name="position" id="position">
               <option value="associate">Associate</option>
               <option value="supervisor">Supervisor</option>
            </select>
         <?php
         } else {
            echo 'Manager';
         }
         ?>
         </td>
      </tr>
      <tr>
         <td>Supervisor: (Ignored if position is supervisor)</td>
         <td>
            <select name="supervisor" id="supervisor">
               <option value="-1">NONE</option>
               <?php
               //Umm, dont read this SQL. Seriously. Go away. Ignore it.
               $query = dbExec($db, 'select Supervisor.id, lastName, firstName from supervisor, employee where Supervisor.id = employee.id and supervisor.id not in (select supervisor from associate) union select sId as id, lastName, firstName from (select supervisor as sId, count(supervisor) as count from associate group by supervisor), employee where count < 12 and employee.id = sId');
               while( ($row = dbFetchRow($query)) ){
                  echo "<option value=\"$row[0]\">$row[0] - $row[1], $row[2]</option>";
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
