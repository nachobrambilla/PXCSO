<?
include('../includes/control_sesion.php');
include('conex.php');

if ($connect) { 
	$user = "cn=" . $_SESSION['user'] . ",ou=usuarios,dc=pxcso,dc=com";
	$pass = $_SESSION['pass'];
    $bind = ldap_bind($connect, $user, $pass);
    if ($bind) {
		$base = "ou=" . $_SESSION['user'] . ",ou=agenda,dc=pxcso,dc=com";
		$filter = "cn=*";
		$search = ldap_search($connect, $base, $filter);
		$info = ldap_get_entries($connect, $search);
	}
	else{
		echo "<h4>Cobrador no identificado. Comuniquese con el administrador</h4>";
	}
}
else {
	echo "<h4>No se pudo conectar con el servidor LDAP. Comuniquese con el administrador</h4>"; 
}
ldap_close($connect);
?>
