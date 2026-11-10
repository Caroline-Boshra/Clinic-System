<?php
use Clinic\{Database,Auth};

$auth  = new Auth($users);         
 

$auth->logout();
header('Location: register.php');
exit;