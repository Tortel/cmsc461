<?php

require_once('include/include.php');


//If they submitted the form
if($_POST['submit']){
   
   //Prep the vars
   $street = $_POST['street'];
   $city = $_POST['city'];
   $zip = $_POST['zip'];
   $phone = $_POST['phone'];
   $fax = $_POST['fax'];
   //$managet = '$_POST['manager'];
   
   //Need to check for manager too
   if(!$street || !$city || !$zip || !$phone || !$fax){
      $error = true;
   }
   
   if(!is_numeric($phone) || !is_numeric($fax) || !(strlen($phone) == 10) || !(strlen($fax) == 10) ){
      $error = true;
   }
   
   if(!$error){
      //This is where the new branch is acutally created
      $db = dbConnect();
      
      //Parse the query
      
      
      $query = oci_parse($db, "insert into Branch (street, city, state, zip, phone, fax, manager) values ('$street', '$city', '$zip', '$phone', '$fax', null);"); 
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
         <td><input type="text" size="30" id="street" name="street" value="<?php echo $street ?>" /></td>
      </tr>
      <tr>
         <td>City:</td>
         <td><input type="text" size="30" id="city" name="city" value="<?php echo $city ?>" /></td>
      </tr>
      <tr>
         <td>Zip:</td>
         <td><input type="text" size="30" id="zip" name="zip" value="<?php echo $zip ?>" /></td>
      </tr>
      <tr>
         <td>Phone Number (No spaces):</td>
         <td><input type="text" size="30" id="phone" name="phone" value="<?php echo $phone ?>" /></td>
      </tr>
      <tr>
         <td>Fax Number (No spaces):</td>
         <td><input type="text" size="30" id="fax" name="fax" value="<?php echo $fax ?>" /></td>
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
