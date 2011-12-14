<?
include('control_sesion.php');
include('conex.php');
error_reporting(1);
$extensions = "";
$i=0;
$string_extensiones = "extension ";
foreach($_POST as $value) {
	$extensions .= $value;
	if ($i == 1) {
		if ($value == 1) $string_extensiones .= "SI";
		else $string_extensiones .= "NO";
		$extensions .= ",";
		$string_extensiones .= " ";
	}
	else if ($i == 2 || $i == 3) {
		if (empty($value)) $string_extensiones .= "XX:XX";
		else $string_extensiones .= $value;
		$extensions .= ",";
		$string_extensiones .= " ";
	}
	else if ($i == 5) {
		if ($value == 1) $string_extensiones .= "SI";
		else $string_extensiones .= "NO";
		$string_extensiones .= "\nextension ";
		$extensions .= ";";
	}
	else {
		$string_extensiones .= $value;
		$extensions .= ",";
		$string_extensiones .= " ";
	}
	$i++;
	if ($i == 6) $i = 0;
}

if ($connect) { 
	$user = "cn=admin,dc=pxcso,dc=com";
	$pass = "LdapPassw01";
	$bind = ldap_bind($connect, $user, $pass);
   if ($bind) {
		$base = "cn=" . $_SESSION['user'] . ",ou=usuarios,dc=pxcso,dc=com";
		$info['extensions'][0] = $extensions;
		if (ldap_modify($connect, $base,  $info)) {
			$fichero = '../asterisk_talk/ext/'.$_SESSION['user'];
			unlink($fichero);
			$fp = fopen($fichero, "w");
			fputs($fp, $string_extensiones); 
		
			echo "Extensiones modificadas correctamente";
		}
		else echo "Ha habido un error modificando las extensiones";
	}
	else{
		echo "Cobrador no identificado. Comuniquese con el administrador";	
	}
}
else {
	echo "No se pudo conectar con el servidor LDAP. Comuniquese con el administrador"; 
}
ldap_close($connect);
?>
