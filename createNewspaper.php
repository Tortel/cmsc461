<?php

require_once('include/include.php');
check();

$db = dbConnect();

if($_POST['submit']){
   
   //Prep the vars
   $street = dbEscape($_POST['street']);
   $state = strtoupper($_POST['state']);
   $zip = $_POST['zip'];
   $city = dbEscape($_POST['city']);
   $name = dbEscape($_POST['name']);
   $contact = dbEscape($_POST['contact']);
   $phone = $_POST['phone'];
   $fax = $_POST['fax'];
   
   if(!$street || !$city || !$state || !$zip || !$phone || !$fax){
      $error = true;
   }
   
   if(!is_numeric($phone) || !is_numeric($fax) || !is_numeric($zip) || !(strlen($zip) == 5) || !(strlen($state) == 2) ){
      $error = true;
   }
   
   if(!$error){
      //Run the query
      dbExec($db, "insert into Newspaper (id, street, city, state, zip, name, phone, fax, contactName) values ".
         "(key_newspaper.nextval, '$street', '$city', '$state', '$zip', '$name', '$phone', '$fax', '$contact')");
      
      header("Location: viewNewspaper.php");
   }
   
   
}

head('Create Newspaper');

startPost('Create Newspaper');

?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
   <input type="hidden" id="submit" name="submit" value="1" />
   <table>
      <tr>
         <td>Name:</td>
         <td><input type="text" size="30" id="name" name="name" value="<?php echo $name; ?>" /></td>
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
         <td>Phone:</td>
         <td><input type="text" size="30" id="phone" name="phone" value="<?php echo $phone ?>" /></td>
      </tr>
      <tr>
         <td>Fax:</td>
         <td><input type="text" size="30" id="fax" name="fax" value="<?php echo $fax ?>" /></td>
      </tr>
      <tr>
         <td>Contact Name:</td>
         <td><input type="text" size="30" id="contact" name="contact" value="<?php echo $contact ?>" /></td>
      </tr>
      <tr>
         <td colspan="2" align="center">
            <input type="submit" value="Submit" />
         </td>
      </tr>
   </table>
</form>

<?php

endPost();

foot();

?>
