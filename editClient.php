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
   $id = $_POST['id'];
   
   if(!$street || !$city || !$state || !$zip || !$phone || !$work || !$firstName || !$lastName || !$maxRent){
      $error = true;
   }
   
   if(!is_numeric($maxRent) || !is_numeric($zip) || !(strlen($zip) == 5) || !(strlen($state) == 2) ){
      $error = true;
   }
   
   if(!$error){
      //Run the query
      dbExec($db, "update Client set street = '$street', city = '$city', state = '$state', zip = '$zip', firstname = '$firstName', lastName = '$lastName', branch = $branch, phone = '$phone', ".
      "workPhone = '$work', propertyType = $type, maxRent = $maxRent, associate = $associate where id = $id");
      
      header("Location: viewClient.php");
   }
   
}

head('Edit Client');

$id = $_GET['id'];

if( (!$id && !($id == 0)) || !is_numeric($id) ){
   startPost('Edit Client');
      
   $clientQuery = dbExec($db, 'select id, lastName, firstName from client');

   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="submit" id="submit" value="1">
      <table border="0">
      <tr>
         <td>Delete Client:</td>
         <td>
            <select id="id" name="id">
               <?php
                  while( ($row = dbFetchRow($clientQuery)) ){
                     echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].'</option>';
                  }
               ?>
            </select>
         </td>
      </tr>
      <tr>
      <td colsan="2" align="center">
         <input type="submit" value="Submit" />
      </td>
      </tr>
      </table>
   </form>
   <?php

   endPost();

   foot();
   exit();
}

$query = dbExec($db, "Select firstName, lastName, street, city, state, zip, phone, workphone, propertyType, maxRent, registerDate, associate, branchId from Client where id = $id");

$row = dbFetchRow($query);

startPost('Edit Client');
?>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
<input type="hidden" id="submit" name="submit" value="1" />
<input type="hidden" value="<?php echo $id; ?>" id="id" mane="id" />
   <table>
      <td>First Name:</td>
         <td><input type="text" size="30" id="firstName" name="firstName" value="<?php echo $row[0]; ?>" /></td>
      </tr>
      <tr>
         <td>Last Name:</td>
         <td><input type="text" size="30" id="lastName" name="lastName" value="<?php echo $row[1]; ?>" /></td>
      </tr>
      <tr>
         <td>Street Address (Ex: 123 Main St)</td>
         <td><input type="text" size="30" id="street" name="street" value="<?php echo $row[2] ?>" /></td>
      </tr>
      <tr>
         <td>City:</td>
         <td><input type="text" size="30" id="city" name="city" value="<?php echo $row[3] ?>" /></td>
      </tr>
      <tr>
         <td>State (Ex: MD):</td>
         <td><input type="text" size="30" id="state" name="state" value="<?php echo $row[4] ?>" /></td>
      </tr>
      <tr>
         <td>Zip:</td>
         <td><input type="text" size="30" id="zip" name="zip" value="<?php echo $row[5] ?>" /></td>
      </tr>
      <tr>
         <td>Home Phone:</td>
         <td><input type="text" size="30" id="phone" name="phone" value="<?php echo $row[6] ?>" /></td>
      </tr>
      <tr>
         <td>Work Phone:</td>
         <td><input type="text" size="30" id="work" name="work" value="<?php echo $row[7] ?>" /></td>
      </tr>
      <tr>
         <td>Property Prefrence:</td>
         <td>
            <select id="type" name="type">
               <?php echo '<option value="'.$row[8].'">'.propertyType($row[8]).'</option>';
               <option value="0"><?php echo propertyType(0); ?></option>
               <option value="1"><?php echo propertyType(1); ?></option>
               <option value="2"><?php echo propertyType(2); ?></option>
            </select>
         </td>
      </tr>
      <tr>
         <td>Maximum Rent: (No $ sign)</td>
         <td><input type="text" size="30" id="maxRent" name="maxRent" value="<?php echo $row[9] ?>" /></td>
      </tr>
      <tr>
         <td>Registering Associate:</td>
         <td>
            <select name="associate" id="associate">
            <?php
               $associateQuery = dbExec($db, 'select id, lastName, firstName from employee where id in (select id from associate)');
               while( ($arow = dbFetchRow($associateQuery)) ){
                  if($arow[0] == $row[10]){
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
               while( ($brow = dbFetchRow($branchesQuery)) ){
                  if($brow[0] == $row[11]){
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

