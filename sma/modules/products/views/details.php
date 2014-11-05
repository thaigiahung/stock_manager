<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $page_title ." &middot; ". SITE_NAME; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo $this->config->base_url(); ?>assets/css/<?php echo THEME; ?>.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url(); ?>assets/css/sma.css" rel="stylesheet">
<!--[if lt IE 9]>
      <script src="<?php echo $this->config->base_url(); ?>assets/js/html5shiv.js"></script>
<![endif]-->

<style type="text/css">
#one-column-emphasis {
	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
	font-size: 12px;
	margin: 45px;
	width: 480px;
	text-align: left;
	border-collapse: collapse;
}
#one-column-emphasis th {
	font-size: 14px;
	font-weight: normal;
	padding: 12px 15px;
	color: #039;
}
#one-column-emphasis td {
	padding: 10px 15px;
	color: #454545;
	border-bottom: 1px solid #DDD;
}
.oce-first {
	background: #F6F6F6;
	border-right: 10px solid transparent;
	border-left: 10px solid transparent;
	font-weight:bold;
}
#one-column-emphasis tr:hover td {
	color: #333;
	background: #EEE;
}
</style>
</head>
<body>
<div class="row-fluid text-center" style="margin:20px; auto;"> <img src="<?php echo base_url().'assets/img/'.LOGO2; ?>" alt="<?php echo SITE_NAME; ?>"> </div>
<h3 class="title" style="text-align:center;"><?php echo $product->name; ?></h3>
<div style="text-align:center; margin-bottom:15px;"><?php echo $barcode; ?></div>
<table class="table table-bordered table-hover table-striped table-condensed">
  <tbody>
    <tr>
      <td><?php echo $this->lang->line("product_id"); ?></td>
      <td><?php echo $product->id; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_tagname"); ?></td>
      <td><?php echo $product->tagname; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_description"); ?></td>
      <td><?php echo $product->description; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_location"); ?></td>
      <td><?php echo $product->location_in_warehouse; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_construction"); ?></td>
      <td><?php echo $product->construction; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_date_of_issuing"); ?></td>
      <td><?php echo $product->date_of_issuing; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_warehouse"); ?></td>
      <td><?php echo $warehouse->name; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_cert"); ?></td>
      <td><?php echo $product->cert_no; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_date_of_testing"); ?></td>
      <td><?php echo $product->date_of_testing; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_date_of_next_testing"); ?></td>
      <td><?php echo $product->date_of_next_testing; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_status"); ?></td>
      <td><?php echo $product->status; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_remark"); ?></td>
      <td><?php echo $product->remark; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_collecting"); ?></td>
      <td><?php echo $product->collecting; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_date_of_next_testing"); ?></td>
      <td><?php echo $product->date_of_collecting; ?></td>
    </tr>
    <tr>
      <td><?php echo $this->lang->line("product_job_code"); ?></td>
      <td><?php echo $product->job_code; ?></td>
    </tr>
    
  </tbody>
</table>
</body>
</html>