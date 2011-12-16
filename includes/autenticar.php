<?
include("conex.php");

if ($connect) { 
	$user = "cn=" . $_POST['user'] . ",ou=usuarios,dc=pxcso,dc=com";
	$pass = $_POST['pass'];
    $bind = ldap_bind($connect, $user, $pass);
    if ($bind) {
		session_start();
		$base = "ou=usuarios,dc=pxcso,dc=com";
		$filter = "(cn=" . $_POST['user'] . ")";
		$params = array("cn", "givenName", "sn", "mail", "homephone", "voiceMailPassword", "departmentNumber");
		$search = ldap_search($connect, $base, $filter, $params);
		$info = ldap_get_entries($connect, $search);

		$_SESSION['user'] = $_POST['user'];
		$_SESSION['pass'] = $_POST['pass'];
		$_SESSION['nombre'] = $info[0]['givenname'][0];
		$_SESSION['apellidos'] = $info[0]['sn'][0];
		$_SESSION['mail'] = $info[0]['mail'][0];
		$_SESSION['telefono'] = $info[0]['homephone'][0];
		$_SESSION['voiceMailPassword'] = $info[0]['voicemailpassword'][0];
		if ($info[0]['departmentnumber'][0] == "1") $_SESSION['department'] = "admin";
		else if ($info[0]['departmentnumber'][0] == "2") $_SESSION['department'] = "cobrador";		
		ldap_close($connect);
		echo "OK";		 
    }
	else {
		ldap_close($connect);		
		echo "User o Password Incorrecto";
	}
} 
else { 
    echo "<h4>No se pudo conectar con el servidor LDAP. Comuniquese con el administrador</h4>"; 
} 
?>
