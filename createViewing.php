<?php

require_once('include/include.php');

$db = dbConnect();

if($_POST['submit']){
   $property = $_POST['property'];
   $client = $_POST['client'];
   $assocaite = $_POST['associate'];
   $date = dbDate($_POST['date']);
   $comments = dbEscape( htmlspecialchars( str_replace(array('\r\n', '\n', '\r'), '<br />', $_POST['comments']), ENT_QUOTES) );
   
   dbExec($db, "insert into viewing (id, client, associate, property, viewDate, comments) values (key_viewing.nextval, $client, $associate, $property, $date, '$comments'");
   
   header("Location: viewViewing.php");
}

head('Create Viewing');

startPost('Create Viewing');

?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
   <input type="hidden" id="submit" name="submit" value="1" />
   <table>
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
         <td>Viewing Date (Ex 12.10.1990):</td>
         <td><input type="text" size="30" id="date" name="date" value="<?php echo $deposit ?>" /></td>
      </tr>
      <tr>
         <td>Client Comments (4000 Character limit):</td>
         <td>
            <textarea rows="3" cols="30" name="comments" id="comments"><?php echo $comments ?></textarea>
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
