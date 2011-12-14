<?
include('../includes/control_sesion.php');
include('conex.php');

if ($connect) { 
	$user = "cn=" . $_SESSION['user'] . ",ou=usuarios,dc=pxcso,dc=com";
	$pass = $_SESSION['pass'];
    $bind = ldap_bind($connect, $user, $pass);
    if ($bind) {
		$base = "cn=" . $_SESSION['user'] . ",ou=usuarios,dc=pxcso,dc=com";
		$filter = "cn=" . $_SESSION['user'];
		$params = array("extensions");
		$search = ldap_search($connect, $base, $filter, $params);
		$info = ldap_get_entries($connect, $search);
		$info = $info[0]['extensions'][0];
		$extensions = explode(";", $info, -1);
		$ext_1 = explode(",", $extensions[0]);
		$beg = $ext_1[0];
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
