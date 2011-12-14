<?
//include('control_sesion.php'); 
$connect = ldap_connect("ldaps://pxcso1.gso.ac.upc.edu");
//$connect = ldap_connect("localhost");
ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
?>
