<? include('../includes/buscar_extensiones_cobrador.php'); ?>
<link media="all" type="text/css" href="/css/data_table_includes.css" rel="stylesheet">
<link media="all" type="text/css" href="/css/extensiones.style.css" rel="stylesheet">
<link media="all" type="text/css" href="/css/jquery.ui.timepicker.css" rel="stylesheet">
<script type="text/javascript" src="/js/jquery.ui.timepicker.js"></script>
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/js/dataTables.extensiones.includes.js"></script>
<script type="text/javascript" src="/js/extensiones.validate.js"></script>
<script type="text/javascript" src="/js/jquey.form.js"></script>
<div class="grid_2_3" id="cuerpo2">
<form name="ext" id="ext" method="POST">	
<div class="demo">

	<table cellpadding="0" cellspacing="0" border="0" class="display">
		<tr>
			<td>
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="extensiones" >
				
				<thead>
					<tr>
						<th>Número</th>
						<th>Habilitada</th>
						<th>Horario</th>
						<th>Foward</th>
						<th>Teléfono Movil</th>
					</tr>
				</thead>		
				<tbody>
						<? $i = 0; ?>
						<? foreach ($extensions as $extension) { ?>
						<? $extension = explode(",", $extension);?>
						<tr>
							<td><input type="hidden" name="<?= $extension[0]; ?>_num" value="<?= $extension[0]; ?>"><?= $extension[0]; ?></td>
							<td><select name="<?= $extension[0]; ?>_hab">
								<option value="0" <? if ($extension[1] == "0") echo "selected"; ?>>No</option>
							   <option value="1" <? if ($extension[1] == "1") echo "selected"; ?>>Si</option>
							   </select>
							</td>
							<td><input type="text" name="<?= $extension[0]; ?>_horaBeg" value="<?= $extension[2]; ?>" class="timepicker"> a <input type="text" name="<?= $extension[0]; ?>_horaEnd" value="<?= $extension[3]; ?>" class="timepicker"></td>
							<td><select name="<?= $extension[0]; ?>_fow">
								<option value="000">VoiceMail</option>
								<? for($j=$beg;  $j<$beg+10; $j++) { ?>
									<? if($j != $extension[0]) { ?>
								<option value="<?=$j;?>" <? if ($extension[4] == $j) echo "selected"; ?>><?=$j;?></option>
									<? } ?>
								<? } ?>							
							</select></td>
							<td><select name="<?= $extension[0]; ?>_nat">
								<option value="0" <? if ($extension[5] == "0") echo "selected"; ?>>No</option>
							   <option value="1" <? if ($extension[5] == "1") echo "selected"; ?>>Si</option>
							   </select>
							</td>
						</tr>
						<? $i=+2 ;?>
						<? } ?>
				</tbody>
				</table>
			</td>
		</tr>	
	</table>
</div>
<input type="button" id="guardarext" name="guardarext" value="Guardar Cambios">
<span id="msn-ext" class="mensajes"></span>
</form>
