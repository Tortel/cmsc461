<?php

require_once('include/include.php');


//If they submitted the form
if($_POST['submit']){
   
   //Need to check for manager too
   if(!$_POST['street'] || !$_POST['city'] || $_POST['zip'] || $_POST['phone']
         || $_POST['fax']){
      $error = true;
   }
   
   if(!is_numeric($_POST['phone']) || !is_numeric($_POST['fax'])
         || !(strlen($_POST['phone']) == 10) || !(strlen($_POST['fax']) == 10) ){
      $error = true;
   }
   
   if(!$error){
      //This is where the new branch is acutally created
      $db = dbConnect();
      
      //Parse the query
      $query = oci_parse($db, "insert into Branch (street, city, state, zip, phone, fax, manager) values ('$_POST['street']', '$_POST['city']', '$_POST['zip']', '$_POST['phone']', '$_POST['fax'], null);"); 
      if (!$query){
         $e = oci_error($db);
         trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
      }
   }
   
}







head('Create Branch');

startPost('Create Branch');


if($error){
   echo '<b>There were errors submitting your request</b>';
}

?>

<form action="createBranch.php" method="post">
   <input type="hidden" value="1" id="submit" name="submit" />
   <table border="0">
      <tr>
         <td>Street Address (Ex: 123 Main St)</td>
         <td><input type="text" size="30" id="street" name="street" value="<?php echo $_POST['street'] ?>" /></td>
      </tr>
      <tr>
         <td>City:</td>
         <td><input type="text" size="30" id="city" name="city" value="<?php echo $_POST['city'] ?>" /></td>
      </tr>
      <tr>
         <td>Zip:</td>
         <td><input type="text" size="30" id="zip" name="zip" value="<?php echo $_POST['zip'] ?>" /></td>
      </tr>
      <tr>
         <td>Phone Number (No spaces):</td>
         <td><input type="text" size="30" id="phone" name="phone" value="<?php echo $_POST['phone'] ?>" /></td>
      </tr>
      <tr>
         <td>Fax Number (No spaces):</td>
         <td><input type="text" size="30" id="fax" name="fax" value="<?php echo $_POST['fax'] ?>" /></td>
      </tr>
         <td>Manager:</td>
         <td>TODO: Pull down list of employees</td>
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
