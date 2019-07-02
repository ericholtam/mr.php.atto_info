
<div id="atto_info-tab"></div>
<h2 data-i18n="atto_info.title"></h2>


<script>
$(document).on('appReady', function(){
	$.getJSON(appUrl + '/module/atto_info/get_data/' + serialNumber, function(data){
		// Set count of atto_info
		$('#atto_info-cnt').text(data.length);
		var skipThese = ['id', 'serial_number'];
		$.each(data, function(i,d){

			// Generate rows from data
			var rows = ''
			for (var prop in d){
				rows = rows + '<tr><th>'+i18n.t('atto_info.'+prop)+'</th><td>'+d[prop]+'</td></tr>';
				}
			}
			$('#atto_info-tab')
				.append($('<h4>')
					.append($('<i>')
						.addClass('fa fa-hdd-o'))
					.append(' '+d.name))
				.append($('<div>')
					.addClass('table-responsive')
					.append($('<table>')
						.addClass('table table-striped table-condensed')
						.append($('<tbody>')
							.append(rows))))
		})
	});
});
</script>
