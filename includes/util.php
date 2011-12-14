<?
function clean_name($toClean) {
	$normalize = array(
		''=>'S', ''=>'s', 'Ð'=>'Dj',''=>'Z', ''=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
		'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
		'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
		'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
		'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
		'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
		'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', ''=>'f', 'º'=>'o', 'ª'=>'a',
	);
	
    $toClean = strtr($toClean, $normalize);
    return trim(preg_replace('/[^\w\d_ -]/si', '', $toClean));
}

function super_clean_name($toClean) {
	$normalize = array(
		''=>'S', ''=>'s', 'Ð'=>'Dj',''=>'Z', ''=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
		'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
		'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
		'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
		'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
		'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
		'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', ''=>'f', 'º'=>'o', 'ª'=>'a', ' '=>'-',
	);
	
    $toClean = strtr($toClean, $normalize);
    return trim(preg_replace('/[^\w\d_ -]/si', '', $toClean));
}

/* Devuelve cierto si es correcto, o falso si no lo es */
function check_email_address($email) {
	return (preg_match('/^[^0-9][a-zA-Z0-9_+\-.]+([.][a-zA-Z0-9_+.]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email));
}

function check_name($name) {
//	return (preg_match('/[^a-zñÑáéíóúàèòâêîûôÁÉÍÓÚÀÈÌÒÙÂÊÎÔÛäëïöüÄËÏÖÜªº.çÇ ]/i', $name) == 0);
// 	El código anterior podría no hacer falta, ya que en clean_name se sustituye todo.
	return true;
}

function check_phone($phone) {
	return (preg_match('/[^0-9+]/i', $phone) == 0);
}

function check_all($mail,$cn,$homephone,$mobile) {
	$error = 0;
	
	if ($cn == '') {$error = 1; echo "Debe ingrear nombre y/o apellido como mínimo para el contacto con teléfono (si tiene) $homephone o correo (si tiene) $mail <br />";}
	else if ($mail != '' && !check_email_address($mail)) {$error = 1; echo "El correo electrónico ($mail) no es válido<br />";}
	else if (!check_name($cn)) {$error = 1; echo "El nombre ($cn) no es válido<br />";}
	else if ($homephone != '' && !check_phone($homephone)) {$error = 1; echo "El primer teléfono ($homephone) no es válido<br />";}
	else if ($mobile != '' && !check_phone($mobile)) {$error = 1; echo "El segundo teléfono ($mobile) no es válido<br />";}
	else if ($mail == '' && $homephone == '') {$error = 1; echo "El contacto $cn debe tener teléfono o correo electrónico<br />";}
	
	return ($error == 0);
}
?>
