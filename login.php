<?php

include('include/include.php');
check();

if($_POST['username'] && $_POST['password']){
   if(login($_POST['username'], $_POST['password'])){
      header('Location: index.php');
   }
}


head('Log in');

startPost('Log in');
?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
<table>
<tr>
<td>Username:</td>
<td><input type="text" size="20" name="username" id="username" /></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" size="20" name="password" id="password" /></td>
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
