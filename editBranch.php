<?php

require_once('include/include.php');

$db = dbConnect();

//Check for updates to the data
if($_POST['submit']){
   
   //Prep the vars
   $street = dbEscape($_POST['street']);
   $city = dbEscape($_POST['city']);
   $state = strtoupper($_POST['state']);
   $zip = $_POST['zip'];
   $phone = $_POST['phone'];
   $fax = $_POST['fax'];
   $manager = $_POST['manager'];
   $id = $_POST['branch'];
   
   //Manager is always set
   if(!$street || !$city || !$state || !$zip || !$phone || !$fax){
      $error = true;
   }
   
   if(!is_numeric($phone) || !is_numeric($fax) || !(strlen($phone) == 10) || !(strlen($fax) == 10) || !is_numeric($zip) || !(strlen($zip) == 5) || !(strlen($state) == 2) ){
      $error = true;
   }
   
   if(!$error){
      //Run the query
      $query = dbExec($db, "update Branch set street = '$street', city = '$city', state = '$state', zip = '$zip', phone = '$phone', fax = '$fax', manager = $manager where id = $id"); 
      
      header('Location: viewBranch.php');
   }
   
}

head('Edit Branch Details');

$branch = $_GET['id'];

if(!$branch || !is_numeric($branch)){
   //Branch not selected, show option to select one
   
   $branchesQuery = dbExec($db, 'select id, city, state from Branch');
   
   startPost('Select Branch');
   ?>
   <form action="editBranch.php" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($branchesQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].'</option>';
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
   //Get the branch details
   $branchQuery = dbExec($db, "select street, city, state, zip, phone, fax, manager from Branch where Branch.id = $branch");
   
   $branchRow = dbFetchRow($branchQuery);
   
   startPost('Edit Branch '.$branch.' Details');
   ?>
   
<form action="editBranch.php" method="post">
   <input type="hidden" value="1" id="submit" name="submit" />
   <input type="hidden" value="<?php echo $branch; ?>" id="id" name="id" />
   <table border="0">
      <tr>
         <td>Street Address (Ex: 123 Main St)</td>
         <td><input type="text" size="30" id="street" name="street" value="<?php echo $branchRow[0] ?>" /></td>
      </tr>
      <tr>
         <td>City:</td>
         <td><input type="text" size="30" id="city" name="city" value="<?php echo $branchRow[1] ?>" /></td>
      </tr>
      <tr>
         <td>State (Ex: MD):</td>
         <td><input type="text" size="30" id="state" name="state" value="<?php echo $branchRow[2] ?>" /></td>
      </tr>
      <tr>
         <td>Zip:</td>
         <td><input type="text" size="30" id="zip" name="zip" value="<?php echo $branchRow[3] ?>" /></td>
      </tr>
      <tr>
         <td>Phone Number (No spaces):</td>
         <td><input type="text" size="30" id="phone" name="phone" value="<?php echo $branchRow[4] ?>" /></td>
      </tr>
      <tr>
         <td>Fax Number (No spaces):</td>
         <td><input type="text" size="30" id="fax" name="fax" value="<?php echo $branchRow[5] ?>" /></td>
      </tr>
         <td>Manager:</td>
         <td>
            <select name="manager" id="manager">
            <?php
               //Might want this to be a trigger too
               $managers = dbExec($db, 'select Employee.id, firstname, lastname from employee where Employee.id not in'.
                  ' (select Associate.id from associate union select Supervisor.id from supervisor)');
               while( ($row = dbFetchRow($managers)) ){
                  if($row[0] == $branchRow[6]) {
                     echo '<option value="'.$row[0].'" selected>'.$row[1].' '.$row[2].'</option>';
                  } else {
                     echo '<option value="'.$row[0].'">'.$row[1].' '.$row[2].'</option>';
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
