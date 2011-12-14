$(document).ready(function() {
	$( "#tabs" ).tabs({
		ajaxOptions: {
			error: function( xhr, status, index, anchor ) {
				$( anchor.hash ).html("La pestaña no se pudo cargar");
			}
		}
	});

	$( "#dialog-confirm" ).dialog({
		autoOpen: false,
		resizable: false,
		height:150,
		modal: true,
		buttons: {
			"Si": function() {
				$( this ).dialog( "close" );
				window.location.replace("/includes/cerrar_sesion.php");
			},
			"No": function() {
				$( this ).dialog( "close" );
			}
		}
	}); 

	$("#sesion").submit(function(){
		$('#dialog-confirm').dialog('open');
    	return false;
	});
});

