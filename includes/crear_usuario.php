<?
include('control_sesion.php'); 
include_once('util.php');
$user = $_SESSION['user'];

$givenname = $_POST['givenname_admin'];
$sn = $_POST['sn_admin'];
$homephone = $_POST['homephone_admin'];
$userpassword = $_POST['userpassword_admin'];
$voicemailpassword = $_POST['voicemailpassword_admin'];
$departmentNumber = $_POST['departmentNumber_admin'];
$mail = $_POST['mail_admin'];

if (!empty($givenname)) $uid = $cn = super_clean_name($givenname).'.'.super_clean_name($sn);
else $uid = $cn = super_clean_name($sn);

if (check_all($mail,$cn,$homephone,$departmentNumber)) {

	$info = '';

	$info['objectclass'] = 'inetOrgPerson';
	
	/* sn es obligatorio, si no tiene, le ponemos cn */
	if ($sn == '') $info['sn'] = $cn;
	else $info['sn'][0] = super_clean_name($sn);

	/* givenName es obligatorio, si no tiene, le ponemos sn */
	if (empty($givenname)) $info['givenname'][0] = super_clean_name($sn);
	else $info['givenname'][0] = super_clean_name($givenname);
	
	$info['cn'][0] = $cn;
	$info['uid'][0] = $uid;
	$info['userpassword'][0] = $userpassword;
	$info['voicemailpassword'][0] = $voicemailpassword;
	$info['departmentNumber'][0] = $departmentNumber;
	$info['homephone'][0] = $homephone;
	$info['mail'][0] = $mail;
	
	include('conex.php');

	$admin = "cn=admin,dc=pxcso,dc=com";
	$pass = "LdapPassw01";
	
	if (ldap_bind($connect, $admin, $pass)) {	
		$base = "ou=usuarios,dc=pxcso,dc=com";
		$filter = "cn=$cn";
		$search = ldap_search($connect, $base, $filter);
		$data = ldap_get_entries($connect, $search);
		
		if (!empty($data[0]['cn'])) $search_cn = $data[0]['cn'][0];
		else $search_cn = '';
		
		if ($search_cn != $cn) {
			/* user */
			ldap_add($connect,"cn=$cn,$base",$info);
			
			/* ou-agenda */
			$agenda = '';
			$agenda['objectclass'] = 'organizationalunit';
			$agenda['description'] = 'Agenda de '.$info["givenname"][0];
			ldap_add($connect,"ou=$uid,ou=agenda,dc=pxcso,dc=com",$agenda);
			
			$string = 'adduser '.$info['cn'][0].' '.$info['userpassword'][0].' '.$info['voicemailpassword'][0].' '.$info['mail'][0];
			$fichero = '../asterisk_talk/add/'.$info['cn'][0];
			unlink($fichero);
			$fp = fopen($fichero, "w");
			fputs($fp, $string); 
			
			echo "El Contacto se ha Creado Correctamente";
		} else {
			echo "Error añadiendo a $cn porque ya existe un usuario con el mismo nombre completo.";
		}
	}
	else echo "Error de conexión";
}

?>
