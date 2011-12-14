<?
include('conex.php');
include('control_sesion.php'); 

if ($connect) { 
	$user = "cn=" . $_SESSION['user'] . ",ou=usuarios,dc=pxcso,dc=com";
	$pass = $_SESSION['pass'];
    $bind = ldap_bind($connect, $user, $pass);
    if ($bind) {
		$base = "ou=usuarios,dc=pxcso,dc=com";
		$filter = "(cn=" . $_SESSION['user'] . ")";
		$params = array("cn", "sn", "mail", "homephone");
		$search = ldap_search($connect, $base, $filter, $params);
		$info = ldap_get_entries($connect, $search);
	}
	else {
		echo "<h4>Cobrador no identificado. Comuniquese con el administrador</h4>";	
	}
}
else {
	echo "<h4>No se pudo conectar con el servidor LDAP. Comuniquese con el administrador</h4>"; 
}
ldap_close($connect);
?>
