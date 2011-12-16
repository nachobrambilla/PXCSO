<? include('../includes/control_sesion.php'); ?> 
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>	
<script type="text/javascript" src="/js/datos.validate.js"></script>

<form id="cobrador" method="POST">
	<table class="tablacobrador">	
		<tr>
			<td><label>Nombre: </label></td>
			<td><?= $_SESSION['nombre']; ?></td>
			<td><label>Apellidos: </label></td>
			<td><?= $_SESSION['apellidos']; ?></td>
			<td></td>
			<td></td>
 		</tr>
		<tr>
			<td><label>*Email: </label></td>
			<td><?= $_SESSION['mail']; ?></td>
			<td><label>*Extensión: </label></td>
			<td><?= $_SESSION['telefono']; ?></td>
			<td colspan=2 rowspan=5 class="logotd"><img src="/img/logo.jpg" class="logoimg" /></td>
 		</tr>
		<tr>
			<td><label>*Password: </td>
			<td><input name="password" id="password" type="password" value ="<?= $_SESSION['pass']; ?>"></label></td>
			<td><label>*Confirmar Password: </td>
			<td><input name="passwordconfirm" id="passwordconfirm" type="password"  value ="<?= $_SESSION['pass']; ?>"></label></td>
 		</tr>
		<tr>
			<td><label>*Password Voice Mail: </td>
			<td><input name="voiceMailPassword" id="voiceMailPassword" type="password" value ="<?= $_SESSION['voiceMailPassword']; ?>"></label></td>
			<td><label>*Confirmar Password Voice Mail: </td>
			<td><input name="voiceMailPasswordConfirm" id="voiceMailPasswordConfirm" type="password"  value ="<?= $_SESSION['voiceMailPassword']; ?>"></label></td>
 		</tr>
		<tr>		
			<td class="letrachica" colspan=4>* campos obligatorios</td>
		</tr>
		<tr>		
			<td class="lastrow"><input type="button" id="modificar" value="Modificar Datos"></td>
			<td id="msn-datos" class="lastrow mensajes" colspan=3></td>
		</tr>
	</table>
</form>
