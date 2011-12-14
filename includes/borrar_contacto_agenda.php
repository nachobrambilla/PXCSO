<?
include('control_sesion.php');
include('conex.php');

if (!empty($_POST['cn'])) { 
	$cn = $_POST['cn'];
	$user = $_SESSION['user'];

	$admin = "cn=admin,dc=pxcso,dc=com";
	$pass = "LdapPassw01";
	
	if (ldap_bind($connect, $admin, $pass)) {
	
		try {
			if(ldap_delete($connect,"cn=$cn,ou=$user,ou=agenda,dc=pxcso,dc=com")) echo "El contacto se ha borrado correctamente";
		}
		catch (ErrorException $e) {
			echo "No se pudo borrar el contacto $cn.";
		}
	}
	else echo 'Error de conexión';
}
?>
