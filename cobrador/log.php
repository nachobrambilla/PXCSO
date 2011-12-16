<link media="all" type="text/css" href="/css/data_table_includes.css" rel="stylesheet">
<link media="all" type="text/css" href="/css/contacto.style.css" rel="stylesheet">

<?
$fichero = '../asterisk_talk/log';
$fp = fopen($fichero, "r");
$log = fread($fp,filesize($fichero));
echo nl2br($log);
?>
