<?php

require_once('include/include.php');

$db = dbConnect();

//If they submitted the form
if($_POST['submit']){
   
   //Prep the vars
   $firstName = dbEscape($_POST['firstName']);
   $lastName = dbEscape($_POST['lastName']);
   $street = dbEscape($_POST['street']);
   $city = dbEscape($_POST['city']);
   $state = strtoupper($_POST['state']);
   $zip = $_POST['zip'];
   $phone = $_POST['phone'];
   $work = $_POST['work'];
   $type = $_POST['type'];
   $maxRent = $_POST['maxRent'];
   $associate = $_POST['associate'];
   $branch = $_POST['branch'];
   
   if(!$street || !$city || !$state || !$zip || !$phone || !$work || !$firstName || !$lastName || !$maxRent){
      $error = true;
   }
   
   if(!is_numeric($maxRent) || !is_numeric($zip) || !(strlen($zip) == 5) || !(strlen($state) == 2) ){
      $error = true;
   }
   
   if(!$error){
      //Run the query
      $query = dbExec($db, "insert into Client (id, street, city, state, zip, firstname, lastName, branch, phone, workPhone, propertyType, maxRent, associate, registerDate) values ".
         "(key_client.nextval, '$street', '$city', '$state', '$zip', '$firstName', '$lastName', $branch, '$phone', '$work', $type, $maxRent, $associate, CURRENT_DATE)"); 
      
      header('Location: viewClient.php');
   }
   
}

head('Create Client');

startPost('Create Client');
?>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
<input type="hidden" id="submit" name="submit" value="1" />
   <table>
      <td>First Name:</td>
         <td><input type="text" size="30" id="firstName" name="firstName" value="<?php echo $firstName; ?>" /></td>
      </tr>
      <tr>
         <td>Last Name:</td>
         <td><input type="text" size="30" id="lastName" name="lastName" value="<?php echo $lastName; ?>" /></td>
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
         <td>Home Phone:</td>
         <td><input type="text" size="30" id="phone" name="phone" value="<?php echo $phone ?>" /></td>
      </tr>
      <tr>
         <td>Work Phone:</td>
         <td><input type="text" size="30" id="work" name="work" value="<?php echo $work ?>" /></td>
      </tr>
      <tr>
         <td>Property Prefrence:</td>
         <td>
            <select id="type" name="type">
               <option value="0"><?php echo propertyType(0); ?></option>
               <option value="1"><?php echo propertyType(1); ?></option>
               <option value="2"><?php echo propertyType(2); ?></option>
            </select>
         </td>
      </tr>
      <tr>
         <td>Maximum Rent: (No $ sign)</td>
         <td><input type="text" size="30" id="maxRent" name="maxRent" value="<?php echo $maxRent ?>" /></td>
      </tr>
      <tr>
         <td>Register Date:</td>
         <td><?php echo $row[10]; ?></td>
      </tr>
      <tr>
         <td>Registering Associate:</td>
         <td>
            <select name="associate" id="associate">
            <?php
               $associateQuery = dbExec($db, 'select id, lastName, firstName from employee where id in (select id from associate)');
               while( ($row = dbFetchRow($associateQuery)) ){
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

