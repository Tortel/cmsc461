<?php

require_once('include/include.php');
check();

$db = dbConnect();

//If they submitted the form
if($_POST['submit']){
   
   //Prep the vars
   $street = dbEscape($_POST['street']);
   $state = strtoupper($_POST['state']);
   $zip = $_POST['zip'];
   $city = dbEscape($_POST['city']);
   $name = dbEscape($_POST['name']);
   $contact = dbEscape($_POST['contact']);
   $business = $_POST['business'];
   $phone = $_POST['phone'];
   $fax = $_POST['fax'];
   $type = $_POST['type'];
   $id = $_POST['id'];
   
   if(!$street || !$city || !$state || !$zip || !$phone || !$fax){
      $error = true;
   }
   
   if(!is_numeric($phone) || !is_numeric($fax) || !is_numeric($zip) || !(strlen($zip) == 5) || !(strlen($state) == 2) ){
      $error = true;
   }
   
   if(!$error){
      //Run the query
      dbExec($db, "update Owner set street = '$street', city = '$city', state = '$state', zip = '$zip', name = '$name', phone = '$phone', fax = '$fax', isBusiness = '$business' where id = $id");
      
      //Delete it from business
      dbExec($db, "delete from business where id = $id");
      
      if($business == 'Y'){
         dbExec($db, "insert into Business (id, type, contactName) values ($id, '$type', '$contact')");
      }
      
      header("Location: viewOwner.php");
   }
}

$id = $_GET['id'];

head('Edit Owner');

if( (!$id && !($id == 0)) || !is_numeric($id) ){
   $ownersQuery = dbExec($db, 'select id, name, city, state from Owner');
   
   startPost('Select Owner');
   
   ?>
   
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($ownersQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[1].' - '.$row[2].', '.$row[3].'</option>';
         }
      ?>
      </select>
      <input type="submit" value="Submit">
   </form>
   
   <?php
   
   endPost();
   
   foot();
   
   exit();
   
}

$ownerQuery = dbExec($db, "select name, street, city, state, zip, phone, fax, isBusiness from Owner where id = $id");

$row = dbFetchRow($ownerQuery);

startPost('Edit Owner');


if($error){
   echo '<b>There were errors submitting your request</b>';
}

?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
   <input type="hidden" value="1" id="submit" name="submit" />
   <input type="hidden" value="<?php echo $id; ?>" name="id" id="id" />
   <table border="0">
      <tr>
         <td>Name:</td>
         <td><input type="text" size="30" id="name" name="name" value="<?php echo $row[0]; ?>" /></td>
      </tr>
      <tr>
         <td>Street Address (Ex: 123 Main St)</td>
         <td><input type="text" size="30" id="street" name="street" value="<?php echo $row[1]; ?>" /></td>
      </tr>
      <tr>
         <td>City:</td>
         <td><input type="text" size="30" id="city" name="city" value="<?php echo $row[2]; ?>" /></td>
      </tr>
      <tr>
         <td>State (Ex: MD):</td>
         <td><input type="text" size="30" id="state" name="state" value="<?php echo $row[3]; ?>" /></td>
      </tr>
      <tr>
         <td>Zip:</td>
         <td><input type="text" size="30" id="zip" name="zip" value="<?php echo $row[4]; ?>" /></td>
      </tr>
      <tr>
         <td>Phone:</td>
         <td><input type="text" size="30" id="phone" name="phone" value="<?php echo $row[5]; ?>" /></td>
      </tr>
      <tr>
         <td>Fax:</td>
         <td><input type="text" size="30" id="fax" name="fax" value="<?php echo $row[6]; ?>" /></td>
      </tr>
      <tr>
         <td>Business?</td>
         <td>
            <select name="business" id="business">
               <option value="N">No</option>
               <?php
                  if($row[7] == 'Y'){
                     echo '<option value="Y" selected>Yes</option>';
                  } else {
                     echo '<option value="Y">Yes</option>';
                  }
               ?>
            </select>
         </td>
      </tr>
      <?php
         if($row[7] == 'Y'){
            $businessQuery = dbExec($db, "select type, contactName from business where id = $id");
            $bRow = dbFetchRow($businessQuery);
         }
      ?>
      <tr>
         <td>Business Type: (Ignored if not business)</td>
         <td><input type="text" size="30" id="type" name="type" value="<?php echo $bRow[0]; ?>" /></td>
      </tr>
      <tr>
         <td>Contact Name: (Ignored if not business)</td>
         <td><input type="text" size="30" id="contact" name="contact" value="<?php echo $bRow[1]; ?>" /></td>
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
