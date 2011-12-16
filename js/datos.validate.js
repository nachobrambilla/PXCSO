$(document).ready(function() { 
$('#modificar').click(function() {
	$("#cobrador").validate({ 
		rules: { 
			nombre: "required",
			apellido1: "required",     
			telefono: {              
				required: true, 
				number: true
			}, 
			password: "required",
			passwordconfirm: {              
				equalTo: "#password" 
			}, 
			voiceMailPassword: {
				required: true,
				number: true,
				rangelength: [4, 4]  
			}, 
			voiceMailPasswordConfirm: {              
				equalTo: "#voiceMailPassword" 
			} 
		}, 
		messages: {
			nombre: "<br><span class='mensajes'>El nombre es obligatorio.</span>",
			apellido1: "<br><span class='mensajes'>El apellido es obligatorio.</span>", 
			telefono: {              
				required: "<br><span class='mensajes'>El teléfono es obligatorio.</span>",
				number: "<br><span class='mensajes'>El teléfono debe ser un número.</span>" 
			},
			password: "<br><span class='mensajes'>El password es obligatorio.</span>", 
			passwordconfirm: {              
				equalTo: "<br><span class='mensajes'>Los passwords deben ser iguales.</span>" 
			},
			voiceMailPassword: { 
				required: "<br><span class='mensajes'>El password de Voice Mail es obligatorio.</span>",
				number: "<br><span class='mensajes'>El password de e Voice Mail debe ser un número de 4 dígitos.</span>",
				rangelength: "<br><span class='mensajes'>El password de e Voice Mail debe ser un número de 4 dígitos.</span>"
			},
			voiceMailPasswordConfirm: {              
				equalTo: "<br><span class='mensajes'>Los passwords deben ser iguales.</span>" 
			}
		} 
	});
	if ( $("#cobrador").valid() ) {
		$("#msn-datos").html("");
		$.post('/includes/modificar_datos_cobrador.php', $("#cobrador").serialize(), function(datos) {
			$("#msn-datos").html(datos);
		});
	}
});
}); 
