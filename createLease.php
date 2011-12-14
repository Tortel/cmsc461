<?php

require_once('include/include.php');

$db = dbConnect();

if($_POST['submit']){
   $rent = $_POST['rent'];
   $deposit = $_POST['deposit'];
   $start = dbDate($_POST['start']);
   $end = dbDate($_POST['end']);
   $property = $_POST['property'];
   $client = $_POST['client'];
   $associate = $_POST['associate'];
   
   if( !(!$rent || !$deposit || !$start || !$end || !$property || !$associate || !$client) ){
      //Create it
      dbExec($db, "insert into Lease (id, rent, deposit, startDate, endDate, client, property, associate) values".
      "(key_lease.nextval, $rent, $deposit, $start, $end, $client, $property, $associate)");
      //Update the property
      sleep(1);
      dbExec($db, "update property set rented = 'Y' where id = $property");
      
      header('Location: viewLease.php');
   }

}


head('Create Lease');

startPost('Create Lease');

?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
   <input type="hidden" id="submit" name="submit" value="1" />
   <table>
      <tr>
         <td>Monthly Rent:</td>
         <td><input type="text" size="30" id="rent" name="rent" value="<?php echo $rent ?>" /></td>
      </tr>
      <tr>
         <td>Deposit:</td>
         <td><input type="text" size="30" id="deposit" name="deposit" value="<?php echo $deposit ?>" /></td>
      </tr>
      <tr>
         <td>Start Date (Ex 12.10.2011):</td>
         <td><input type="text" size="30" id="start" name="start" value="<?php echo $start ?>" /></td>
      </tr>
      <tr>
         <td>End Date (Ex 12.10.2012):</td>
         <td><input type="text" size="30" id="end" name="end" value="<?php echo $end ?>" /></td>
      </tr>
      <tr>
         <td>Property:</td>
         <td>
            <select id="property" name="property">
            <?php
               $propertyQuery = dbExec($db, 'select id, street, city, state from property where rented = \'N\'');
               
               while( ($row = dbFetchRow($propertyQuery)) ){
                  echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].', '.$row[3].'</option>';
               }
            ?>
            </select>
         </td>
      </tr>
      <tr>
         <td>Client:</td>
         <td>
            <select id="client" name="client">
            <?php
               $clientQuery = dbExec($db, 'select id, lastName, firstName from client');
               while( ($row = dbFetchRow($clientQuery)) ){
                  echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].'</option>';
               }
            ?>
            </select>
         </td>
      </tr>
      <tr>
         <td>Associate:</td>
         <td>
            <select id="associate" name="associate">
            <?php
               $associateQuery = dbExec($db, 'select id, lastName, firstName from employee where id in (select id from associate)');
               while( ($row = dbFetchRow($associateQuery)) ){
                  echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].'</option>';
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
