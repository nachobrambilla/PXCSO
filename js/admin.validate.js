function modificar_admin (mycn) {
	$("#ui-dialog-title-dialog-admin").html("Modificar");	
	$.post('/includes/buscar_contacto_agenda.php', { cn: mycn }, function(datos) {
		datos = $.parseJSON(datos);
		$('#modifica_admin').val(mycn);
		$('#givenname_admin').hide();
		$('#sn_admin').hide();
		$('#userpassword_admin').val(datos.givenname);
		$('#homephone_admin').val(datos.homephone);
		$('#departmentNumber_admin').val(datos.mail);
		$('#mail_admin').val(datos.mail);
	});
	$( "#dialog-admin" ).dialog( "open" );
}

function borrar_admin (mycn) {
	$( "#dialog-delete-admin" ).data('mycn', mycn).dialog( "open" );
}


$(document).ready(function() {

	$( "#create-admin" ).click(function() {
		$("#ui-dialog-title-dialog-admin").html("Crear");
		$( "#dialog-admin" ).dialog( "open" );
	});
	
	
	$( "#dialog-admin" ).dialog({
		autoOpen: false,
		height: 600,
		width: 350,
		modal: true,
		buttons: {
			"Continuar" : function() {
				$("#crear-admin").validate({
					rules: {
						givenname_admin: "required",
						sn_admin: "required",
						mail_admin: {
							required: true,
							email: true
						},
						userpassword_admin: "required",
						confirma_admin: {
							equalTo: "#userpassword_admin"
						}, 
						homephone_admin: {
							require: true,
							number: true					
						},
						userpasswordvm: {
							required: true,
							number: true,
							rangelength: [4, 4]  
						}, 
						confirmavm: {              
							equalTo: "#userpasswordvm" 
						} 
					},
					messages: {
						givenname_admin: "<span class='mensajes'>El nombre es obligatorio.</span>",
						sn_admin: "<span class='mensajes'>El apellido es obligatorio.</span>",
						mail_admin: {
							required: "<span class='mensajes'>El email es obligatorio.</span>",
							email: "<span class='mensajes'>El email debe ser válido.<span>"
						},
						userpassword_admin: "<span class='mensajes'>El password es obligatorio.</span>",
						confirma_admin: "<span class='mensajes'>Los passwords deben ser iguales.</span>"
					},
					homephone_admin: {
						require: "<span class='mensajes'>El teléfono es obligatorio.</span>",
						number: "<span class='mensajes'>El teléfono debe ser un número.</span>"					
					},
					userpasswordvm: { 
						required: "<br><span class='mensajes'>El password de Voice Mail es obligatorio.</span>",
						number: "<br><span class='mensajes'>El password de e Voice Mail debe ser un número de 4 dígitos.</span>",
						rangelength: "<br><span class='mensajes'>El password de e Voice Mail debe ser un número de 4 dígitos.</span>"
					},
					confirmavm: {              
						equalTo: "<br><span class='mensajes'>Los passwords deben ser iguales.</span>" 
					}
				});
		
				if ( $("#crear-admin").valid() ) {
					var global_datos;
					$.post('/includes/crear_usuario.php', $("#crear-admin").serialize(), function(datos) {
						global_datos = datos;
					});
					$('#cuerpo-admin').load('/cobrador/admin.php',function() {
						$(".display-message").html(global_datos);
					});
					$("#cuerpo-admin").val("");	
					$( this ).dialog( "close" );
				}
			},
			"Cancelar": function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$("#crear-admin").clearForm();
		}
	});
	
	$("#dialog-delete-admin").dialog({
		autoOpen: false,
		resizable: false,
		height: 150,
		modal: true,
		buttons: {
			"Si": function() {
				var global_datos;
				var cn = $(this).data('mycn');
				$.post('/includes/borrar_usuario.php', { cn: cn }, function(datos) {
						global_datos = datos;;
				});
				$('#cuerpo').load('/cobrador/admin.php',function() {
					$(".display-message").html(global_datos);
				});	
				$( this ).dialog( "close" );
				
			},
			"No": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
