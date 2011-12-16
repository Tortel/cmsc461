<?php

require_once('include/include.php');
check();

$db = dbConnect();

//If they submitted the form
if($_POST['submit']){
   
   //Prep the vars
   $street = dbEscape($_POST['street']);
   $city = dbEscape($_POST['city']);
   $state = strtoupper($_POST['state']);
   $zip = $_POST['zip'];
   $type = $_POST['type'];
   $bedrooms = $_POST['bedrooms'];
   $bathrooms = $_POST['bathrooms'];
   $sqft = $_POST['sqft'];
   $rent = $_POST['rent'];
   $fee = $_POST['fee'];
   $max = $_POST['max'];
   $min = $_POST['min'];
   $associate = $_POST['associate'];
   $owner = $_POST['owner'];
   
   if(!$street || !$city || !$state || !$zip || !$fee || !$min || !$max || !$bedrooms || !$bathrooms){
      $error = true;
   }
   
   if(!is_numeric($fee) || !is_numeric($zip) || !(strlen($zip) == 5) || !(strlen($state) == 2) ){
      $error = true;
   }
   
   if(!$error){
      //Run the query
      dbExec($db, "insert into Property (id, street, city, state, zip, type, bedrooms, bathrooms, sqFoot, rent, fee, rented, posted, lastupdate, minRent, maxRent, associate, owner) values ".
         "(key_property.nextval, '$street', '$city', '$state', '$zip', $type, $bedrooms, $bathrooms, $sqft, $rent, $fee, 'N', CURRENT_DATE, CURRENT_DATE, $min, $max, $associate, $owner)"); 
      
      header("Location: viewProperty.php");
   }
   
}


head('Create Employee');

startPost('Create Employee');


if($error){
   echo '<b>There were errors submitting your request</b>';
}

?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
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
         <td>State (Ex: MD):</td>
         <td><input type="text" size="30" id="state" name="state" value="<?php echo $state ?>" /></td>
      </tr>
      <tr>
         <td>Zip:</td>
         <td><input type="text" size="30" id="zip" name="zip" value="<?php echo $zip ?>" /></td>
      </tr>
      <tr>
         <td>Property Type:</td>
         <td>
            <select id="type" name="type">
               <option value="0"><?php echo propertyType(0); ?></option>
               <option value="1"><?php echo propertyType(1); ?></option>
               <option value="2"><?php echo propertyType(2); ?></option>
            </select>
         </td>
      </tr>
      <tr>
         <td>Bedrooms:</td>
         <td><input type="text" size="30" id="bedrooms" name="bedrooms" value="<?php echo $bedrooms ?>" /></td>
      </tr>
      <tr>
         <td>Bathrooms:</td>
         <td><input type="text" size="30" id="bathrooms" name="bathrooms" value="<?php echo $bathrooms ?>" /></td>
      </tr>
      <tr>
         <td>Square Feet:</td>
         <td><input type="text" size="30" id="sqft" name="sqft" value="<?php echo $sqft ?>" /></td>
      </tr>
      <tr>
         <td>Minimum Rent:</td>
         <td><input type="text" size="30" id="min" name="min" value="<?php echo $min ?>" /></td>
      </tr>
      <tr>
         <td>Asking Rent:</td>
         <td><input type="text" size="30" id="rent" name="rent" value="<?php echo $rent ?>" /></td>
      </tr>
      <tr>
         <td>Max Rent:</td>
         <td><input type="text" size="30" id="max" name="max" value="<?php echo $max ?>" /></td>
      </tr>
      <tr>
         <td>Management Fee (%):</td>
         <td><input type="text" size="30" id="fee" name="fee" value="<?php echo $fee ?>" /></td>
      </tr>
      <tr>
         <td>Managing Associate:</td>
         <td>
            <select name="associate" id="associate">
            <?php
               $associateQuery = dbExec($db, 'select id, lastName, firstName from employee where id in (select id from associate)');
               while( ($row = dbFetchRow($associateQuery)) ){
                  if($row[0] == $associate){
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
         <td>Owner:</td>
         <td>
            <select name="owner" id="owner">
            <?php
               $ownerQuery = dbExec($db, 'select id, name from Owner');
               while( ($row = dbFetchRow($ownerQuery)) ){
                  if($row[0] == $owner){
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
