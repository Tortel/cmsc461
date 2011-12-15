<?php

require_once('include/include.php');

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
   $id = $_POST['id'];
   $rented = $_POST['rented'];
   
   if(!$street || !$city || !$state || !$zip || !$fee || !$min || !$max || !$bedrooms || !$bathrooms){
      $error = true;
   }
   
   if(!is_numeric($fee) || !is_numeric($zip) || !(strlen($zip) == 5) || !(strlen($state) == 2) ){
      $error = true;
   }
   
   if(!$error){
      //Run the query
      dbExec($db, "update Property set street = '$street', city = '$city', state = '$state', zip = '$zip', type = $type, bedrooms = $bedrooms, bathrooms = $bathrooms, sqFoot = $sqft, ".
      "rent = $rent, fee = $fee, rented = '$rented', minRent = $min, maxRent = $max, associate = $associate, owner = $owner where id = $id "); 
      
      header("Location: viewProperty.php");
   }
   
}

$id = $_GET['id'];

$db = dbConnect();

if((!$id && $id != 0) || !is_numeric($id)){
   
   $propertyQuery = dbExec($db, 'select id, street, city, state from property');
   
   startPost('Select Property');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($propertyQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].', '.$row[3].'</option>';
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
}


head('Edit Employee');

startPost('Edit Employee');

$query = dbExec($db, "select street, city, state, zip, type, bedrooms, bathrooms, sqfoot, minRent, rent, maxrent, fee, associate, owner, rented from property where id = $id");

$row = dbFetchRow($query);

?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
   <input type="hidden" value="1" id="submit" name="submit" />
   <input type="hidden" value="<?php echo $id ?>" id="id" name="id" />
   <table border="0">
      <tr>
         <td>Street Address (Ex: 123 Main St)</td>
         <td><input type="text" size="30" id="street" name="street" value="<?php echo $row[0] ?>" /></td>
      </tr>
      <tr>
         <td>City:</td>
         <td><input type="text" size="30" id="city" name="city" value="<?php echo $row[1] ?>" /></td>
      </tr>
      <tr>
         <td>State (Ex: MD):</td>
         <td><input type="text" size="30" id="state" name="state" value="<?php echo $row[2] ?>" /></td>
      </tr>
      <tr>
         <td>Zip:</td>
         <td><input type="text" size="30" id="zip" name="zip" value="<?php echo $row[3] ?>" /></td>
      </tr>
      <tr>
         <td>Property Type:</td>
         <td>
            <select id="type" name="type">
               <?php echo '<option value="'.$row[4].'">'.propertyType($row[4]).'</option>'; ?>
               <option value="0"><?php echo propertyType(0); ?></option>
               <option value="1"><?php echo propertyType(1); ?></option>
               <option value="2"><?php echo propertyType(2); ?></option>
            </select>
         </td>
      </tr>
      <tr>
         <td>Bedrooms:</td>
         <td><input type="text" size="30" id="bedrooms" name="bedrooms" value="<?php echo $row[5] ?>" /></td>
      </tr>
      <tr>
         <td>Bathrooms:</td>
         <td><input type="text" size="30" id="bathrooms" name="bathrooms" value="<?php echo $row[6] ?>" /></td>
      </tr>
      <tr>
         <td>Square Feet:</td>
         <td><input type="text" size="30" id="sqft" name="sqft" value="<?php echo $row[7] ?>" /></td>
      </tr>
      <tr>
         <td>Minimum Rent:</td>
         <td><input type="text" size="30" id="min" name="min" value="<?php echo $row[8] ?>" /></td>
      </tr>
      <tr>
         <td>Asking Rent:</td>
         <td><input type="text" size="30" id="rent" name="rent" value="<?php echo $row[9] ?>" /></td>
      </tr>
      <tr>
         <td>Max Rent:</td>
         <td><input type="text" size="30" id="max" name="max" value="<?php echo $row[10] ?>" /></td>
      </tr>
      <tr>
         <td>Management Fee (%):</td>
         <td><input type="text" size="30" id="fee" name="fee" value="<?php echo $row[11] ?>" /></td>
      </tr>
      <tr>
         <td>Managing Associate:</td>
         <td>
            <select name="associate" id="associate">
            <?php
               $associateQuery = dbExec($db, 'select id, lastName, firstName from employee where id in (select id from associate)');
               while( ($arow = dbFetchRow($associateQuery)) ){
                  if($arow[0] == $row[12]){
                     echo '<option value="'.$arow[0].'" selected>'.$arow[0].' - '.$arow[1].', '.$arow[2].'</option>';
                  } else{
                     echo '<option value="'.$arow[0].'">'.$arow[0].' - '.$arow[1].', '.$arow[2].'</option>';
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
               while( ($orow = dbFetchRow($ownerQuery)) ){
                  if($orow[0] == $row[13]){
                     echo '<option value="'.$orow[0].'" selected>'.$orow[0].' - '.$orow[1].', '.$orow[2].'</option>';
                  } else{
                     echo '<option value="'.$orow[0].'">'.$orow[0].' - '.$orow[1].', '.$orow[2].'</option>';
                  }
               }
            ?>
            </select>
         </td>
      </tr>
      <tr>
         <td>Rented:</td>
         <td>
            <select name="rented" id="rented">
               <?php echo "<option value=\"$row[14]\">$row[14]</option>"; ?>
               <option value="N">N</option>
               <option value="Y">Y</option>
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
