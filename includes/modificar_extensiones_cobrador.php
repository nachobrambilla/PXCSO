<?
include('control_sesion.php');
include('conex.php');
$extensions = "";
$i=0;
$count = 0;
$string_extensiones = "extension ";
foreach($_POST as $value) {
	$extensions .= $value;
	if ($i == 1) {
		if ($value == 1) $string_extensiones .= "si";
		else $string_extensiones .= "no";
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
		if ($value == 1) $string_extensiones .= "si";
		else $string_extensiones .= "no";
		if ($count < 59) $string_extensiones .= "\nextension ";
		$extensions .= ";";
	}
	else {
		$string_extensiones .= $value;
		$extensions .= ",";
		$string_extensiones .= " ";
	}
	$i++;
	if ($i == 6) $i = 0;
	++$count;
}
$string_extensiones .= "\n";

if ($connect) { 
	$user = "cn=admin,dc=pxcso,dc=com";
	$pass = "LdapPassw01";
	$bind = ldap_bind($connect, $user, $pass);
   if ($bind) {
   		$cn = strtolower($_SESSION['user']);
   
		$base = "cn=" . $_SESSION['user'] . ",ou=usuarios,dc=pxcso,dc=com";
		$info['extensions'][0] = $extensions;
		if (ldap_modify($connect, $base,  $info)) {
			$fichero = '../asterisk_talk/ext/'.$cn.'_0';
			unlink($fichero);
			$fp = fopen($fichero, "w");
			fputs($fp, $string_extensiones);
			
			$fichero = '../asterisk_talk/ext/'.$cn.'_1';
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
