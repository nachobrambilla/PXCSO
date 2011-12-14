<? include('../includes/buscar_datos_admin.php'); ?>
<link media="all" type="text/css" href="/css/data_table_includes.css" rel="stylesheet">
<link media="all" type="text/css" href="/css/contacto.style.css" rel="stylesheet">
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/js/dataTables.admin.includes.js"></script>
<script type="text/javascript" src="/js/jquey.form.js"></script>
<script type="text/javascript" src="/js/admin.validate.js"></script>

<div class="grid_2_3" id="cuerpo-admin">
<div class="demo">

<div id="dialog-admin" title="Crear" hidden>
	<form id="crear-admin">
	<fieldset>
		<input type="hidden" name="modifica-admin" id="modifica-admin" class="text ui-widget-content ui-corner-all" />
		<label for="givenname_admin">Nombre</label>
		<input type="text" name="givenname_admin" id="givenname_admin" class="text ui-widget-content ui-corner-all" />
		<label for="sn_admin">Apellidos</label>
		<input type="text" name="sn_admin" id="sn_admin" class="text ui-widget-content ui-corner-all" />
		<label for="userpassword_admin">Password</label>
		<input type="password" name="userpassword_admin" id="userpassword_admin" class="text ui-widget-content ui-corner-all" />
		<label for="confirma">Confirmar Password</label>
		<input type="password" name="confirma" id="confirma" class="text ui-widget-content ui-corner-all" />
		<label for="homephone_admin">Télefono</label>
		<input type="text" name="homephone_admin" id="homephone_admin" class="text ui-widget-content ui-corner-all" />
		<label for="mail_admin">Email</label>
		<input type="text" name="mail_admin" id="mail_admin" value="" class="text ui-widget-content ui-corner-all" />
		<label for="departmentNumber_admin">Tipo</label>
		<select name="departmentNumber_admin" id="departmentNumber_admin" class="select ui-widget-content ui-corner-all">
			<option value="1">admin</option>
			<option value="2" selected>cobrador</option>		
		</select>
		<label for="habilitado">Habilitado</label>
		<select name="habilitado" id="habilitado" class="select ui-widget-content ui-corner-all">
			<option value="1">Si</option>
			<option value="0">No</option>		
		</select>
	</fieldset>
	</form>
</div>

<div id="dialog-delete-admin" title="Borrar" hidden>
	<p>¿Desea Borrar al Cobrador?</p>
</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display">
		<tr>
			<td class="display-button"><p><input id="create-admin" type="button" value="Crear"></p></td>
			<td class="display-message mensajes"></td>
		</tr>
		<tr>
			<td colspan=2 >
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="cobradores" >
				<? if ($info['count']) { ?>
				<thead>
					<tr>
						<th>User</th>
						<th>Tipo</th>
						<th>Modificar</th>
						<th>Borrar</th>
					</tr>
				</thead>
				<tbody>
						<? foreach ($info as $value) { 
							if (!empty($value['cn'][0])) {?>
						<tr id="<?= $value['cn'][0]?>">
							<td><?= $value['cn'][0]; ?></td>
							<td><? if ($value['departmentnumber'][0] == "1") { echo "admin"; } else if ($value['departmentnumber'][0] == "2") { echo "cobrador"; } ?></td>
							<td><input type="button" value="Modificar" onclick="javascript:modificar_admin('<?=$value['cn'][0]?>')"></td>
							<td><input type="button" value="Borrar" onclick="javascript:borrar_admin('<?=$value['cn'][0]?>')"></td>
						</tr>
						<? } } ?>
					<? } else { ?>
						<tr>
							<td class="resaltar">No hay ningún contacto</td>
						</tr>
					<? } ?>
				</tbody>
				</table>
			</td>
		</tr>
	</table>
</div>
