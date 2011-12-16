<?
include('control_sesion.php');
include('conex.php');

function myldap_delete($ds,$dn,$recursive=true){
    if($recursive == false){
        return(ldap_delete($ds,$dn));
    }else{
        $sr=ldap_list($ds,$dn,"ObjectClass=*",array(""));
        var_dump($sr);
        $info = ldap_get_entries($ds, $sr);
        for($i=0;$i<$info['count'];$i++){
            $result=myldap_delete($ds,$info[$i]['dn'],$recursive);
            if(!$result){
                return($result);
            }
        }
        return(ldap_delete($ds,$dn));
    }
}

if (!empty($_POST['cn'])) { 
	$cn = $_POST['cn'];
	$user = $_SESSION['user'];

	$admin = "cn=admin,dc=pxcso,dc=com";
	$pass = "LdapPassw01";
	
	if (ldap_bind($connect, $admin, $pass)) {
	
		$base = "ou=usuarios,dc=pxcso,dc=com";
		try {
			if(ldap_delete($connect,"cn=$cn,$base")) {
			
				if(myldap_delete($connect,"ou=$cn,ou=agenda,dc=pxcso,dc=com")) {
				
					$string = "deluser ".$cn."\n";
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
