<?php

require_once('include/include.php');


head('Create Branch');

start_post('Create Branch');

?>

<form action="createBranch.php" method="post">
   <table border="0">
      <tr>
         <td>Street Address (Ex: 123 Main St)</td>
         <td><input type="text" size="50" id="street" name="street" /></td>
      </tr>
      <tr>
         <td>City:</td>
         <td><input type="text" size="50" id="city" name="city" /></td>
      </tr>
      <tr>
         <td>Zip:</td>
         <td><input type="text" size="50" id="zip" name="zip" /></td>
      </tr>
      <tr>
         <td>Phone Number (No spaces):</td>
         <td><input type="text" size="50" id="phone" name="phone" /></td>
      </tr>
      <tr>
         <td>Fax Number (No spaces):</td>
         <td><input type="text" size="50" id="fax" name="fax" /></td>
      </tr>
         <td>Manager:</td>
         <td>TODO: Pull down list of employees</td>
      </tr>
      <tr>
         <td colspan="2"><input type="submit" value="Submit" /></td>
      </tr>
   </table>
</form>

<?php

end_post();

foot();

?>
