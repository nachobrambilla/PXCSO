<?
include('control_sesion.php');
include('conex.php');
$cn = $_POST['cn'];

if ($connect) { 
	$user = "cn=" . $_SESSION['user'] . ",ou=usuarios,dc=pxcso,dc=com";
	$pass = $_SESSION['pass'];
    $bind = ldap_bind($connect, $user, $pass);
    if ($bind) {
		$base = "ou=" . $_SESSION['user'] . ",ou=agenda,dc=pxcso,dc=com";
		$filter = "cn=$cn";
		$search = ldap_search($connect, $base, $filter);
		$data = ldap_get_entries($connect, $search);
		
		$datos['cn'] = $cn;
		if (isset($data[0]['sn'][0])) $datos['sn'] = $data[0]['sn'][0];
		if (isset($data[0]['givenname'][0])) $datos['givenname'] = $data[0]['givenname'][0];
		if (isset($data[0]['postaladdress'][0])) $datos['postaladdress'] = $data[0]['postaladdress'][0];
		if (isset($data[0]['homephone'][0])) $datos['homephone'] = $data[0]['homephone'][0];
		if (isset($data[0]['mobile'][0])) $datos['mobile'] = $data[0]['mobile'][0];
		if (isset($data[0]['telephonenumber'][0])) $datos['telephonenumber'] = $data[0]['telephonenumber'][0];
		if (isset($data[0]['mail'][0])) $datos['mail'] = $data[0]['mail'][0];
		if (isset($data[0]['mail'][1])) $datos['mail2'] = $data[0]['mail'][1];
				
		echo json_encode($datos);
		
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
