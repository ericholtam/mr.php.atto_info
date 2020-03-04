<?php $this->view('partials/head'); ?>

<?php
//Initialize models needed for the table
new Machine_model;
new Reportdata_model;
new Atto_info_model;
?>

<div class="container">

  <div class="row">

  	<div class="col-lg-12">

	<h3><span data-i18n="atto_info.title"></span> <span id="total-count" class='label label-primary'>…</span></h3>

	  <table class="table table-striped table-condensed table-bordered">

		<thead>
		  <tr>
			<th data-i18n="listing.computername" data-colname='machine.computer_name'></th>
			<th data-i18n="serial" data-colname='reportdata.serial_number'></th>
			<th data-i18n="atto_info.channel" data-colname='atto_info.channel'></th>
			<th data-i18n="atto_info.model" data-colname='atto_info.model'></th>
			<th data-i18n="atto_info.port_state" data-colname='atto_info.port_state'></th>
			<th data-i18n="atto_info.port_address" data-colname='atto_info.port_address'></th>
			<th data-i18n="atto_info.driver_version" data-colname='atto_info.driver_version'></th>
			<th data-i18n="atto_info.firmware_version" data-colname='atto_info.firmware_version'></th>
			<th data-i18n="atto_info.flash_version" data-colname='atto_info.flash_version'></th>
			<th data-i18n="department.department" data-colname='department.department'></th>
		  </tr>
		</thead>

		<tbody>
		  <tr>
			<td data-i18n="listing.loading" colspan="9" class="dataTables_empty"></td>
		  </tr>
		</tbody>

	  </table>

	</div> <!-- /span 12 -->

  </div> <!-- /row -->

</div>  <!-- /container -->

<script type="text/javascript">

	$(document).on('appUpdate', function(e){

		var oTable = $('.table').DataTable();
		oTable.ajax.reload();
		return;

	});

	$(document).on('appReady', function(e, lang) {

        // Get modifiers from data attribute
        var mySort = [], // Initial sort
            hideThese = [], // Hidden columns
            col = 0, // Column counter
            columnDefs = [{ visible: false, targets: hideThese }]; //Column Definitions

        $('.table th').map(function(){

            columnDefs.push({name: $(this).data('colname'), targets: col, render: $.fn.dataTable.render.text()});

            if($(this).data('sort')){
              mySort.push([col, $(this).data('sort')])
            }

            if($(this).data('hide')){
              hideThese.push(col);
            }

            col++
        });

        oTable = $('.table').dataTable( {
            ajax: {
                url: appUrl + '/datatables/data',
                type: "POST",
                data: function(d){
                }
            },
            dom: mr.dt.buttonDom,
            buttons: mr.dt.buttons,
            order: mySort,
            columnDefs: columnDefs,
		    createdRow: function( nRow, aData, iDataIndex ) {

                // Update computer name to link
                var name=$('td:eq(0)', nRow).html();
                var sn=$('td:eq(1)', nRow).html();
                if(sn){
                  var link = mr.getClientDetailLink(name, sn, '#tab_atto_info-tab');
                  $('td:eq(0)', nRow).html(link);
                } 

            } //end fnCreatedRow

        }); //end oTable

	});
</script>


<?php $this->view('partials/foot'); ?>
