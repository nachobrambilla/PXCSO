<? include('../includes/control_sesion.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>El Cobrador del Frac</title>
	<meta charset="utf-8">
	<link media="all" type="text/css" href="/css/jquery-ui.css" rel="stylesheet">
	<link media="all" type="text/css" href="/css/ui.theme.css" rel="stylesheet">
	<link media="all" type="text/css" href="/css/styles.css" rel="stylesheet">	
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery-ui.min.js"></script>	
	<script type="text/javascript" src="/js/tabs.js"></script>
</head>	

<body>
	<div id="tabs">
		<? require('../includes/header.php'); ?>
		<ul>
			<li><a href="datos.php">Datos</a></li>
			<?
			include('../includes/buscar_habilitacion_usuario.php'); 
			if ($asteriskdisabled == '0') {?><li><a href="extensiones.php">Extensiones</a></li><?}?>
			<li><a href="agenda.php">Agenda</a></li>
			<? if ($_SESSION["department"] == "admin") { ?><li><a href="admin.php">Admin</a></li><li><a href="log.php">Log</a></li><? }; ?>
		</ul>
	</div>
</body>
