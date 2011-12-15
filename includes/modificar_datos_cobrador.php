<?
include('conex.php');
include('control_sesion.php');

if ($connect) { 
	$user = "cn=admin,dc=pxcso,dc=com";
	$pass = "LdapPassw01";
    $bind = ldap_bind($connect, $user, $pass);
    if ($bind) {
		$base = "cn=" . $_SESSION['user'] . ",ou=usuarios,dc=pxcso,dc=com";
		$info['mail'][0] = $_POST['mymail'];
		$info['homephone'][0] = $_POST['telefono']; 
		$info['userPassword'][0] = $_POST['password'];
		$info['voicemailpassword'][0] = $_POST['voiceMailPassword'];
		
		$_SESSION['mail'] = $_POST['mymail'];
		$_SESSION['telefono'] = $_POST['telefono'];
		$_SESSION['pass'] = $_POST['password'];
		$_SESSION['voiceMailPassword'] = $_POST['voiceMailPassword'];

		if (ldap_modify($connect, $base, $info)) {
			echo "Datos modificados correctamente";
			$string = 'moduser '.$_SESSION['user'].' '.$_SESSION['pass'].' '.$_SESSION['voiceMailPassword'];
			$fichero = '../asterisk_talk/mod/'.$_SESSION['user'];
			unlink($fichero);
			$fp = fopen($fichero, "w");
			fputs($fp, $string); 
		}
		else echo "Error en la modificacion";
	}
	else {
		echo "<Cobrador no identificado. Comuniquese con el administrador";	
	}
}
else {
	echo "No se pudo conectar con el servidor LDAP. Comuniquese con el administrador"; 
}
ldap_close($connect);
?>
