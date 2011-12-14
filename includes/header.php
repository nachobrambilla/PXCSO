<div id="dialog-confirm" title="Cerrar Sesión">
	<p>¿Desea Cerrar la Sesión?</p>
</div>

<form id="sesion" name="sesion">
	<table class="sesion">
		<tr>
			<td>Sesión de: <span class="resaltar" ><?= $_SESSION['nombre'] . " " . $_SESSION['apellidos'] . " (" . $_SESSION['department']  . ")"; ?></span></td>
			<td class="sesionboton"><input type="submit" value="Cerrar Sesión" /> 
		</tr>
	</table>
</form>
	
