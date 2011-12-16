<?
include('control_sesion.php'); 
include_once('util.php');
$user = $_SESSION['user'];

$uid = $cn = $_POST['modifica_cn'];
$userpassword = $_POST['modifica_userpassword_admin'];
$voicemailpassword = $_POST['modifica_voicemailpassword_admin'];
$departmentNumber = $_POST['modifica_departmentNumber_admin'];
$habilitado = $_POST['modifica_habilitado'];

$info = '';

if (!empty($userpassword)) $info['userpassword'][0] = $userpassword;
if (!empty($voicemailpassword)) $info['voicemailpassword'][0] = $voicemailpassword;
$info['departmentNumber'][0] = $departmentNumber;

include('conex.php');

$admin = "cn=admin,dc=pxcso,dc=com";
$pass = "LdapPassw01";

if (ldap_bind($connect, $admin, $pass)) {	
	$base = "ou=usuarios,dc=pxcso,dc=com";
	
	if ($habilitado == '1') {
		$string_habilitar = "enable ".$cn;
		$info['asteriskdisabled'] = '0';
	}
	else {
		$string_habilitar = "disable ".$cn;
		$info['asteriskdisabled'] = '1';
	}
	
	if (ldap_modify($connect,"cn=$cn,$base",$info)) {
	
		$fichero_habilitar = '../asterisk_talk/ena/'.$cn;
		unlink($fichero_habilitar);
		$fp_habilitar = fopen($fichero_habilitar, "w");
		fputs($fp_habilitar, $string_habilitar);

		if (!empty($userpassword)) {
			if (!empty($voicemailpassword)) 
				$string = "moduser ".$cn." ".$userpassword." ".$voicemailpassword;
			else 
				$string = "moduser ".$cn." ".$userpassword." 0";
		}
		else {
			if (!empty($voicemailpassword)) 
				$string = "moduser ".$cn." 0 ".$voicemailpassword;
			else 
				$string = "moduser ".$cn." 0 0";
		}
		
		$fichero = '../asterisk_talk/mod/'.$_SESSION['user'];
		unlink($fichero);
		$fp = fopen($fichero, "w");
		fputs($fp, $string); 
	
		echo "El usuario se ha modificado correctamente";
	}
	else echo "Ha habido un error modificando el usuario";
}
else echo "Error de conexión";

?>
