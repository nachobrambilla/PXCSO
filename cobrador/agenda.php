<? include('../includes/buscar_contactos_agenda.php'); ?>
<link media="all" type="text/css" href="/css/data_table_includes.css" rel="stylesheet">
<link media="all" type="text/css" href="/css/contacto.style.css" rel="stylesheet">
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/js/dataTables.agenda.includes.js"></script>
<script type="text/javascript" src="/js/jquey.form.js"></script>
<script type="text/javascript" src="/js/swfobject.js"></script>
<script type="text/javascript" src="/js/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="/js/contacto.validate.js"></script>

<div class="grid_2_3" id="cuerpo">
<div class="demo">

<div id="dialog-form" title="Crear Contacto" hidden>
	<form id="contacto">
	<fieldset>
		<input type="hidden" name="modifica" id="modifica" class="text ui-widget-content ui-corner-all" />
		<label for="givenname">Nombre</label>
		<input type="text" name="givenname" id="givenname" class="text ui-widget-content ui-corner-all" />
		<label for="sn">Apellidos</label>
		<input type="text" name="sn" id="sn" class="text ui-widget-content ui-corner-all" />
		<label for="postaladdress">Dirección</label>
		<input type="text" name="postaladdress" id="postaladdress" class="text ui-widget-content ui-corner-all" />
		<label for="mobile">Télefono</label>
		<input type="text" name="mobile" id="mobile" class="text ui-widget-content ui-corner-all" />
		<label for="homephone">Teléfono 2</label>
		<input type="text" name="homephone" id="homephone" value="" class="text ui-widget-content ui-corner-all" />
		<label for="telephonenumber">Otro Teléfono</label>
		<input type="text" name="telephonenumber" id="telephonenumber" value="" class="text ui-widget-content ui-corner-all" />
		<label for="contacto_mail">Email</label>
		<input type="text" name="contacto_mail" id="contacto_mail" value="" class="text ui-widget-content ui-corner-all" />
		<label for="contacto_mail2">Email Secundario</label>
		<input type="text" name="contacto_mail2" id="contacto_mail2" value="" class="text ui-widget-content ui-corner-all" />
	</fieldset>
	</form>
</div>

<div id="dialog-delete" title="Borrar Contacto" hidden>
	<p>¿Desea Borrar el Contacto?</p>
</div>

	<table cellpadding="0" cellspacing="0" border="0" class="display">
		<tr>
			<td class="display-button"><p><input id="create-user" type="button" value="Crear Contacto"></p></td>
			<td class="display-message mensajes"></td>
		</tr>
		<tr>
			<td colspan=2 >
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
				<? if ($info['count']) { ?>
				<thead>
					<tr>
						<th>Apellidos</th>
						<th>Nombre</th>
						<th>Tel&eacute;fono</th>
						<th>Modificar</th>
						<th>Borrar</th>
					</tr>
				</thead>
				<tbody>
						<? foreach ($info as $value) { 
							if (!empty($value['cn'][0])) {?>
						<tr id="<?= $value['cn'][0]?>">
							<td><?= $value['sn'][0]; ?></td>
							<td><?= $value['givenname'][0]; ?></td>
							<td><? if(isset($value['mobile'][0])) echo $value['mobile'][0]; ?></td>
							<td><input type="button" value="Modificar" onclick="javascript:modificar('<?=$value['cn'][0]?>')"></td>
							<td><input type="button" value="Borrar" onclick="javascript:borrar('<?=$value['cn'][0]?>')"></td>
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
		<tr>
			<td colspan=2><p><p>Suba una lista de contactos en CSV</p>
					<input type="hidden" size="25" name="mensaje" id="mitexto" value="<?=$_SESSION['user']?>" />
					<input type="file" name="fileInput" id="fileInput" />
					<div id="fotosWrapper"></div>
				</p>
			</td>
		</tr>
	</table>
</div>
