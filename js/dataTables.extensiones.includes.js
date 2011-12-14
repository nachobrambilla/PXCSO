function fnFeaturesInit () {
	$('ul.limit_length>li').each( function(i) {
		if ( i > 10 ) {
			this.style.display = 'none';
		}
	} );
	
	
	$('ul.limit_length li.css_link').click( function () {
		$('ul.limit_length li').each( function(i) {
			if ( i > 5 ) {
				this.style.display = 'list-item';
			}
		} );
		$('ul.limit_length li.css_link').css( 'display', 'none' );
	} );
}

$(document).ready( function() {
	$('.timepicker').timepicker();
	fnFeaturesInit();
	$('#extensiones').dataTable( {
		"bJQueryUI": true,
		"bPaginate": false,
		"bFilter": false,
		"bSort": false,
		"bInfo": false
		//"sPaginationType": "full_numbers"
		//"bProcessing": true,
		//"bServerSide": true,
		//"sAjaxSource": '/includes/buscar_contactos_agenda2.php'
	} );
	
	SyntaxHighlighter.all();
} );


