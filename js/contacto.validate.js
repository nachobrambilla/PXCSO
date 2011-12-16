function modificar (mycn) {
	$("#ui-dialog-title-dialog-form").html("Modificar Contacto");		
	$.post('/includes/buscar_contacto_agenda.php', { cn: mycn }, function(datos) {
		datos = $.parseJSON(datos);
		$('#modifica').val(mycn);
		$('#givenname').val(datos.givenname);
		$('#sn').val(datos.sn);
		$('#postaladdress').val(datos.postaladdress);
		$('#mobile').val(datos.mobile);
		$('#telephonenumber').val(datos.telephonenumber);
		$('#homephone').val(datos.homephone);
		$('#contacto_mail').val(datos.mail);
		$('#contacto_mail2').val(datos.mail2);		
	});
	$( "#dialog-form" ).dialog( "open" );
}

function borrar (mycn) {
	$( "#dialog-delete" ).data('mycn', mycn).dialog( "open" );
}


$(document).ready(function() {

	$( "#create-user" ).click(function() {
		$("#ui-dialog-title-dialog-form").html("Crear Contacto");
		$( "#dialog-form" ).dialog( "open" );
	});
	
	
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 600,
		width: 350,
		modal: true,
		buttons: {
			"Continuar" : function() {
				$("#contacto").validate({
					rules: {
						givenname: "required",
						sn: "required",
						contacto_mail: {
							required: true,
							email: true
						},
						contacto_mail2: "email",
						mobile: {
							required: true,
							number: true
						},
						homephone: "number",
						telephonenumber: "number"
					},
					messages: {
						givenname: "<span class='mensajes'>El nombre es obligatorio.</span>",
						sn: "<span class='mensajes'>El apellido es obligatorio.</span>",
						contacto_mail: {
							required: "<span class='mensajes'>El email es obligatorio.</span>",
							email: "<span class='mensajes'>El email debe ser válido.<span>"
						},
						contacto_mail2: "<span class='mensajes'>El email debe ser válido.</span>",
						mobile: {
							required: "<span class='mensajes'>El teléfono es obligatorio.</span>",
							number: "<span class='mensajes'>El teléfono debe ser un número.</span>"
						},
						homephone: "<span class='mensajes'>El teléfono debe ser un número.</span>",
						telephonenumber: "<span class='mensajes'>El teléfono debe ser un número.</span>"
					}
				});
		
				if ( $("#contacto").valid() ) {
					var global_datos;
					$.post('/includes/crear_contacto_agenda.php', $("#contacto").serialize(), function(datos) {
						global_datos = datos;
					});
					$('#cuerpo').load('/cobrador/agenda.php',function() {
						$(".display-message").html(global_datos);
					});
					$("#modifica").val("");	
					$( this ).dialog( "close" );
				}
			},
			"Cancelar": function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$('#modifica').val('');
			$("#contacto").clearForm();
		}
	});
	
	$("#dialog-delete").dialog({
		autoOpen: false,
		resizable: false,
		height: 150,
		modal: true,
		buttons: {
			"Si": function() {
				var global_datos;
				var cn = $(this).data('mycn');
				$.post('/includes/borrar_contacto_agenda.php', { cn: cn }, function(datos) {
						global_datos = datos;;
				});
				$('#cuerpo').load('/cobrador/agenda.php',function() {
					$(".display-message").html(global_datos);
				});	
				$( this ).dialog( "close" );
				
			},
			"No": function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$('#fileInput').uploadify({
		'uploader'  : '/img/uploadify.swf',
		'script'    : '/includes/uploader.php',
		'auto'      : true,
		'folder'    : 'upload_csv',
		'fileExt'	: '*.cvs',
		'sizeLimit' : '153600',
		'buttonImg'   : '/img/boton.png',
		'scriptData' : {'texto': $("#mitexto").val()},
		'onComplete': function(event, queueID, fileObj, response, data) {
 		    $('#cuerpo').load('/cobrador/agenda.php',function(datos) {
						$('#fotosWrapper').append(response);
			});
 		    
		}
	});
});
