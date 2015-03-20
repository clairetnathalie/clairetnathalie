<!DOCTYPE html>

<!--[if lt IE 7 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="ie ie6" xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>" lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"> <![endif]-->
<!--[if IE 7 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="ie ie7" xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>" lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"> <![endif]-->
<!--[if IE 8 ]><html version="HTML+RDFa 1.1" xmlns:fb="https://www.facebook.com/2008/fbml" class="ie ie8" xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>" lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html version="HTML+RDFa 1.1"
	xmlns:fb="https://www.facebook.com/2008/fbml"
	xml:lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"
	lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>">
<!--<![endif]-->

<?php if ($this->session->userdata('fb_logged_in') == TRUE): ?>
	<head
	prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# maisongueneaumauger: http://ogp.me/ns/apps/maisongueneaumauger#">
<?php else:?>
	


<head
	prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
<?php endif;?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title><?php echo (!empty($seo_title)) ? $seo_title .' - ' : ''; echo $this->config->item('company_name'); ?></title>

<?php if(isset($meta)):?>
	<?php echo $meta;?>
<?php else:?>
<meta name="Keywords" content="<?=$this->lang->line("mgm_keywords");?>">
<meta name="Description"
	content="<?=$this->lang->line("mgm_description");?>">
<?php endif;?>

<link rel="alternate" type="application/vnd.google-earth.kml+xml"
	href="<?=theme_url('assets/coord/clairetnathalie.kml');?>" />
<link rel="alternate" type="application/rdf+xml" title="Geo"
	href="<?=theme_url('assets/coord/Geo.rdf');?>" />

<meta name="publisher"
	content="<?=$this->config->item('company_name');?>">
<meta name="copyright"
	content="<?=$this->config->item('company_name');?>">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="2 days">
<link rel="shortcut icon" href="<?=theme_img('logo/mgm_logo_1.ico');?>"
	type="image/x-icon" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" />
<meta name="geo.position" content="48.08888,-0.75492">
<meta name="geo.country" content="FR">
<meta name="geo.region" content="FR-75">
<meta name="dcterms.language" content="fr">
<meta name="dcterms.type" content="Service">
<meta name="dcterms.format" content="text/html">
<meta name="dcterms.audience" content="all">
<meta name="dcterms.rights"
	content="<?=$this->config->item('company_name');?>">
<meta name="dcterms.publisher"
	content="<?=$this->config->item('company_name');?>">
<meta name="designer" content="flexiness">
<meta http-equiv="content-language"
	content="<?=($this->config->item('language') == 'french')?'fr':'en'?>" />
<meta name="keywords" content="<?=$this->lang->line("mgm_keywords");?>" />
<meta name="description"
	lang="<?=($this->config->item('language') == 'french')?'fr':'en'?>"
	content="<?=$this->lang->line("mgm_description");?>" />
<meta name="dcterms.title"
	content="<?=$this->config->item('company_name');?>" />
<meta name="dcterms.description"
	content="<?=$this->lang->line("mgm_description");?>" />

<meta property="og:site_name"
	content="<?=$this->config->item('company_name');?>" />
<meta property="fb:app_id" content="<?=$fb_appId;?>" />
<meta property="fb:admins" content="707122929" />
<?php if($this->config->item('language') == 'french'):?>
<meta property="og:locale" content="fr_FR" />
<?php elseif($this->config->item('language') == 'english'):?>
<meta property="og:locale" content="en_US" />
<?php endif;?>
<meta property="og:locale:alternate" content="fr_FR" />
<meta property="og:locale:alternate" content="en_US" />
<meta property="og:determiner" content="the" />
<?php if ($this->session->userdata('fb_logged_in') == TRUE): ?>	
<meta property="og:type" content="maisongueneaumauger:website" />
<?php else:?>
<meta property="og:type" content="website" />
<?php endif;?>		
<meta property="og:title"
	content="<?=urlencode($this->config->item('company_name'));?>" />
<meta property="og:description"
	content="<?=urlencode($this->lang->line("mgm_description"));?>" />
<meta property="og:image"
	content="<?=theme_img('logo/mgm_logo_2.png');?>" />
<meta property="og:url" content="<?=current_url(); ?>" />

<link rel="apple-touch-icon"
	href="<?=theme_img('logo/apple-touch-icon.png');?>">
<link rel="apple-touch-icon" sizes="72x72"
	href="<?=theme_img('logo/apple-touch-icon-72x72.png');?>" />
<link rel="apple-touch-icon" sizes="114x114"
	href="<?=theme_img('logo/apple-touch-icon-114x114.png');?>" />
<meta name="viewport"
	content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<!-- <meta name="viewport" content="user-scalable=no, width=320, initial-scale=1.0, maximum-scale=1.0"/> -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-startup-image"
	href="<?=theme_img('logo/logo_lg.png');?>" />

<meta name="google-site-verification"
	content="KJN3HlMPIh932gp-RrQ49qszKwJh_3Hrpeb_5TlhYDc" />

<?php if($this->config->item('kickstrap') == false):?>
<?php

	echo theme_css ( 'bootstrap.min.css', true ) . "\n\r";
	echo theme_css ( 'bootstrap-responsive.min.css', true ) . "\n\r";
	?>
<?php else:?>
<?php

	echo '<link href="' . $this->config->item ( 'asset_url' ) . 'default/assets/kickstrap1.3.2/kickstrap.less" type="text/css" rel="stylesheet/less">' . "\n\r";
	;
	echo '<script src="' . $this->config->item ( 'asset_url' ) . 'default/assets/kickstrap1.3.2/Kickstrap/js/less-1.3.3.min.js"></script>' . "\n\r";
	;
	?>
<?php endif;?>

<?php echo theme_css('styles.css', true) . "\n\r";?>

<?php if(strstr(uri_string(),'place_order')):?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';
		_gaq.push(['_require', 'inpage_linkid', pluginUrl]);
		_gaq.push(['_setAccount', 'UA-40529120-2']);
		_gaq.push(['_trackPageview']);
		
		// transaction ID - required
		// affiliation or store name
		// total - required
		// tax
		// shipping
		// city
		// state or province
		// country
		
		_gaq.push(['_addTrans',
		  '<?php echo $order_id ?>',
		  'Maison Gueneau Mauger Boutique eCommerce',
		  '<?php echo $this->go_cart->total(); ?>',
		  '<?php echo $this->go_cart->order_tax(); ?>',
		  '<?php echo $this->go_cart->shipping_cost(); ?>',
		  '<?php echo $customer['bill_address']['city']; ?>',
		  '<?php echo $customer['bill_address']['zone']; ?>',
		  '<?php echo $customer['bill_address']['country']; ?>'
		]);
		
		// add item might be called for every item in the shopping cart
		// where your ecommerce engine loops through each item in the cart and
		// prints out _addItem for each

		<?php foreach ($this->go_cart->contents() as $cartkey=>$product):?>
		<?php /*$prod_categories = simplexml_load_string($product['category_xml_navigation']);*/?>

		// transaction ID - required
		// SKU/code - required
		// product name
		// category or variation
		// unit price - required
		// quantity - required
		
		_gaq.push(['_addItem',
		  '<?php echo $order_id ?>',
		  '<?php echo $product['id'] ;?>',
		  '<?php echo (isset($product['description'])) ? $product['description'] : $product['excerpt'];?>',
		  '<?php /*echo $prod_categories->marque[0];*/?><?php /*echo ' | '$prod_categories->objet[0];*/?><?php /*echo '| '$prod_categories->taille[0];*/?>',
		  '<?php echo $product['price']; ?>',
		  '<?php echo $product['quantity']; ?>'
		]);
		
		<?php endforeach; ?>
		
		_gaq.push(['_trackTrans']); //submits transaction to the Analytics servers
		
		(function() {
		  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		  //ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; // no remarketing
		  ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js'; // with remarketing
		  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
<?php else:?> 
	
<?php endif;?>


<?php
//with this I can put header data in the header instead of in the body.
if (isset ( $additional_header_info )) {
	echo $additional_header_info;
}

?>

<base href="<?=base_url();?>" />

</head>

<body itemscope itemtype="http://schema.org/WebPage">

<?php if($this->config->item('kickstrap') == false):?>

<?php echo theme_js('jquery.js', true) . "\n\r";?>
<?php echo theme_js('bootstrap.min.js', true) . "\n\r";?>

<?php else:?>

<?php echo '<script src="' . $this->config->item('asset_url') . 'default/assets/kickstrap1.3.2/Kickstrap/js/jquery-1.8.3.min.js"></script>' . "\n\r"; ?>
<?php echo '<script id="appList" src="' . $this->config->item('asset_url') . 'default/assets/kickstrap1.3.2/Kickstrap/js/kickstrap.js"></script>' . "\n\r"; ?>

<?php endif;?>

<?php /*echo html_helper_tag_manager() . "\n\r";*/ ?>

<?php echo theme_js('squard.js', true) . "\n\r";?>
<?php echo theme_js('equal_heights.js', true) . "\n\r";?>

<?php

echo '<script src="http://code.createjs.com/createjs-2013.05.14.min.js"></script>' . "\n\r";
?>
	
	<!-- START NAV -->
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container"><!-- .btn-navbar is used as the toggle for collapsed navbar content -->
<a class="btn btn-navbar" data-toggle="collapse"
	data-target=".nav-collapse"> <span class="icon-bar"></span> <span
	class="icon-bar"></span> <span class="icon-bar"></span> </a>

<div xmlns="http://www.w3.org/1999/xhtml"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
	xmlns:xsd="http://www.w3.org/2001/XMLSchema#"
	xmlns:gr="http://purl.org/goodrelations/v1#"
	xmlns:foaf="http://xmlns.com/foaf/0.1/"
	xmlns:vcard="http://www.w3.org/2006/vcard/ns#"><a class="brand"
	href="<?php echo site_url();?>"><?php echo $this->config->item('company_name');?></a>

<div about="#company" typeof="gr:BusinessEntity">
<div property="gr:legalName" content="Maison Gueneau Mauger S.A.S"></div>

<div rel="vcard:adr">
<div typeof="vcard:Address">
<div property="vcard:country-name" content="France"></div>
<div property="vcard:locality" content="Laval"></div>
<div property="vcard:postal-code" content="53000"></div>
<div property="vcard:street-address" content="6, rue Léonard de Vinci"></div>
</div>
</div>
<div property="vcard:email" content="contact@clairetnathalie.com"></div>
<div rel="vcard:geo">
<div>
<div property="vcard:latitude" content="48.088877" datatype="xsd:float"></div>
<div property="vcard:longitude" content="-0.754924" datatype="xsd:float"></div>
</div>
</div>

<div rel="foaf:depiction"
	resource="<?=theme_img('logo/mgm_logo_2.png');?>"></div>
<div rel="foaf:page" resource=""></div>
</div>

</div>

<div class="nav-collapse">
<ul class="nav">
	<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"><?php echo lang('catalog');?> <b class="caret"></b></a>
	<ul class="dropdown-menu">
								<?php foreach($this->categories as $cat_menu):?>
								<li><a
			href="<?php echo site_url($cat_menu['category']->slug);?>"><?php echo $cat_menu['category']->name;?></a></li>
								<?php endforeach;?>
							</ul>
							
							<?php foreach($this->pages as $menu_page):?>

								
	
	
	<li>
								<?php if(empty($menu_page->content)):?>
									<a href="<?php echo $menu_page->url;?>"
		<?php if($menu_page->new_window ==1){echo 'target="_blank"';} ?>><?php echo $menu_page->menu_title;?></a>
								<?php else:?>
									<a href="<?php echo site_url($menu_page->slug);?>"><?php echo $menu_page->menu_title;?></a>
								<?php endif;?>
								</li>
								
							<?php endforeach;?>
					</ul>

<ul class="nav pull-right">
						
						<?php if($this->Customer_model->is_logged_in(false, false)):?>
							<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"><?php echo lang('account');?> <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="<?php echo  site_url('secure/my_account');?>"><?php echo lang('my_account');?></a></li>
		<li><a href="<?php echo  site_url('secure/my_downloads');?>"><?php echo lang('my_downloads');?></a></li>
		<li class="divider"></li>
		<li><a href="<?php echo site_url('secure/logout');?>"><?php echo lang('logout');?></a></li>
	</ul>
	</li>
						<?php else: ?>
							<li><a href="<?php echo site_url('secure/login');?>"><?php echo lang('login');?></a></li>
						<?php endif; ?>
							<li><a href="<?php echo site_url('cart/view_cart');?>">
								<?php
								if ($this->go_cart->total_items () == 0) {
									echo lang ( 'empty_cart' );
								} else {
									if ($this->go_cart->total_items () > 1) {
										echo sprintf ( lang ( 'multiple_items' ), $this->go_cart->total_items () );
									} else {
										echo sprintf ( lang ( 'single_item' ), $this->go_cart->total_items () );
									}
								}
								?>
								</a></li>
</ul>
					
					<?php echo form_open('cart/search', 'class="navbar-search pull-right"');?>
						<input type="text" name="term" class="search-query span2"
	placeholder="<?php echo lang('search');?>" />
</form>
</div>
</div>
</div>
</div>
<!-- END NAV -->

<!-- START MAIN CONTAINER -->
<div class="main container"
	<?php echo (strstr(uri_string(),'product'))?'itemscope itemtype="http://schema.org/ItemPage"':'itemscope itemtype="http://schema.org/CollectionPage"';?>>
		<?php if(!empty($base_url) && is_array($base_url)):?>
			<?php if(count($base_url) > 1):?>
			<div class="row">
<div class="span12">
<ul class="breadcrumb" itemprop="breadcrumb">
						<?php
				$url_path = '';
				$count = 1;
				foreach ( $base_url as $bc ) :
					$url_path .= '/' . $bc;
					if ($count == count ( $base_url )) :
						?>
								<li class="active"><?php echo $bc;?></li>
							<?php else:?>
								<li><a href="<?php echo site_url($url_path);?>"><?php echo $bc;?></a></li>
	<span class="divider">/</span>
							
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
		
		<?php if ($this->session->flashdata('message')):?>
			<div class="alert alert-info"><a class="close" data-dismiss="alert">×</a>
				<?php echo $this->session->flashdata('message');?>
			</div>
		<?php endif;?>
		
		<?php if ($this->session->flashdata('error')):?>
			<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a>
				<?php echo $this->session->flashdata('error');?>
			</div>
		<?php endif;?>
		
		<?php if (!empty($error)):?>
			<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a>
				<?php echo $error;?>
			</div>
		<?php endif;?>
		
		

<?php
/*
End header.php file
*/