<?php

require_once('include/include.php');

$db = dbConnect();

//If they submitted the form
if($_POST['submit']){
   
   //Prep the vars
   $street = dbEscape($_POST['street']);
   $city = dbEscape($_POST['city']);
   $firstName = dbEscape($_POST['firstName']);
   $lastName = dbEscape($_POST['lastName']);
   $sex = $_POST['sex'];
   $birthday = dbEscape($_POST['birthday']);
   $state = strtoupper($_POST['state']);
   $zip = $_POST['zip'];
   $salary = $_POST['salary'];
   $branch = $_POST['branch'];
   
   if(!$street || !$city || !$state || !$zip || !$salary || !$birthday || !$firstName || !$lastName){
      $error = true;
   }
   
   if(!is_numeric($salary) || !is_numeric($zip) || !(strlen($zip) == 5) || !(strlen($state) == 2) ){
      $error = true;
   }
   
   if(!$error){
      //Run the query
      $query = dbExec($db, "update Employee set street = '$street', city = '$city', state = '$state', zip = '$zip', firstname = '$firstName',".
      " lastName = '$lastName', birthday = '$birthday', sex = '$sex', salary = $salary, branch = $branch where id = $id"); 
      
      header('Location: viewEmployee.php');
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
   $employeeQuery = dbExec($db, "select firstname, lastname, sex, TO_CHAR(birthday, 'DD.MM.YYYY'), street, city, state, zip, salary, branch from Employee where id = $id");
   
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
         <td>Birthday (Ex: 10-DEC-90):</td>
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
