<?
include('conex.php');
include('control_sesion.php'); 

if ($connect) { 
	$user = "cn=" . $_SESSION['user'] . ",ou=usuarios,dc=pxcso,dc=com";
	$pass = $_SESSION['pass'];
    $bind = ldap_bind($connect, $user, $pass);
    if ($bind) {
		$base = "ou=usuarios,dc=pxcso,dc=com";
		$filter = "(cn=*)";
		$search = ldap_search($connect, $base, $filter);
		$info = ldap_get_entries($connect, $search);
	}
	else {
		echo "Cobrador no identificado. Comuniquese con el administrador";	
	}
}
else {
	echo "No se pudo conectar con el servidor LDAP. Comuniquese con el administrador"; 
}
ldap_close($connect);
?>
