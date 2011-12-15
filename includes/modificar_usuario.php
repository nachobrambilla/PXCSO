<?
include('control_sesion.php'); 
include_once('util.php');
$user = $_SESSION['user'];

$uid = $cn = $_POST['modifica_cn'];
$homephone = $_POST['modifica_homephone_admin'];
$userpassword = $_POST['modifica_userpassword_admin'];
$voicemailpassword = $_POST['modifica_voicemailpassword_admin'];
$departmentNumber = $_POST['modifica_departmentNumber_admin'];
$mail = $_POST['modifica_mail_admin'];

if (check_all($mail,$cn,$homephone,$departmentNumber)) {

	$info = '';

	if (!empty($userpassword)) $info['userpassword'][0] = $userpassword;
	if (!empty($voicemailpassword)) $info['voicemailpassword'][0] = $voicemailpassword;
	$info['departmentNumber'][0] = $departmentNumber;
	$info['homephone'][0] = $homephone;
	$info['mail'][0] = $mail;
	
	include('conex.php');

	$admin = "cn=admin,dc=pxcso,dc=com";
	$pass = "LdapPassw01";
	
	if (ldap_bind($connect, $admin, $pass)) {	
		$base = "ou=usuarios,dc=pxcso,dc=com";
		if (ldap_modify($connect,"cn=$cn,$base",$info)) {
		
			if (!empty($userpassword)) {
				if (!empty($voicemailpassword)) 
					$string = 'moduser '.$cn.' '.$userpassword.' '.$voicemailpassword;
				else 
					$string = 'moduser '.$cn.' '.$userpassword.' 0';
			}
			else {
				if (!empty($voicemailpassword)) 
					$string = 'moduser '.$cn.' 0 '.$voicemailpassword;
				else 
					$string = 'moduser '.$cn.' 0 0';
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
}

?>
