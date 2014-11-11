<style type="text/css">
.loader { background-color: #CF4342; color: white; top: 30%; left: 50%; margin-left: -50px; position: fixed; padding: 3px; width:100px;	height:100px; background:url('<?php echo $this->config->base_url(); ?>assets/img/wheel.gif') no-repeat center; }
.blackbg { z-index: 5000; background-color: #666; -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)"; filter: alpha(opacity=20); opacity: 0.2; width:100%; height:100%; top:0; left:0; position:absolute;}
</style>
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-fileupload.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(document).ready(function(){ 
	$('form').form();
		$('#category').change(function() {
			var v = $(this).val();
			$('#loading').show();
					$.ajax({
					  type: "get",
					  async: false,
					  url: "index.php?module=products&view=getSubCategories",
					  data: { <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", category_id: v },
					  dataType: "html",
					  success: function(data) {
						if(data != "") {
							$('#subcat_data').empty();
							$('#subcat_data').html(data);
						} else {
							$('#subcat_data').empty();
							var default_data = '<select name="subcategory" class="span4" id="subcategory" data-placeholder="<?php echo $this->lang->line("select_category_to_load"); ?>"></select>';
							$('#subcat_data').html(default_data);
							bootbox.alert('<?php echo $this->lang->line('no_subcategory'); ?>');
						}
					  },
					  error: function(){
       					bootbox.alert('<?php echo $this->lang->line('ajax_error'); ?>');
						$('#loading').hide();
    				  }
					  
					});
					$("form select").chosen({no_results_text: "No results matched", disable_search_threshold: 5, allow_single_deselect:true });
					$('#loading').hide();
		});

    $(".date").datepicker({
        format: "<?php echo JS_DATE; ?>",
        autoclose: true
    });
    $(".date").datepicker("setDate");
	});

</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

	<h3 class="title"><?php echo $page_title; ?></h3>
	<p><?php echo $this->lang->line("enter_product_info"); ?></p>
    
	<?php $attrib = array('class' => 'form-horizontal'); echo form_open_multipart("module=products&view=edit&id=".$id, $attrib); ?>

<div class="control-group">
  <label class="control-label" for="description"><?php echo $this->lang->line("product_description"); ?></label>
  <div class="controls"> <?php echo form_input('description', $product->description, 'class="span4 tip" id="description" required="required" data-error="'.$this->lang->line("product_description").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>

<div class="control-group">
  <label class="control-label" for="tagname"><?php echo $this->lang->line("product_tagname"); ?></label>
  <div class="controls"> <?php echo form_input('tagname', $product->tagname, 'class="span4 tip" id="tagname" title="'.$this->lang->line("pr_tagname_tip").'" required="required" data-error="'.$this->lang->line("product_tagname").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>

<div class="control-group">
  <label class="control-label" for="location_in_warehouse"><?php echo $this->lang->line("product_location"); ?></label>
  <div class="controls"> <?php echo form_input('location_in_warehouse', $product->location_in_warehouse, 'class="span4 tip" id="location_in_warehouse"'); ?> </div>
</div>

<div class="control-group">
  <label class="control-label" for="construction"><?php echo $this->lang->line("product_construction"); ?></label>
  <div class="controls"> <?php echo form_input('construction', $product->construction, 'class="span4 tip" id="construction"'); ?> </div>
</div>

<div class="control-group">
    <label class="control-label" for="date_of_issuing"><?php echo $this->lang->line("product_date_of_issuing"); ?></label>
    <div class="controls"> <?php echo form_input('date_of_issuing', $product->date_of_issuing, 'class="span4 date" id="date_of_issuing"'); ?></div>
</div>

<div class="control-group">
    <label class="control-label" id="warehouse_l"><?php echo $this->lang->line("warehouse"); ?></label>
    <div class="controls">  
        <?php
            $wh[''] = '';
            foreach ($warehouses as $warehouse) {
                $wh[$warehouse->id] = $warehouse->name;
            }
            echo form_dropdown('warehouse', $wh, $selected_warehouse->warehouse_id, 'id="warehouse_s" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("warehouse") . '" required="required" data-error="' . $this->lang->line("warehouse") . ' ' . $this->lang->line("is_required") . '"');
        ?> 
    </div>
</div>

<div class="control-group">
  <label class="control-label" for="category"><?php echo $this->lang->line("category"); ?></label>
  <div class="controls">  <?php 
    $cat[''] = "";
      foreach($categories as $category) {
        $cat[$category->id] = $category->name;
    }
    echo form_dropdown('category', $cat, $product->category_id, 'class="tip chzn-select span4" id="category" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("category").'" title="'.$this->lang->line("pr_category_tip").'" required="required" data-error="'.$this->lang->line("category").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>

<div class="control-group">
  <label class="control-label" for="subcategory"><?php echo $this->lang->line("subcategory"); ?></label>
  <div class="controls" id="subcat_data"> <?php 
      $sct[""] = '';
      foreach($subcategories as $subcategory) {
        $sct[$subcategory->id] = $subcategory->name;
    }
      echo form_dropdown('subcategory', $sct, $product->subcategory_id, 'class="span4" id="subcategory" required="required" data-placeholder="'.$this->lang->line("select_category_to_load").'"');  ?> </div>
</div>

<div class="control-group">
    <label class="control-label" for="date_of_storage"><?php echo $this->lang->line("product_date_of_storage"); ?></label>
    <div class="controls"> <?php echo form_input('date_of_storage', $product->date_of_storage, 'class="span4 date" id="date_of_storage"'); ?></div>
</div>

<div class="control-group">
  <label class="control-label" for="cert_no"><?php echo $this->lang->line("product_cert"); ?></label>
  <div class="controls"> <?php echo form_input('cert_no', $product->cert_no, 'class="span4 tip" id="cert_no"'); ?> </div>
</div>

<div class="control-group">
    <label class="control-label" for="date_of_testing"><?php echo $this->lang->line("product_date_of_testing"); ?></label>
    <div class="controls"> <?php echo form_input('date_of_testing', $product->date_of_testing, 'class="span4 date" id="date_of_testing"'); ?></div>
</div>

<div class="control-group">
    <label class="control-label" for="date_of_next_testing"><?php echo $this->lang->line("product_date_of_next_testing"); ?></label>
    <div class="controls"> <?php echo form_input('date_of_next_testing', $product->date_of_testing, 'class="span4 date" id="date_of_next_testing"'); ?></div>
</div>

<div class="control-group">
  <label class="control-label" for="status"><?php echo $this->lang->line("product_status"); ?></label>
  <div class="controls"> <?php echo form_input('status', $product->status, 'class="span4 tip" id="status"'); ?> </div>
</div>

<div class="control-group">
  <label class="control-label" for="remark"><?php echo $this->lang->line("product_remark"); ?></label>
  <div class="controls"> <?php echo form_input('remark', $product->remark, 'class="span4 tip" id="remark"'); ?> </div>
</div>

<div class="control-group">
  <label class="control-label" for="collecting"><?php echo $this->lang->line("product_collecting"); ?></label>
  <div class="controls"> <?php var_dump($product->collecting); echo form_checkbox('collecting','', $product->collecting === "1" ? true : false, 'class="span4" id="collecting"'); ?> </div>
</div>

<div class="control-group">
    <label class="control-label" for="date_of_collecting"><?php echo $this->lang->line("product_date_of_collecting"); ?></label>
    <div class="controls"> <?php echo form_input('date_of_collecting', $product->date_of_collecting, 'class="span4 date" id="date_of_collecting"'); ?></div>
</div>

<div class="control-group">
  <label class="control-label" for="job_code"><?php echo $this->lang->line("product_job_code"); ?></label>
  <div class="controls"> <?php echo form_input('job_code', $product->job_code, 'class="span4" id="job_code"'); ?> </div>
</div>

<div class="control-group">
  <label class="control-label" for="cf1"><?php echo $this->lang->line("pcf1"); ?></label>
  <div class="controls"> <?php echo form_input('cf1', $product->cf1, 'class="span4" id="cf1"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="cf2"><?php echo $this->lang->line("pcf2"); ?></label>
  <div class="controls"> <?php echo form_input('cf2', $product->cf2, 'class="span4" id="cf2"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="cf3"><?php echo $this->lang->line("pcf3"); ?></label>
  <div class="controls"> <?php echo form_input('cf3', $product->cf3, 'class="span4" id="cf3"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="cf4"><?php echo $this->lang->line("pcf4"); ?></label>
  <div class="controls"> <?php echo form_input('cf4', $product->cf4, 'class="span4" id="cf4"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="cf5"><?php echo $this->lang->line("pcf5"); ?></label>
  <div class="controls"> <?php echo form_input('cf5', $product->cf5, 'class="span4" id="cf5"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="cf6"><?php echo $this->lang->line("pcf6"); ?></label>
  <div class="controls"> <?php echo form_input('cf6', $product->cf6, 'class="span4" id="cf6"');?>
  </div>
</div> 
        
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("update_product"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
<div id="loading" style="display: none;">
<div class="blackbg"></div><div class="loader"></div>
</div>
