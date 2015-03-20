<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Claire & Nathalie</title>

<?php if($this->config->item('kickstrap') == false):?>
<link
	href="<?php echo base_url(((!preg_match('/localhost/', current_url()))?'':'clairetnathalie/').CONTENT_FOLDER.$this->config->item('theme').'/assets/css/bootstrap.min.css');?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo base_url(((!preg_match('/localhost/', current_url()))?'':'clairetnathalie/').CONTENT_FOLDER.$this->config->item('theme').'/assets/css/bootstrap-responsive.min.css');?>"
	rel="stylesheet" type="text/css" />
<link type="text/css"
	href="<?php echo base_url(((!preg_match('/localhost/', current_url()))?'':'clairetnathalie/').CONTENT_FOLDER.$this->config->item('theme').'/assets/css/jquery-ui.css');?>"
	rel="stylesheet" />
<?php else:?>
<link
	href="<?php echo base_url(((!preg_match('/localhost/', current_url()))?'':'clairetnathalie/').CONTENT_FOLDER.$this->config->item('theme').'/assets/kickstrap1.3.2/kickstrap.less');?>"
	type="text/css" rel="stylesheet/less">
<script
	src="<?php echo base_url(((!preg_match('/localhost/', current_url()))?'':'clairetnathalie/').CONTENT_FOLDER.$this->config->item('theme').'/assets/kickstrap1.3.2/Kickstrap/js/less-1.3.3.min.js');?>"></script>
<?php endif;?>


<?php if($this->config->item('kickstrap') == false):?>
<script type="text/javascript"
	src="<?php echo base_url(((!preg_match('/localhost/', current_url()))?'':'clairetnathalie/').CONTENT_FOLDER.$this->config->item('theme').'/assets/js/jquery.js');?>"></script>
<script type="text/javascript"
	src="<?php echo base_url(((!preg_match('/localhost/', current_url()))?'':'clairetnathalie/').CONTENT_FOLDER.$this->config->item('theme').'/assets/js/jquery-ui.js');?>"></script>
<script type="text/javascript"
	src="<?php echo base_url(((!preg_match('/localhost/', current_url()))?'':'clairetnathalie/').CONTENT_FOLDER.$this->config->item('theme').'/assets/js/bootstrap.min.js');?>"></script>
<?php else:?>
<script
	src="<?php echo base_url(((!preg_match('/localhost/', current_url()))?'':'clairetnathalie/').CONTENT_FOLDER.$this->config->item('theme').'/assets/kickstrap1.3.2/Kickstrap/js/jquery-1.8.3.min.js');?>"></script>
<script id="appList"
	src="<?php echo base_url(((!preg_match('/localhost/', current_url()))?'':'clairetnathalie/').CONTENT_FOLDER.$this->config->item('theme').'/assets/kickstrap1.3.2/Kickstrap/js/kickstrap.js');?>"></script>
<?php endif;?>


<style type="text/css">
/* fix some bootstrap problems */
.btn-mini [class ^="icon-"] {
	margin-top: -1px;
}

.navbar-form .input-append .btn {
	margin-top: 0px;
	padding-left: 2px;
	padding-right: 5px;
}
</style>


<body>

<div class="container-fluid">