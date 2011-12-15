<?php

require_once('include/include.php');

$db = dbConnectt();

if($_POST['submit']){
   $property = $_POST['property'];
   $client = $_POST['client'];
   $associate = $_POST['associate'];
   $date = dbDate($_POST['date']);
   $comments = $_POST['comments'];
   $id = $_POST['id'];
   $comments = htmlspecialchars( str_replace(array('\r\n', '\n', '\r'), '<br />', $comments), ENT_QUOTES);
   
   dbExec($db, "update viewing set client = $client, associate = $associate, propertyId = $property, viewDate = $date, comments = '$comments' where id = $id");
   
   header("Location: viewViewing.php");
}


head('Edit Viewing');

$id = $_GET['id'];

if((!$id && $id != 0) || !is_numeric($id)){
   $viewQuery = dbExec($db, 'select id, propertyId, TO_CHAR(viewDate, \'DD.MM.YYYY\') from viewing');
   
   startPost('Edit Viewing');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($viewQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - For Property '.$row[1].' on '.$row[2].'</option>';
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

startPost('Edit Viewing');

$query = dbExec($db, "select propertyId, client, associate, TO_CHAR(viewDate, 'MM.DD.YYYY'), comments from Viewing where id = $id");

$row = dbFetchRow($query);

?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
   <input type="hidden" id="submit" name="submit" value="1" />
   <input type="hidden" id="id" name="id" value="<?php echo $id ?>" />
   <table>
      <tr>
         <td>Property:</td>
         <td>
            <select id="property" name="property">
            <?php
               $propertyQuery = dbExec($db, 'select id, street, city, state from property where rented = \'N\'');
               while( ($prow = dbFetchRow($propertyQuery)) ){
                  if($row[0] == $prow[0]){
                     echo '<option value="'.$prow[0].'" selected>'.$prow[0].' - '.$prow[1].', '.$prow[2].', '.$prow[3].'</option>';
                  } echo {
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
                  if($row[1] == $crow[0]){
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
                  if($row[2] == $arow[0]){
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
         <td>Viewing Date (Ex 12.10.1990):</td>
         <td><input type="text" size="30" id="date" name="date" value="<?php echo $row[3] ?>" /></td>
      </tr>
      <tr>
         <td>Client Comments (4000 Character limit):</td>
         <td>
            <textarea rows="4" cols="45" name="comments" id="comments"><?php echo $row[4] ?></textarea>
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
