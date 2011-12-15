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
   $id = $_POST['id'];
   
   if( !(!$rent || !$deposit || !$start || !$end || !$property || !$associate || !$client) ){
      //Create it
      dbExec($db, "update Lease set rent = $rent, deposit = $deposit, startDate = $start, endDate = $end, client = $client, property = $property, associate = $associate where id = $id");
      
      header('Location: viewLease.php');
   }

}

head('Edit Lease');

$id = $_GET['id'];

if((!$id && $id != 0) || !is_numeric($id)){
   $leaseQuery = dbExec($db, 'select id, TO_CHAR(startDate, \'MM.DD.YYYY\'), TO_CHAR(endDate, \'MM.DD.YYYY\'), property from lease');
   
   startPost('Select Lease');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($leaseQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].' through '.$row[2].' for Property '.$row[3].'</option>';
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

startPost('Edit Lease');

$query = dbExec($db, "select rent, deposit, TO_CHAR(startDate, 'MM.DD.YYYY'), TO_CHAR(endDate, 'MM.DD.YYYY'), property, client, associate from Lease where id = $id");

$row = dbFetchRow($query);

?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
   <input type="hidden" id="submit" name="submit" value="1" />
   <input type="hidden" id="id" name="id" value="<?php echo $id ?>" />
   <table>
      <tr>
         <td>Monthly Rent:</td>
         <td><input type="text" size="30" id="rent" name="rent" value="<?php echo $row[0] ?>" /></td>
      </tr>
      <tr>
         <td>Deposit:</td>
         <td><input type="text" size="30" id="deposit" name="deposit" value="<?php echo $row[1] ?>" /></td>
      </tr>
      <tr>
         <td>Start Date (Ex 12.10.2011):</td>
         <td><input type="text" size="30" id="start" name="start" value="<?php echo $row[2] ?>" /></td>
      </tr>
      <tr>
         <td>End Date (Ex 12.10.2012):</td>
         <td><input type="text" size="30" id="end" name="end" value="<?php echo $row[3] ?>" /></td>
      </tr>
      <tr>
         <td>Property:</td>
         <td>
            <select id="property" name="property">
            <option value="<?php echo $row[4] ?">Property <?php echo $row[4] ?></option>
            <?php
               $propertyQuery = dbExec($db, 'select id, street, city, state from property where rented = \'N\'');
               while( ($prow = dbFetchRow($propertyQuery)) ){
                  if($prow[0] == $row[4]){
                     echo '<option value="'.$prow[0].'" selected>'.$prow[0].' - '.$prow[1].', '.$prow[2].', '.$prow[3].'</option>';
                  } else {
                     echo '<option value="'.$prow[0].'">'.$prow[0].' - '.$prow[1].', '.$prow[2].', '.$prow[3].'</option>';
                  }
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
               while( ($crow = dbFetchRow($clientQuery)) ){
                  if($crow[0] == $row[5]){
                     echo '<option value="'.$crow[0].'" selected>'.$crow[0].' - '.$crow[1].', '.$crow[2].'</option>';
                  } else {
                     echo '<option value="'.$crow[0].'">'.$crow[0].' - '.$crow[1].', '.$crow[2].'</option>';
                  }
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
               while( ($arow = dbFetchRow($associateQuery)) ){
                  if($arow[0] == $row[6]){
                     echo '<option value="'.$arow[0].'" selected>'.$arow[0].' - '.$arow[1].', '.$arow[2].'</option>';
                  } else {
                     echo '<option value="'.$arow[0].'">'.$arow[0].' - '.$arow[1].', '.$arow[2].'</option>';
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
