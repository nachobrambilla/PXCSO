$(document).ready(function() {
	$('#guardarext').click(function() {
		$("#msn-ext").html("");		
		$.post('/includes/modificar_extensiones_cobrador.php', $("#ext").serialize(), function(datos) {
			$("#msn-ext").html(datos);
		});	
	});
});