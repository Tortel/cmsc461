<?php
session_start();

function check(){
   if(!session_is_registered(loggedIn)){
     header("location:login.php");
   }
}

function login($user, $pass){
   if(($user == 'associate' || $user == 'manager') && $pass == 'secret'){
      session_register('loggedIn');
      return true;
   }
   return false;
}


function logout(){
   session_start();
   session_destroy();
}
?>
