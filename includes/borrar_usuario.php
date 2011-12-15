<?
include('control_sesion.php');
include('conex.php');

if (!empty($_POST['cn'])) { 
	$cn = $_POST['cn'];
	$user = $_SESSION['user'];

	$admin = "cn=admin,dc=pxcso,dc=com";
	$pass = "LdapPassw01";
	
	if (ldap_bind($connect, $admin, $pass)) {
	
		$base = "ou=usuarios,dc=pxcso,dc=com";
		try {
			if(ldap_delete($connect,"cn=$cn,$base")) {
				if(ldap_delete($connect,"ou=$cn,ou=agenda,dc=pxcso,dc=com")) {
				
					$string = 'deluser '.$cn;
					$fichero = '../asterisk_talk/del/'.$cn;
					unlink($fichero);
					$fp = fopen($fichero, "w");
					fputs($fp, $string);
					
					echo "El contacto se ha borrado correctamente";
				}
				else echo "Ha habido un error borrando el contacto"; 
			}
			else echo "Ha habido un error borrando el contacto"; 
		}
		catch (ErrorException $e) {
			echo "No se pudo borrar el contacto $cn.";
		}
	}
	else echo 'Error de conexión';
}
?>
