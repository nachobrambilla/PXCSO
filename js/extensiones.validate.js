$(document).ready(function() {
	$('#guardarext').click(function() {
		$("#msn-ext").html("");
		
		var i;
		for (i = 0; i < 10; ++i) {
			
			if ($("#beg_"+i).val() != '' || $("#end_"+i).val() != '') {
				valores = $("#beg_"+i).val().split(':');
				end = $("#end_"+i).val().split(':');
			
				if (!(valores[0] >= '00' && valores[0] < '24' && valores[1] >= '00' && valores[1] < '60' && end[0] >= '00' && end[0] < '24' && end[1] >= '00' && end[1] < '60')) {
					$("#msn-ext").html("Tiene algún horario con una mala sintaxis");
					return;
				}
			}
		}
			
		$.post('/includes/modificar_extensiones_cobrador.php', $("#ext").serialize(), function(datos) {
			$("#msn-ext").html(datos);
		});	
	});
});
