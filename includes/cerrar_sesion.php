<?
require('control_sesion.php');
session_unset();
session_destroy();
header('location:../cobrador/')
?>
