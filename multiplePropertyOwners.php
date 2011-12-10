<?php

require_once('include/include.php');

$db = dbConnect();

head('Owners with Multiple Properties');

startPost('Owners with Multiple Properties');

$query = dbExec($db, 'Select name,

