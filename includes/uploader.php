<?php
error_reporting(0);

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$file_name = $_FILES['Filedata']['name'];	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	
	if (!file_exists ($targetPath)) mkdir($targetPath,0700); /* Creamos upload_cvs */
	
	$user = $_POST['texto'];
	$targetPath .= $user.'/';
	$targetFile =  str_replace('//','/',$targetPath) . $file_name;	
	
	if (!file_exists ($targetPath)) mkdir($targetPath,0700); /* Creamos upload_cvs/$user */
	
	if (move_uploaded_file($tempFile,$targetFile)) {
	
		if (($gestor = fopen($targetFile, 'r')) !== FALSE) {

			include('../includes/conex.php');

			$admin = "cn=admin,dc=pxcso,dc=com";
			$pass = "LdapPassw01";
			if (ldap_bind($connect, $admin, $pass)) {
				$datos = fgetcsv($gestor, 2000, ','); // Quitamos la primera línea
				$contador = 0;
				
				while (($datos = fgetcsv($gestor, 2000, ',')) !== FALSE) {
					$homephone = $mobile = '';

					$name = $datos[0];
					$middle = $datos[1];
					$sn = $datos[2];
					$mail = $datos[14];

					$cn = $name;
					if ($name != '') $givenName = ($cn .= ' '.$middle);
					else $givenName = ($cn .= $middle);
					if ($middle != '') $cn .= ' '.$sn;
					else $cn .= $sn;

					if ($datos[17] != '') $homephone = $datos[17];
					else if ($datos[18] != '') $homephone = $datos[18];
					else if ($datos[19] != '') $homephone = $datos[19];
					else if ($datos[20] != '') $homephone = $datos[20];
					else if ($datos[37] != '') $homephone = $datos[37];
					else if ($datos[38] != '') $homephone = $datos[38];
					else if ($datos[39] != '') $homephone = $datos[39];
					else if ($datos[58] != '') $homephone = $datos[58];
					else if ($datos[70] != '') $homephone = $datos[70];
					else if ($datos[72] != '') $homephone = $datos[72];
					else if ($datos[73] != '') $homephone = $datos[73];

					if ($datos[17] != '' && $datos[17] != $homephone) $mobile = $datos[17];
					else if ($datos[18] != '' && $datos[18] != $homephone) $mobile = $datos[18];
					else if ($datos[19] != '' && $datos[19] != $homephone) $mobile = $datos[19];
					else if ($datos[20] != '' && $datos[20] != $homephone) $mobile = $datos[20];
					else if ($datos[37] != '' && $datos[37] != $homephone) $mobile = $datos[37];
					else if ($datos[38] != '' && $datos[38] != $homephone) $mobile = $datos[38];
					else if ($datos[39] != '' && $datos[39] != $homephone) $mobile = $datos[39];
					else if ($datos[58] != '' && $datos[58] != $homephone) $mobile = $datos[58];
					else if ($datos[70] != '' && $datos[70] != $homephone) $mobile = $datos[70];
					else if ($datos[72] != '' && $datos[72] != $homephone) $mobile = $datos[72];
					else if ($datos[73] != '' && $datos[73] != $homephone) $mobile = $datos[73];

					include_once('../includes/util.php');

					if (check_all($mail,$cn,$homephone,$mobile)) {

						$info = '';

						$info['objectclass'] = 'inetOrgPerson';

						/* sn es obligatorio, si no tiene, le ponemos cn */
						if ($sn == '') $info['sn'] = clean_name($cn);
						else $info['sn'] = clean_name($sn);

						/* givenName es obligatorio, si no tiene, le ponemos sn */
						if ($givenName == '') $info['givenName'] = clean_name($sn);
						else $info['givenName'] = clean_name($givenName);

						if ($homephone != '') $info['homephone'] = $homephone;
						if ($mobile != '') $info['mobile'] = $mobile;
						if ($mail != '') $info['mail'] = $mail;

						$my_cn = clean_name($cn);

						try {
							if(ldap_add($connect,"cn=$my_cn,ou=$user,ou=agenda,dc=pxcso,dc=com",$info)) ++$contador;
						}
						catch (ErrorException $e) {
							if (ldap_err2str(ldap_errno($connect)) == 'Already exists') 
								echo "Error añadiendo a $cn porque ya existe un contacto con el mismo nombre completo. <br />";
							else "Error añadiendo a $cn .<br>";
						}
					}
								
				}
				ldap_close($connect); 
				fclose($gestor);

				echo "<br>Se han importado $contador contactos con éxito.<br>";

			}
			else echo 'Error de conexión';
		}
		
	}
	else echo 'Tu archivo falló';
	
	unlink($targetFile);
	rmdir($targetPath);
}
?>
