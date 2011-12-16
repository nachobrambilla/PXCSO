<link media="all" type="text/css" href="/css/data_table_includes.css" rel="stylesheet">
<link media="all" type="text/css" href="/css/contacto.style.css" rel="stylesheet">

<? include('../includes/control_sesion.php'); 
include('../includes/buscar_habilitacion_usuario.php');
if ($asteriskdisabled == '0') {
	$fichero = '../asterisk_talk/log';
	if (!($fp = fopen($fichero, "r"))) {
		echo "Error abriendo el log. Quizás se está generando uno nuevo, actualice y pruebe de nuevo.";
		die();
	}
	$log = fread($fp,filesize($fichero));
	
	$todo = explode("\n",$log);
	
	foreach ($todo as $valor) {
		$linia = explode(" ",$valor);
		if ($linia[1] == 'adduser' || $linia[1] == 'moduser') {
			$linia[3] = 'PASS';
			$linia[4] = 'PASS_VOICE';
		}
		foreach ($linia as $salida) 
			echo nl2br($salida)." ";
			
		echo "<br>";
	}
}
else echo "Página inexistente";

?>
