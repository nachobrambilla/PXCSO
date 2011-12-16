<?
include('control_sesion.php'); 
$user = $_SESSION['user'];
$name = $_POST['givenname'];
$sn = $_POST['sn'];
$postaladdress = $_POST['postaladdress'];
$homephone = $_POST['homephone'];
$mobile = $_POST['mobile'];
$modifica = $_POST['modifica'];
$telephonenumber = $_POST['telephonenumber'];
$mail = $_POST['contacto_mail'];
$mail2 = $_POST['contacto_mail2'];

if ($name != '') $cn = $name.' '.$sn;
else $cn = $sn;

include_once('util.php');

if (check_all($mail,$cn,$homephone,$mobile)) {

	$info = '';

	$info['objectclass'] = 'inetOrgPerson';
	
	/* sn es obligatorio, si no tiene, le ponemos cn */
	if ($sn == '') $info['sn'] = clean_name($cn);
	else $info['sn'][0] = clean_name($sn);

	/* givenName es obligatorio, si no tiene, le ponemos sn */
	if ($name == '') $info['givenname'][0] = clean_name($sn);
	else $info['givenname'][0] = clean_name($name);
	
	$my_cn = clean_name($cn);
	if ($my_cn != '') $info['cn'][0] = $my_cn;
	if ($postaladdress != '') $info['postaladdress'][0] = $postaladdress;
	if ($homephone != '') $info['homephone'][0] = $homephone;
	if ($mobile != '') $info['mobile'][0] = $mobile;
	if ($telephonenumber != '') $info['telephonenumber'][0] = $telephonenumber;
	if ($mail != '') $info['mail'][0] = $mail;
	if ($mail2 != '') $info['mail'][1] = $mail2;
	
	include('conex.php');

	$admin = "cn=admin,dc=pxcso,dc=com";
	$pass = "LdapPassw01";
	
	if (ldap_bind($connect, $admin, $pass)) {	
		if (!empty($modifica)) {
			ldap_delete($connect,"cn=$modifica,ou=$user,ou=agenda,dc=pxcso,dc=com");
			ldap_add($connect,"cn=$my_cn,ou=$user,ou=agenda,dc=pxcso,dc=com",$info);
			echo "El Contacto se ha Modificado Correctamente";						
		} else {
			$base = "ou=" . $_SESSION['user'] . ",ou=agenda,dc=pxcso,dc=com";
			$filter = "cn=$my_cn";
			$search = ldap_search($connect, $base, $filter);
			$data = ldap_get_entries($connect, $search);
			$search_cn = $data[0]['cn'][0];
			if ($search_cn != $my_cn) {
				ldap_add($connect,"cn=$my_cn,ou=$user,ou=agenda,dc=pxcso,dc=com",$info);
				echo "El Contacto se ha Creado Correctamente";
			} else {
				echo "Error añadiendo a $my_cn porque ya existe un contacto con el mismo nombre completo.";
			}
		}
	}
	else echo "Error de conexión";
}

?>
