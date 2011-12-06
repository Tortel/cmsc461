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
   $birthday = dbEscape($_POST['birtahday']);
   $state = strtoupper($_POST['state']);
   $zip = $_POST['zip'];
   $salary = $_POST['salary'];
   $branch = $_POST['branch'];
   
   //Manager is always set
   if(!$street || !$city || !$state || !$zip || !$salary || !$birthday || !$firstName || !$lastName){
      $error = true;
   }
   
   if(!is_numeric($salary) || !is_numeric($zip) || !(strlen($zip) == 5) || !(strlen($state) == 2) ){
      $error = true;
   }
   
   if(!$error){
      //This is where the new branch is acutally created

      //Run the query
      $query = dbExec($db, "insert into Employee (id, street, city, state, zip, firstname, lastName, birthday, sex, salary, branch) values ".
         "(key_employee.nextval, '$street', '$city', '$state', '$zip', '$firstName', '$lastName', ".dbDate($birthday).", '$sex', $salary, $branch)"); 
      
      header('Location: viewEmployee.php');
   }
   
}

head('Create Employee');

startPost('Create Employee');


if($error){
   echo '<b>There were errors submitting your request</b>';
}

?>

<form action="createEmployee.php" method="post">
   <input type="hidden" value="1" id="submit" name="submit" />
   <table border="0">
      <tr>
         <td>First Name:</td>
         <td><input type="text" size="30" id="firstName" name="firstName" value="<?php echo $firstName; ?>" /></td>
      </tr>
      <tr>
         <td>Last Name:</td>
         <td><input type="text" size="30" id="lastName" name="lastName" value="<?php echo $lastName; ?>" /></td>
      </tr>
      <tr>
         <td>Sex:</td>
         <td>
            <select name="sex" id="sex">
               <option value="F">Female</option>
               <option value="M">Male</option>
            </select>
         </td>
      </tr>
      <tr>
         <td>Birthday (Ex: 12.10.1990):</td>
         <td><input type="text" size="30" id="birthday" name="birthday" value="<?php echo $birthday; ?>" /></td>
      </tr>
      <tr>
         <td>Street Address (Ex: 123 Main St)</td>
         <td><input type="text" size="30" id="street" name="street" value="<?php echo $street ?>" /></td>
      </tr>
      <tr>
         <td>City:</td>
         <td><input type="text" size="30" id="city" name="city" value="<?php echo $city ?>" /></td>
      </tr>
      <tr>
         <td>State (Ex: MD):</td>
         <td><input type="text" size="30" id="state" name="state" value="<?php echo $state ?>" /></td>
      </tr>
      <tr>
         <td>Zip:</td>
         <td><input type="text" size="30" id="zip" name="zip" value="<?php echo $zip ?>" /></td>
      </tr>
      <tr>
         <td>Salary (No $ sign):</td>
         <td><input type="text" size="30" id="salary" name="salary" value="<?php echo $salary ?>" /></td>
      </tr>
         <td>Branch:</td>
         <td>
            <select name="branch" id="branch">
            <?php
               $branchesQuery = dbExec($db, 'select id, city, state from Branch');
               while( ($row = dbFetchRow($branchesQuery)) ){
                  if($row[0] == $branch){
                     echo '<option value="'.$row[0].'" selected>'.$row[0].' - '.$row[1].', '.$row[2].'</option>';
                  } else{
                     echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].'</option>';
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

?>