function modificar_admin (mycn) {
	$("#ui-dialog-title-dialog-admin").html("Modificar");	
	$.post('/includes/buscar_usuario.php', { cn: mycn }, function(datos) {
		datos = $.parseJSON(datos);
		$('#modifica_cn').val(mycn);
		$('#modifica_departmentNumber_admin').val(datos.mail);
	});
	$( "#dialog-modificar" ).dialog( "open" );
}

function borrar_admin (mycn) {
	$( "#dialog-delete-admin" ).data('mycn', mycn).dialog( "open" );
}


$(document).ready(function() {

	$( "#create-admin" ).click(function() {
		$("#ui-dialog-title-dialog-admin").html("Crear");
		$( "#dialog-admin" ).dialog( "open" );
	});
	
	$( "#dialog-modificar" ).dialog({
		autoOpen: false,
		height: 500,
		width: 350,
		modal: true,
		buttons: {
			"Continuar" : function() {
				$("#modifica-admin").validate({
					rules: {
						modifica_confirma: {
							equalTo: "#modifica_userpassword_admin"
						},
						modifica_habilitado: {
							required: true
						},
						modifica_departmentNumber_admin: {
							required: true
						},
						modifica_voicemailpassword_admin: {
							number: true,
							rangelength: [4, 4]  
						},
						confirma_modifica_voicemailpassword_admin: {              
							equalTo: "#modifica_voicemailpassword_admin" 
						} 
					},
					messages: {
						modifica_habilitado: {
							required: "<span class='mensajes'>Debe especificar si el usuario estará habilitado</span>"
						},
						modifica_departmentNumber_admin: {
							required: "<span class='mensajes'>Debe especificar si el usuario será administrador</span>"
						},
						modifica_confirma: "<span class='mensajes'>Los passwords deben ser iguales.</span>",
						modifica_voicemailpassword_admin: { 
							number: "<br><span class='mensajes'>El password de e Voice Mail debe ser un número de 4 dígitos.</span>",
							rangelength: "<br><span class='mensajes'>El password del Voice Mail debe ser un número de 4 dígitos.</span>"
						},
						confirma_modifica_voicemailpassword_admin: {              
							equalTo: "<br><span class='mensajes'>Los passwords deben ser iguales.</span>" 
						}
					}
				});
		
		
				if ($("#modifica-admin").valid() &&	(($("#modifica_userpassword_admin").val() == ''  && $("#modifica_voicemailpassword_admin").val() == '' ) ||
					($("#modifica_userpassword_admin").val() != ''   && $("#modifica_voicemailpassword_admin").val() != '' )))  {
					
					var global_datos;
					$.post('/includes/modificar_usuario.php', $("#modifica-admin").serialize(), function(datos) {
						global_datos = datos;
					});
					$('#cuerpo-admin').load('/cobrador/admin.php',function() {
						$(".display-message").html(global_datos);
					});
					$("#cuerpo-admin").val("");	
					$( this ).dialog( "close" );
				} else alert('Debe cambiar ambas contraseñas o ninguna');
			},
			"Cancelar": function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$("#modifica-admin").clearForm();
		}
	});
	
	
	$( "#dialog-admin" ).dialog({
		autoOpen: false,
		height: 550,
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
						habilitado: {
							required: true
						},
						departmentNumber_admin: {
							required: true
						},
						userpassword_admin: "required",
						confirma_userpassword_admin: {
							equalTo: "#userpassword_admin"
						},
						voicemailpassword_admin: {
							required: true,
							number: true,
							rangelength: [4, 4]  
						}, 
						confirma_voicemailpassword_admin: {              
							equalTo: "#voicemailpassword_admin" 
						} 
					},
					messages: {
						givenname_admin: "<span class='mensajes'>El nombre es obligatorio.</span>",
						sn_admin: "<span class='mensajes'>El apellido es obligatorio.</span>",
						mail_admin: {
							required: "<span class='mensajes'>El email es obligatorio.</span>",
							email: "<span class='mensajes'>El email debe ser válido.<span>"
						},
						habilitado: {
							required: "<span class='mensajes'>Debe especificar si el usuario estará habilitado</span>"
						},
						departmentNumber_admin: {
							required: "<span class='mensajes'>Debe especificar si el usuario será administrador</span>"
						},
						userpassword_admin: "<span class='mensajes'>El password es obligatorio.</span>",
						confirma_userpassword_admin: "<span class='mensajes'>Los passwords deben ser iguales.</span>",
						voicemailpassword_admin: { 
							required: "<br><span class='mensajes'>El password de Voice Mail es obligatorio.</span>",
							number: "<br><span class='mensajes'>El password de e Voice Mail debe ser un número de 4 dígitos.</span>",
							rangelength: "<br><span class='mensajes'>El password del Voice Mail debe ser un número de 4 dígitos.</span>"
						},
						confirma_voicemailpassword_admin: {              
							equalTo: "<br><span class='mensajes'>Los passwords deben ser iguales.</span>" 
						}
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
						global_datos = datos;
				});
				$('#cuerpo-admin').load('/cobrador/admin.php',function() {
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
