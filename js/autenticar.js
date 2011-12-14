$(document).ready(function() {
	$('#entrar').click(function() {
		$('#autenticar').validate({
			rules: {
				user: "required",
				pass: "required"
			},
			messages: {
				user: "<span class='mensajes'>campo obligatorio</span>",
				pass: "<span class='mensajes'>campo obligatorio</span>"
			}
		});
				
		if ( $("#autenticar").valid() ) {
			$.post('/includes/autenticar.php', $("#autenticar").serialize(), function(datos) {
				if (datos == "OK") window.location.replace("/cobrador/cobrador.php");	
				else $("#message").html(datos);		
			}
		)};
	});
});
