<!DOCTYPE html>
<!--[if lt IE 7 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="no-js ie ie6" xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>" lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"> <![endif]-->
<!--[if IE 7 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="no-js ie ie7" xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>" lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"> <![endif]-->
<!--[if IE 8 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="no-js ie ie8" xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>" lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html version="HTML+RDFa 1.1"
	xmlns:fb="https://www.facebook.com/2008/fbml" class="no-js"
	xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"
	lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="<?=theme_img('logo/cn_logo_1.ico');?>"
	type="image/x-icon" />
<title>Claire & Nathalie<?php echo (isset($page_title))?' :: '.$page_title:''; ?></title>

<?php if($this->config->item('kickstrap') == false):?>
<link href="<?php echo theme_css('bootstrap.min.css');?>"
	rel="stylesheet" type="text/css" />
<link href="<?php echo theme_css('bootstrap-responsive.min.css');?>"
	rel="stylesheet" type="text/css" />
<link href="<?php echo theme_css('bootstrap-select.min.css');?>"
	rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo theme_css('jquery-ui.css');?>"
	rel="stylesheet" />
<link type="text/css" href="<?php echo theme_css('redactor.css');?>"
	rel="stylesheet" />
<link type="text/css" href="<?php echo theme_css('file-browser.css');?>"
	rel="stylesheet" />

<!-- <script type="text/javascript" src="<?php echo theme_js('jquery-1.10.2.min.js');?>"></script> -->
<script type="text/javascript" src="<?php echo theme_js('jquery.js');?>"></script>
<script type="text/javascript"
	src="<?php echo theme_js('jquery-ui.js');?>"></script>
<script type="text/javascript"
	src="<?php echo theme_js('bootstrap.min.js');?>"></script>
<script type="text/javascript"
	src="<?php echo theme_js('bootstrap-select.min.js');?>"></script>
<!-- <script type="text/javascript" src="<?php echo theme_js('goedit.js');?>"></script> -->
<script type="text/javascript"
	src="<?php echo theme_js('redactor/redactor_8.2.2.js');?>"></script>
<!-- <script type="text/javascript" src="<?php echo theme_js('redactor/redactor_8.2.2.min.js');?>"></script> -->
<!-- <script type="text/javascript" src="<?php echo theme_js('redactor/redactor_9.1.7.js');?>"></script> -->
<!-- <script type="text/javascript" src="<?php echo theme_js('redactor/redactor_9.1.7.min.js');?>"></script> -->
<!-- <script type="text/javascript" src="http://imperavi.com/js/redactor/redactor.js"></script> -->
<script type="text/javascript"
	src="<?php echo theme_js('redactor/plugins/file-browser.js');?>"></script>
<!-- <script type="text/javascript" src="<?php echo theme_js('redactor/plugins/fontcolor.js');?>"></script> -->
<!-- <script type="text/javascript" src="<?php echo theme_js('redactor/langs/fr.js');?>"></script> -->
<script type="text/javascript"
	src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.0/modernizr.min.js"></script>
<?php else:?>
<?php

	echo '<link href="' . $this->config->item ( 'asset_url' ) . 'default/assets/kickstrap1.3.2/kickstrap.less" type="text/css" rel="stylesheet/less">' . "\n\r";
	;
	echo '<script src="' . $this->config->item ( 'asset_url' ) . 'default/assets/kickstrap1.3.2/Kickstrap/js/less-1.3.3.min.js"></script>' . "\n\r";
	;
	?>
<link type="text/css" href="<?php echo theme_css('jquery-ui.css');?>"
	rel="stylesheet" />
<link type="text/css" href="<?php echo theme_css('redactor.css');?>"
	rel="stylesheet" />
<link type="text/css" href="<?php echo theme_css('file-browser.css');?>"
	rel="stylesheet" />
<?php echo '<script src="' . $this->config->item('asset_url') . 'default/assets/kickstrap1.3.2/Kickstrap/js/jquery-1.8.3.min.js"></script>' . "\n\r"; ?>
<?php echo '<script id="appList" src="' . $this->config->item('asset_url') . 'default/assets/kickstrap1.3.2/Kickstrap/js/kickstrap.js"></script>' . "\n\r"; ?>
<script type="text/javascript"
	src="<?php echo theme_js('jquery-ui.js');?>"></script>
<!-- <script type="text/javascript" src="<?php echo theme_js('goedit.js');?>"></script> -->
<script type="text/javascript"
	src="<?php echo theme_js('redactor/redactor_8.2.2.min.js');?>"></script>
<!-- <script type="text/javascript" src="http://imperavi.com/js/redactor/redactor.js"></script> -->
<script type="text/javascript"
	src="<?php echo theme_js('redactor/plugins/file-browser.js');?>"></script>
<script type="text/javascript"
	src="<?php echo theme_js('redactor/plugins/fontcolor.js');?>"></script>
<script type="text/javascript"
	src="<?php echo theme_js('redactor/langs/fr.js');?>"></script>
<?php endif;?>

<?php if($this->auth->is_logged_in(false, false)):?>
	
<style type="text/css">
body {
	margin-top: 50px;
}

@media ( max-width : 979px) {
	body {
		margin-top: 0px;
	}
}

@media ( min-width : 980px) {
	.nav-collapse.collapse {
		height: auto !important;
		overflow: visible !important;
	}
}

.nav-tabs li a {
	text-transform: uppercase;
	background-color: #f2f2f2;
	border-bottom: 1px solid #ddd;
	text-shadow: 0px 1px 0px #fff;
	filter: dropshadow(color = #fff, offx = 0, offy = 1);
	font-size: 12px;
	padding: 5px 8px;
}

.nav-tabs li a:hover {
	border: 1px solid #ddd;
	text-shadow: 0px 1px 0px #fff;
	filter: dropshadow(color = #fff, offx = 0, offy = 1);
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});

	$('.redactor').redactor({
		imageUpload: '<?php echo site_url($this->config->item('admin_folder').'/media/redactor_upload');?>'
        ,imageUploadErrorCallback: function(json)
        {
            alert(json.error);
        }
        ,focus: true
		,plugins: ['fileBrowser', 'fontcolor']
		,convertDivs: false
		,allowedTags: ['p', 'h1', 'h2', 'div', 'ul', 'li', 'br', 'b', 'em', 'strong', 'span']
		,lang: 'fr'
	});

	/*
	$('.redactor').redactor({
		imageUpload: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/upload_image');?>'
		,fileUpload: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/upload_file');?>'
        ,imageGetJson: '<?php echo site_url(config_item('admin_folder').'/wysiwyg/get_images');?>'
        ,imageUploadErrorCallback: function(json)
        {
            alert(json.error);
        }
    	,fileUploadErrorCallback: function(json)
        {
            alert(json.error);
        }
        ,focus: true
		,convertDivs: false
		,allowedTags: ['p', 'h1', 'h2', 'div', 'ul', 'li', 'br', 'b', 'em', 'strong', 'span']
        ,langs: {
            	fr: {
					html: 'Code HTML',
					video: 'Insérer une vidéo...',
					image: 'Insérer une image...',
					table: 'Tableau',
					link: 'Lien',
					link_insert: 'Insérer un lien...',
					link_edit: 'Modifier le lien',
					unlink: 'Supprimer le lien',
					formatting: 'Styles',
					paragraph: 'Paragraphe',
					quote: 'Citation',
					code: 'Code',
					header1: 'Titre 1',
					header2: 'Titre 2',
					header3: 'Titre 3',
					header4: 'Titre 4',
					header5: 'Titre 5',
					bold:  'Gras',
					italic: 'Italique',
					fontcolor: 'Couleur du texte',
					backcolor: 'Couleur d\'arrière plan du texte',
					unorderedlist: 'Liste à puces',
					orderedlist: 'Liste numérotée',
					outdent: 'Diminuer le retrait',
					indent: 'Augmenter le retrait',
					cancel: 'Annuler',
					insert: 'Insérer',
					save: 'Enregistrer',
					_delete: 'Supprimer',
					insert_table: 'Insérer un tableau...',
					insert_row_above: 'Ajouter une rangée au-dessus',
					insert_row_below: 'Ajouter une rangée en-dessous',
					insert_column_left: 'Ajouter une colonne à gauche',
					insert_column_right: 'Ajouter une colonne à droite',
					delete_column: 'Supprimer la colonne',
					delete_row: 'Supprimer la rangée',
					delete_table: 'Supprimer le tableau',
					rows: 'Rangées',
					columns: 'Colonnes',
					add_head: 'Ajouter un en-tête',
					delete_head: 'Supprimer l\'en-tête',
					title: 'Titre',
					image_position: 'Position',
					none: 'Aucun',
					left: 'Gauche',
					right: 'Droite',
					image_web_link: 'Adresse URL de l\'image',
					text: 'Texte',
					mailto: 'Courriel',
					web: 'Adresse URL',
					video_html_code: 'Code d\'intégration du video',
					file: 'Insérer un fichier...',
					upload: 'Téléverser',
					download: 'Télécharger',
					choose: 'Choisir',
					or_choose: 'Ou choisissez',
					drop_file_here: 'Déposez le fichier ici',
					align_left:	'Aligner à gauche',
					align_center: 'Aligner au centre',
					align_right: 'Aligner à droite',
					align_justify: 'Justifier',
					horizontalrule: 'Insérer une ligne horizontale',
					deleted: 'Supprimé',
					anchor: 'Ancre',
					link_new_tab: 'Ouvrir le lien dans un nouvel onglet',
					underline: 'Souligner',
					alignment: 'Alignement',
					filename: 'Nom de fichier (optionnel)',
					edit: 'Edit'
		            }
		        }
        ,lang: 'fr'
	});
	*/
	
	order_statuses_colors_json_object = <?php echo json_encode((array)$this->config->item('order_statuses_colors')) ?>;
	
});
</script>

<?php endif;?>
</head>
<body>

<?php
/*print_r_html($this->config->item('language'));*/
?>

<?php if($this->auth->is_logged_in(false, false)):?>
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container"><a class="btn btn-navbar" data-toggle="collapse"
	data-target=".nav-collapse"> <span class="icon-bar"></span> <span
	class="icon-bar"></span> <span class="icon-bar"></span> </a>
			
			<?php $admin_url = site_url($this->config->item('admin_folder')).'/';?>
			
			<a class="brand" href="<?php echo $admin_url;?>">Claire & Nathalie |
Admin</a>

<div class="nav-collapse">
<ul class="nav">
	<li><a href="<?php echo $admin_url;?>"><?php echo lang('common_home');?></a></li>
	<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"><?php echo lang('common_sales') ?> <b
		class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="<?php echo $admin_url;?>orders"><?php echo lang('common_orders') ?></a></li>
							<?php if($this->auth->check_access('Admin')) : ?>
							<li><a href="<?php echo $admin_url;?>customers"><?php echo lang('common_customers') ?></a></li>
		<li><a href="<?php echo $admin_url;?>customers/groups"><?php echo lang('common_groups') ?></a></li>
		<li><a href="<?php echo $admin_url;?>reports"><?php echo lang('common_reports') ?></a></li>
		<li><a href="<?php echo $admin_url;?>coupons"><?php echo lang('common_coupons') ?></a></li>
		<li><a href="<?php echo $admin_url;?>giftcards"><?php echo lang('common_giftcards') ?></a></li>
							<?php endif; ?>
						</ul>
	</li>



					<?php
	// Restrict access to Admins only
	if ($this->auth->check_access ( 'Admin' )) :
		?>
					<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"><?php echo lang('common_catalog') ?> <b
		class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="<?php echo $admin_url;?>categories"><?php echo lang('common_categories') ?></a></li>
		<li><a href="<?php echo $admin_url;?>products"><?php echo lang('common_products') ?></a></li>
		<li><a href="<?php echo $admin_url;?>digital_products"><?php echo lang('common_digital_products') ?></a></li>
	</ul>
	</li>

	<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"><?php echo lang('common_content') ?> <b
		class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="<?php echo $admin_url;?>banners"><?php echo lang('common_banners') ?></a></li>
		<li><a href="<?php echo $admin_url;?>boxes"><?php echo lang('common_boxes') ?></a></li>
		<li><a href="<?php echo $admin_url;?>pages"><?php echo lang('common_pages') ?></a></li>
	</ul>
	</li>

	<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"><?php echo lang('common_administrative') ?> <b
		class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="<?php echo $admin_url;?>settings"><?php echo lang('common_settings') ?></a></li>
		<li><a href="<?php echo $admin_url;?>locations"><?php echo lang('common_locations') ?></a></li>
		<li><a href="<?php echo $admin_url;?>admin"><?php echo lang('common_administrators') ?></a></li>
	</ul>
	</li>
					<?php endif; ?>
				</ul>
<ul class="nav pull-right">
	<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"><?php echo lang('common_actions');?> <b
		class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a
			href="<?php echo site_url($this->config->item('admin_folder').'/dashboard');?>"><?php echo lang('common_dashboard') ?></a></li>
		<li><a href="<?php echo site_url();?>"><?php echo lang('common_front_end') ?></a></li>
		<li><a
			href="<?php echo site_url($this->config->item('admin_folder').'/login/logout');?>"><?php echo lang('common_log_out') ?></a></li>
	</ul>
	</li>
</ul>
</div>
<!-- /.nav-collapse --></div>
</div>
<!-- /navbar-inner --></div>
<?php endif;?>
<div class="container">

	<?php if(!empty($base_url) && is_array($base_url)):?>
		<?php if(count($base_url) > 1):?>
		<div class="row">
<div class="span12">
<ul class="breadcrumb">
					<?php
			$url_path = '';
			$count = 1;
			foreach ( $base_url as $bc ) :
				$url_path .= '/' . $bc;
				if ($count == count ( $base_url )) :
					?>
							<li class="active"><?php echo $bc;?></li>
						<?php else:?>
							
							<?php if($bc == 'settings'):?>
							
							<li><a href="<?php echo site_url('/admin/settings');?>"><?php echo $bc;?></a></li>
	<span class="divider">/</span>
							
							<?php elseif($bc == 'view'):?>
							
							<li><a href="<?php echo site_url('/admin/orders');?>"><?php echo $bc;?></a></li>
	<span class="divider">/</span>
							
							<?php else:?>
							
							<li><a href="<?php echo site_url($url_path);?>"><?php echo $bc;?></a></li>
	<span class="divider">/</span>
							
							<?php endif;?>
							
						
				<?php
endif;
				$count ++;
			endforeach
			;
			?>
 					</ul>
</div>
</div>
			<?php endif;?>
	<?php endif;?>
	
	<?php
	//lets have the flashdata overright "$message" if it exists
	if ($this->session->flashdata ( 'message' )) {
		$message = $this->session->flashdata ( 'message' );
	}
	
	if ($this->session->flashdata ( 'error' )) {
		$error = $this->session->flashdata ( 'error' );
	}
	
	if (function_exists ( 'validation_errors' ) && validation_errors () != '') {
		$error = validation_errors ();
	}
	?>
	
	<div id="js_error_container" class="alert alert-error"
	style="display: none;">
<p id="js_error"></p>
</div>

<div id="js_note_container" class="alert alert-note"
	style="display: none;"></div>
	
	<?php if (!empty($message)): ?>
		<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>
			<?php echo $message; ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($error)): ?>
		<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a>
			<?php echo $error; ?>
		</div>
	<?php endif; ?>
</div>

<div class="container">
	<?php if(!empty($page_title)):?>
	<div class="page-header">
		<?php if(TRANSLATABLE):?>
		<h1><?php echo  $page_title; ?><?php echo ($this->session->userdata('db_active_group')?' - en '.(($this->session->userdata('db_active_group') == 'french'?'français':'anglais')):'');?></h1>
		<?php else: ?>
		<h1><?php echo  $page_title; ?></h1>
		<?php endif;?>
	</div>
	<?php endif;?>
	
	