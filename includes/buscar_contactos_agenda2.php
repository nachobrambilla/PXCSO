<?
include('conex.php');
include('control_sesion.php'); 

if ($connect) { 
	$user = "cn=juan.cifo,ou=usuarios,dc=pxcso,dc=com";
	$pass = "Password123";
    $bind = ldap_bind($connect, $user, $pass);
    if ($bind) {
		$base = "ou=juan.cifo,ou=agenda,dc=pxcso,dc=com";
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
echo json_encode($info);
?>
