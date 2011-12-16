<?
include('conex.php');
$cn = $_SESSION['user'];

if ($connect) { 
	$user = "cn=" . $_SESSION['user'] . ",ou=usuarios,dc=pxcso,dc=com";
	$pass = $_SESSION['pass'];
    $bind = ldap_bind($connect, $user, $pass);
    if ($bind) {
		$base = "ou=usuarios,dc=pxcso,dc=com";
		$filter = "cn=$cn";
		$search = ldap_search($connect, $base, $filter);
		$data = ldap_get_entries($connect, $search);
		
		if ($data[0]['asteriskdisabled'][0] == '0') $asteriskdisabled = '0';
		else $asteriskdisabled = '1';
	}
}
ldap_close($connect);
?>
