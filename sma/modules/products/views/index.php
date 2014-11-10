<script src="<?php echo base_url(); ?>assets/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/725b2a2115b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="//datatables.net/release-datatables/extensions/ColReorder/js/dataTables.colReorder.js"></script>
<style type="text/css">
.text_filter { width: 100% !important; font-weight: normal !important; border: 0 !important; box-shadow: none !important;  border-radius: 0 !important;  padding:0 !important; margin:0 !important; font-size: 1em !important;}
.select_filter { width: 100% !important; padding:0 !important; height: auto !important; margin:0 !important;}
</style>
<script>
            $(document).ready(function() {
                $('#prData').dataTable( {                	
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "bFilter": false,
                    "iDisplayLength": <?php echo ROWS_PER_PAGE; ?>,                    
                    <?php if(BSTATESAVE) { echo '"bStateSave": true,'; } ?>
					'bProcessing'    : true,
					'bServerSide'    : true,
					<?php $no_cost = array('salesman', 'viewer'); 
	                            if (!$this->ion_auth->in_group($no_cost)) { 
					?>
                    'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=products&view=getdatatableajaxcost',
                        <?php } else { ?>
                    'sAjaxSource'    : '<?php echo base_url(); ?>index.php?module=products&view=getdatatableajax',
                        <?php } ?>
					'fnServerData': function(sSource, aoData, fnCallback)
					{
						aoData.push( { "name": "<?php echo $this->security->get_csrf_token_name(); ?>", "value": "<?php echo $this->security->get_csrf_hash() ?>" } );
					  $.ajax
					  ({
						'dataType': 'json',
						'type'    : 'POST',
						'url'     : sSource,
						'data'    : aoData,
						'success' : fnCallback
					  });
					},		
					/*"sDom": 'T<"clear">lfrtip',				
					"oTableTools": {
						"sSwfPath": "assets/media/swf/copy_csv_xls_pdf.swf",
						"sCharSet": "utf-8",
						"aButtons": [
								{
									"sExtends": "csv",
									"sFileName": "<?php echo $this->lang->line("products"); ?>.csv",
                   		 			"mColumns": [ 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19<?php $no_cost = array('salesman', 'viewer'); 
							if (!$this->ion_auth->in_group($no_cost)) { echo ', 6'; } ?> ]
								},
								{
									"sExtends": "pdf",
									"sFileName": "<?php echo $this->lang->line("products"); ?>.pdf",
									"sPdfOrientation": "landscape",
                   		 			"mColumns": [ 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19<?php $no_cost = array('salesman', 'viewer'); 
							if (!$this->ion_auth->in_group($no_cost)) { echo ', 6'; } ?> ]
								},
								"print"
						]
					},*/
					"aoColumns": [ 
					  null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null,
					  <?php $no_cost = array('salesman', 'viewer'); 
					  		if (!$this->ion_auth->in_group($no_cost)) { 
					  
					  echo "null,";
					  }
					  ?>
					  { "bSortable": false }
					],
					"columnDefs": [
			            { "visible": false, "targets": [0,1,2,3] },
			            { "orderable": false, "targets": [4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19] }
			        ],
					"drawCallback": function ( settings ) {
			            var api = this.api();
			            var rows = api.rows( {page:'current'} ).nodes();
			            var last=null;
			            var last_sub_cat = null;
			 
			            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
			                if ( last !== group ) {		                	
			                	api.column(2, {page:'current'} ).data().each( function ( group2, i2 ) {
			                		if(i == i2)
			                		{
    				                	$(rows).eq( i2 ).before(			                		
    			                		    '<tr class="group"><td style="background-color: #6699FF; color: black;">' + group2 +'</td><td colspan="16" style="background-color: #6699FF; color: black;">'+group+'</td></tr>'
    			                		);	
			                		}			                			                		
			                	});		                	
			                    last = group;
			                }
			            } );

			            api.column(1, {page:'current'} ).data().each( function ( group1, i1 ) {
			                if ( last_sub_cat !== group1 ) {
			                	api.column(3, {page:'current'} ).data().each( function ( group3, i3 ) {
			                		if(i1 == i3)
			                		{
			                			$(rows).eq( i1 ).before(
			                			    '<tr class="sub-group"><td style="background-color: #CCCCCC; color: black;">' + group3 +'</td><td colspan="16" style="background-color: #CCCCCC; color: black;">'+group1+'</td></tr>'
			                			);
			                		}		                		
			                	});			                    
			                    last_sub_cat = group1;
			                }
			            } );

		                $('tbody').find('.sub-group').each(function (i,v) {	
		                    var rowCount = $(this).nextUntil('.sub-group, .group').length;		                    
		                    $(this).find('td:last').append($('<span />', { 'class': 'rowCount-grid' }).append($('<b />', { 'text': ' (Sub-total: ' + rowCount +')' })));		                             
		                });
			        }
					
                } )/*.columnFilter({ aoColumns: [
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						{ type: "text", bRegex:true },
						<?php $no_cost = array('salesman', 'viewer'); 
							if (!$this->ion_auth->in_group($no_cost)) { 
								echo '{ type: "text", bRegex:true },';
							}
						?>
						{ type: "text", bRegex:true },
						null
                     ]})*/;
			
			$('#fileData').on('click', '.image', function() {
				var a_href = $(this).attr('href');
				var code = $(this).attr('id');
				$('#myModalLabel').text(code);
				$('#product_image').attr('src',a_href);
				$('#picModal').modal();
				return false;
			});
			$('#fileData').on('click', '.barcode', function() {
				var a_href = $(this).attr('href');
				var code = $(this).attr('id');
				$('#myModalLabel').text(code);
				$('#product_image').attr('src',a_href);
				$('#picModal').modal();
				return false;
			});
			
				
            });
                    
</script>
        
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
<?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>
<div class="btn-group pull-right" style="margin-left: 25px;">
 <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
<?php echo $this->lang->line("all_warehouses"); ?>
<span class="caret"></span>
</a>
<ul class="dropdown-menu">
    <?php
	foreach($warehouses as $warehouse) {
		echo "<li><a href='index.php?module=products&view=warehouse&warehouse_id=".$warehouse->id."'>".$warehouse->name."</a></li>";	
	}
	?>
    </ul>
    </div>
<h3 class="title"><?php echo $page_title; ?></h3>

	<!-- <p class="introtext"><?php echo $this->lang->line("list_results"); ?></p> -->
    
    <div>
		<table id="prData" class="table table-bordered table-hover table-striped table-condensed" style="margin-bottom: 5px; min-width: 2500px;">
			<thead>
		        <tr>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("category"); ?></th>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("subcategories"); ?></th>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("category_code"); ?></th>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("subcategory_code"); ?></th>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("product_id"); ?></th>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("product_description"); ?></th>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("product_tagname"); ?></th>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("product_location"); ?></th>
					<th style="background-color: #75A319;color: black;" colspan="4"><?php echo $this->lang->line("product_where_now"); ?></th>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("product_cert"); ?></th>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("product_date_of_testing"); ?></th>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("product_date_of_next_testing"); ?></th>
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("product_status"); ?></th>     
					<th style="background-color: #75A319;color: black;" rowspan="2"><?php echo $this->lang->line("product_remark"); ?></th> 
					<th style="background-color: #3399FF;color: black;" colspan="3"><?php echo $this->lang->line("product_cargo_manifest"); ?></th>
		            <th rowspan="2" style=" background-color: #75A319;color: black; min-width:115px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th> 
				</tr>
		        <tr>					
					<th style="background-color: #75A319;color: black;"><?php echo $this->lang->line("product_construction"); ?></th>
					<th style="background-color: #75A319;color: black;"><?php echo $this->lang->line("product_date_of_issuing"); ?></th>
					<th style="background-color: #75A319;color: black;"><?php echo $this->lang->line("product_warehouse"); ?></th>
					<th style="background-color: #75A319;color: black;"><?php echo $this->lang->line("product_date_of_storage"); ?></th>
					<th style="background-color: #3399FF;color: black;"><?php echo $this->lang->line("product_collecting"); ?></th>                
					<th style="background-color: #3399FF;color: black;"><?php echo $this->lang->line("product_date_of_collecting"); ?></th>     
					<th style="background-color: #3399FF;color: black;"><?php echo $this->lang->line("product_job_code"); ?></th>
				</tr>
	        </thead>
			<tbody>
		
				<tr>
	            	<td colspan="9" class="dataTables_empty">Loading data from server</td>
				</tr>

	        </tbody>
	        
	        <tfoot>
	        <!-- <tr>
	        	<th>[<?php echo $this->lang->line("category"); ?>]</th>
	        	<th>[<?php echo $this->lang->line("subcategories"); ?>]</th>
	        	<th>[<?php echo $this->lang->line("category_code"); ?>]</th>
	        	<th>[<?php echo $this->lang->line("subcategory_code"); ?>]</th>
	        	<th>[<?php echo $this->lang->line("product_id"); ?>]</th>
	        	<th>[<?php echo $this->lang->line("product_description"); ?>]</th>
	        				<th>[<?php echo $this->lang->line("product_tagname"); ?>]</th>
	        				<th>[<?php echo $this->lang->line("product_location"); ?>]</th>
	        				<th>[<?php echo $this->lang->line("product_construction"); ?>]</th>
	        				<th>[<?php echo $this->lang->line("product_date_of_issuing"); ?>]</th>
	        				<th>[<?php echo $this->lang->line("product_warehouse"); ?>]</th>
	        				<th>[<?php echo $this->lang->line("product_date_of_storage"); ?>]</th>
	        				<th>[<?php echo $this->lang->line("product_cert"); ?>]</th>
	        				<th>[<?php echo $this->lang->line("product_date_of_testing"); ?>]</th>
	        				<th>[<?php echo $this->lang->line("product_date_of_next_testing"); ?>]</th>
	        				<th>[<?php echo $this->lang->line("product_status"); ?>]</th>    
	        				<th>[<?php echo $this->lang->line("product_remark"); ?>]</th>            
	        				<th>[<?php echo $this->lang->line("product_collecting"); ?>]</th>    
	        				<th>[<?php echo $this->lang->line("product_date_of_collecting"); ?>]</th>    
	        				<th>[<?php echo $this->lang->line("product_job_code"); ?>]</th>    
	            <th style="width:115px; text-align:center;"><?php echo $this->lang->line("actions"); ?></th> 
	        			</tr> -->
	        </tfoot>
		</table>
    </div>
	
	
	<a href="<?php echo site_url('module=products&view=add');?>" class="btn btn-primary pull-left"><?php echo $this->lang->line("add_product"); ?></a> 
    <div class="btn-group dropup pull-left" style="margin-left:15px; margin-bottom:20px;">
 <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->lang->line("all_warehouses"); ?>
<span class="caret"></span>
</a>
<ul class="dropdown-menu">
    <?php
	foreach($warehouses as $warehouse) {
		echo "<li><a href='index.php?module=products&view=warehouse&warehouse_id=".$warehouse->id."'>".$warehouse->name."</a></li>";	
	}
	?>
    </ul>
    </div>
    
<div id="picModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="picModalLabel" aria-hidden="true">
 <div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel"></h3>
</div>
<div class="modal-body" style="text-align:center; height:200px;">
<img id="product_image" src="" style="height:100%;" />
</div>
<div class="modal-footer">
<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
</div>
</div>