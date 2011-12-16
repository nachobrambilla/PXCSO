<?
include('control_sesion.php'); 
include_once('util.php');
$user = $_SESSION['user'];

$givenname = $_POST['givenname_admin'];
$sn = $_POST['sn_admin'];
$userpassword = $_POST['userpassword_admin'];
$voicemailpassword = $_POST['voicemailpassword_admin'];
$departmentNumber = $_POST['departmentNumber_admin'];
$mail = $_POST['mail_admin'];
$habilitado = $_POST['habilitado'];

if (!empty($givenname)) $uid = $cn = super_clean_name($givenname).'.'.super_clean_name($sn);
else $uid = $cn = super_clean_name($sn);

if (check_all($mail,$cn,$departmentNumber,$departmentNumber)) { // regular

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
	$info['mail'][0] = $mail;
	
	$fichero_extensiones = '../asterisk_talk/actual_ext';
	$fp = fopen($fichero_extensiones, "r");
	if ($fp != -1) {
		$extension_disponible = fread($fp,filesize($fichero_extensiones));
		if (!empty($extension_disponible)) {
		
			if(!buscar_extension(intval($extension_disponible))) {
				$info['homephone'] = intval($extension_disponible);
				$extensions = '';
			
				$final = intval($extension_disponible);
				for ($i = $final; $i < ($final + 10); ++$i)
					$extensions .= $i.',0,,,000,0;';
				
				$info['extensions'] = $extensions;
			
			}
			else {echo "Error creando el usuario, la extensión ya está siendo utilizada. Espere un minuto para que se genera una nueva extensión disponible.";die();}

		}
		else {echo "Error leyendo la última extensión disponible [1]";die();}
	}
	else {echo "Error leyendo la última extensión disponible [2]";die();}
	
	include('conex.php');

	$admin = "cn=admin,dc=pxcso,dc=com";
	$pass = "LdapPassw01";
	
	if (ldap_bind($connect, $admin, $pass)) {	
	
		$cn = strtolower($cn);
	
		if ($habilitado == '1') {
			$string_habilitar = "enable ".$cn."\n";
			$info['asteriskdisabled'] = '0';
		}
		else {
			$string_habilitar = "disable ".$cn."\n";
			$info['asteriskdisabled'] = '1';
		}
		
		
	
		/* user */
		$base = "ou=usuarios,dc=pxcso,dc=com";
		if (ldap_add($connect,"cn=$cn,$base",$info)) {

			$fichero_habilitar = '../asterisk_talk/ena/'.$cn;
			unlink($fichero_habilitar);
			$fp_habilitar = fopen($fichero_habilitar, "w");
			fputs($fp_habilitar, $string_habilitar); 
		
			/* ou-agenda */
			$agenda = '';
			$agenda['objectclass'] = 'organizationalunit';
			$agenda['description'] = 'Agenda de '.$info["givenname"][0];
			
			$string = "adduser ".$cn." ".$info['userpassword'][0]." ".$info['voicemailpassword'][0]." ".$info['mail'][0]."\n";
			$fichero = '../asterisk_talk/add/'.$cn;
			unlink($fichero);
			$fp = fopen($fichero, "w");
			fputs($fp, $string);
			
			if (ldap_add($connect,"ou=$uid,ou=agenda,dc=pxcso,dc=com",$agenda)) echo "El usuario se ha creado correctamente";
			else {
				if (ldap_err2str(ldap_errno($connect)) == 'Already exists') "Se ha detectado que el usuario tenía una agenda. Si el usuario funciona correctamente, no se preocupe; si no, deberá BORRAR el usuario y volverlo a crear";
				else echo "Ha habido algún error añadiendo al usuario [1]";
			}
		}
		else {
			if (ldap_err2str(ldap_errno($connect)) == 'Already exists') echo "Error añadiendo a $cn porque ya existe un usuario con el mismo nombre completo. <br />";
			else echo "Ha habido algún error añadiendo al usuario [2]";
		}
	}
	else echo "Error de conexión";
}

?>
